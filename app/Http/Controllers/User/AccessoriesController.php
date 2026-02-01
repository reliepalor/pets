<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Accessories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PayMongoService;
use Psr\Log\LoggerInterface;

class AccessoriesController extends Controller
{
    protected $paymongo;
    protected $logger;

    public function __construct(PayMongoService $paymongo, LoggerInterface $logger)
    {
        $this->paymongo = $paymongo;
        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Accessories::query();

        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort by
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
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $accessories = $query->get();
        $categories = Accessories::distinct()->pluck('category');

        if ($request->ajax()) {
            return response()->json([
                'accessories' => $accessories,
            ]);
        }

        return view('user.accessories.index', compact('accessories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Accessories $accessory)
    {
        // No need for $accessory = Accessories::findOrFail($id); as model binding will automatically fetch the accessory
        return view('user.accessories.show', compact('accessory'));
    }
    
    public function addToCart(Request $request, Accessories $accessory)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add accessories to your cart.');
        }

        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $accessory->stock,
            ]);

            $existing = CartItem::where('user_id', Auth::id())
                ->where('item_type', Accessories::class)
                ->where('item_id', $accessory->id)
                ->first();

            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $request->quantity]);
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'item_type' => Accessories::class,
                    'item_id' => $accessory->id,
                    'quantity' => $request->quantity,
                ]);
            }

            return redirect()->route('user.cart.index')->with('success', 'Accessory added to cart successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add accessory to cart: ' . $e->getMessage());
        }
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to proceed with checkout.');
        }

        $cartItems = CartItem::where('user_id', Auth::id())
            ->where('item_type', Accessories::class)
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

                    $this->logger->info('Payment Intent Response in checkout', ['response' => $paymentIntentResponse]);

                    if (isset($paymentIntentResponse['errors'])) {
                        throw new \Exception('PayMongo error: ' . json_encode($paymentIntentResponse['errors']));
                    }

                    $paymentIntentId = $paymentIntentResponse['data']['id'];

                    $returnUrl = route('payment.return');
                    $paymentMethodResponse = $this->paymongo->createPaymentMethod('gcash', ['return_url' => $returnUrl]);

                    $this->logger->info('Payment Method Response in checkout', ['response' => $paymentMethodResponse]);

                    if (isset($paymentMethodResponse['errors'])) {
                        throw new \Exception('PayMongo error: ' . json_encode($paymentMethodResponse['errors']));
                    }

                    $paymentMethodId = $paymentMethodResponse['data']['id'];

                    $attachResponse = $this->paymongo->attachPaymentMethodToIntent($paymentIntentId, $paymentMethodId);

                    $this->logger->info('Attach Payment Method Response in checkout', ['response' => $attachResponse]);

                    if (isset($attachResponse['errors'])) {
                        throw new \Exception('PayMongo error: ' . json_encode($attachResponse['errors']));
                    }

                    $paymentUrl = null;
                    if (isset($attachResponse['data']['attributes']['next_action']['redirect']['url'])) {
                        $paymentUrl = $attachResponse['data']['attributes']['next_action']['redirect']['url'];
                    } elseif (isset($attachResponse['data']['attributes']['next_action']['use_sdk']['raw']['next_action']['redirect']['url'])) {
                        $paymentUrl = $attachResponse['data']['attributes']['next_action']['use_sdk']['raw']['next_action']['redirect']['url'];
                    }

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

                        if ($item->item_type === Accessories::class) {
                            $accessory = Accessories::find($item->item_id);
                            $accessory->stock = max(0, $accessory->stock - $item->quantity);
                            $accessory->save();
                        }
                    }

                    CartItem::where('user_id', Auth::id())
                        ->where('item_type', Accessories::class)
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
                        ->where('item_type', Accessories::class)
                        ->delete();

                    DB::commit();

                    return redirect()->route('user.accessories.index')
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
