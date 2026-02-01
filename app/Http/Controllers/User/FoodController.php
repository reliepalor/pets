<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PayMongoService;
use Psr\Log\LoggerInterface;

class FoodController extends Controller
{
    protected $paymongo;
    protected $logger;

    public function __construct(PayMongoService $paymongo, LoggerInterface $logger)
    {
        $this->paymongo = $paymongo;
        $this->logger = $logger;
    }

    public function index(Request $request)
    {
        $query = Food::query()->where('status', 'available');

        if ($request->filled('pet_type')) {
            $query->where('pet_type', $request->pet_type);
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $foods = $query->get();

        // Get distinct brands and pet types for filter dropdowns
        $brands = Food::select('brand')->distinct()->pluck('brand');
        $petTypes = Food::select('pet_type')->distinct()->pluck('pet_type');

        if ($request->ajax()) {
            return response()->json([
                'foods' => $foods,
            ]);
        }

        return view('user.food.index', compact('foods', 'brands', 'petTypes'));
    }

    public function show(Food $food)
    {
        return view('user.food.show', compact('food'));
    }

    public function addToCart(Request $request, Food $food)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add food to your cart.');
        }

        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $food->stock,
            ]);

            $existing = CartItem::where('user_id', Auth::id())
                ->where('item_type', Food::class)
                ->where('item_id', $food->id)
                ->first();

            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $request->quantity]);
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'item_type' => Food::class,
                    'item_id' => $food->id,
                    'quantity' => $request->quantity,
                ]);
            }

            return redirect()->route('user.cart.index')->with('success', 'Food item added to cart successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add food to cart: ' . $e->getMessage());
        }
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to proceed with checkout.');
        }

        $cartItems = CartItem::where('user_id', Auth::id())
            ->where('item_type', Food::class)
            ->with('item')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->item->price * $item->quantity;
        });

        if ($request->isMethod('post')) {
            $request->validate([
                'payment_method' => 'required|in:gcash,cod',
            ]);

            try {
                DB::beginTransaction();

                if ($request->payment_method === 'gcash') {
                    $amountInCents = intval($total * 100);
                    $paymentIntentResponse = $this->paymongo->createPaymentIntent($amountInCents, ['gcash']);

                    if (isset($paymentIntentResponse['errors'])) {
                        throw new \Exception('PayMongo error: ' . json_encode($paymentIntentResponse['errors']));
                    }

                    $paymentIntentId = $paymentIntentResponse['data']['id'];
                    $returnUrl = route('payment.return');
                    $paymentMethodResponse = $this->paymongo->createPaymentMethod('gcash', ['return_url' => $returnUrl]);

                    if (isset($paymentMethodResponse['errors'])) {
                        throw new \Exception('PayMongo error: ' . json_encode($paymentMethodResponse['errors']));
                    }

                    $paymentMethodId = $paymentMethodResponse['data']['id'];
                    $attachResponse = $this->paymongo->attachPaymentMethodToIntent($paymentIntentId, $paymentMethodId);

                    if (isset($attachResponse['errors'])) {
                        throw new \Exception('PayMongo error: ' . json_encode($attachResponse['errors']));
                    }

                    $paymentUrl = $attachResponse['data']['attributes']['next_action']['redirect']['url']
                        ?? null;

                    if (!$paymentUrl) {
                        throw new \Exception('Failed to get payment URL from PayMongo.');
                    }

                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'total_amount' => $total,
                        'payment_method' => 'gcash',
                        'payment_status' => 'pending',
                        'street_address' => Auth::user()->street_address,
                        'city' => Auth::user()->city,
                        'province' => Auth::user()->province,
                        'postal_code' => Auth::user()->postal_code,
                        'country' => Auth::user()->country,
                        'transaction_id' => $paymentIntentId,
                    ]);

                    foreach ($cartItems as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'item_type' => $item->item_type,
                            'item_id' => $item->item_id,
                            'quantity' => $item->quantity,
                            'price' => $item->item->price,
                        ]);

                        $foodItem = Food::find($item->item_id);
                        $foodItem->stock = max(0, $foodItem->stock - $item->quantity);
                        $foodItem->save();
                    }

                    CartItem::where('user_id', Auth::id())
                        ->where('item_type', Food::class)
                        ->delete();

                    DB::commit();

                    return redirect($paymentUrl);
                } else {
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'total_amount' => $total,
                        'payment_method' => 'cod',
                        'payment_status' => 'pending',
                        'street_address' => Auth::user()->street_address,
                        'city' => Auth::user()->city,
                        'province' => Auth::user()->province,
                        'postal_code' => Auth::user()->postal_code,
                        'country' => Auth::user()->country,
                        'transaction_id' => null,
                    ]);

                    foreach ($cartItems as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'item_type' => $item->item_type,
                            'item_id' => $item->item_id,
                            'quantity' => $item->quantity,
                            'price' => $item->item->price,
                        ]);
                    }

                    CartItem::where('user_id', Auth::id())
                        ->where('item_type', Food::class)
                        ->delete();

                    DB::commit();

                    return redirect()->route('user.food.index')
                        ->with('success', 'Order placed successfully.');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('user.cart.checkout')
                    ->with('error', 'Failed to place order: ' . $e->getMessage());
            }
        }

        return view('user.cart.checkout', compact('cartItems', 'total'));
    }
}
