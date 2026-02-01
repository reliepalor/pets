<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Pet;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Psr\Log\LoggerInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accessories;
use App\Models\Food;

class PetController extends Controller
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
        $query = Pet::query();
    
        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('breed')) {
            $query->where('breed', $request->breed);
        }
        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }
        if ($request->filled('gender')) {
            $query->whereRaw('LOWER(gender) = ?', [strtolower($request->gender)]);
        }
        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }
        if ($request->filled('status')) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
    
        // Fetch breeds based on category
        $category = $request->input('category');
        $breeds = Pet::select('breed')
            ->distinct()
            ->when($category, function ($q) use ($category) {
                return $q->where('category', $category);
            })
            ->pluck('breed');
    
        // Get filtered pets
        $pets = $query->latest()->get();

        // Calculate total and available pets
        $totalPets = Pet::count();
        $availablePets = Pet::where('quantity', '>', 0)->count();
    
        return view('user.pets.index', compact('pets', 'breeds', 'totalPets', 'availablePets'));
    }

    public function show(Pet $pet)
    {
        return view('user.pets.show', compact('pet'));
    }

    public function addToCart(Request $request, Pet $pet)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add pets to your cart.');
        }

        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $pet->quantity,
            ]);

            $existing = CartItem::where('user_id', Auth::id())
                ->where('item_type', Pet::class)
                ->where('item_id', $pet->id)
                ->first();

            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $request->quantity]);
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'item_type' => Pet::class,
                    'item_id' => $pet->id,
                    'quantity' => $request->quantity,
                ]);
            }

            return redirect()->route('user.cart.index')
                ->with('success', 'Pet added to cart successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add pet to cart: ' . $e->getMessage());
        }
    }

    public function cart()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }

        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('item')
            ->get()
            ->filter(function ($cartItem) {
                return $cartItem->item !== null;
            });

        $total = $cartItems->sum(function ($item) {
            return $item->item->price * $item->quantity;
        });

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to update your cart.');
        }

        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('user.cart.index')->with('error', 'Unauthorized action.');
        }

        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $cartItem->item->quantity,
            ]);

            $cartItem->update(['quantity' => $request->quantity]);

            return redirect()->route('user.cart.index')->with('success', 'Cart updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user.cart.index')->with('error', 'Failed to update cart: ' . $e->getMessage());
        }
    }

    public function removeFromCart(Request $request, CartItem $cartItem)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to manage your cart.');
        }

        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('user.cart.index')->with('error', 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->route('user.cart.index')->with('success', 'Item removed from cart.');
    }

    public function paymentReturn(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');

        if (!$paymentIntentId) {
            return redirect()->route('user.pets.index')->with('error', 'Invalid payment return.');
        }

        // Find the order with this payment intent
        $order = Order::where('transaction_id', $paymentIntentId)->first();

        if (!$order) {
            return redirect()->route('user.pets.index')->with('error', 'Order not found.');
        }

        // Here you might want to verify payment status with PayMongo API or webhook
        // For simplicity, we assume payment is successful if this return is called

        $order->payment_status = 'paid';
        $order->save();

        return redirect()->route('user.pets.index')->with('success', 'Payment successful. Thank you for your order!');
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to proceed with checkout.');
        }

        $productId = $request->input('product_id');
        $productType = $request->input('product_type');
        $quantity = $request->input('quantity', 1);
        $selectedItems = $request->input('selected_items', []);

        // Initialize cart items and total
        $cartItems = collect();
        $total = 0;

        if ($productId && $productType) {
            // Handle single product checkout
            switch ($productType) {
                case 'pet':
                    $item = Pet::find($productId);
                    $itemType = Pet::class;
                    break;
                case 'accessory':
                    $item = Accessories::find($productId);
                    $itemType = Accessories::class;
                    break;
                case 'food':
                    $item = Food::find($productId);
                    $itemType = Food::class;
                    break;
                default:
                    return redirect()->back()->with('error', 'Invalid product type.');
            }

            if (!$item) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            $cartItems->push((object)[
                'item_type' => $itemType,
                'item' => $item,
                'quantity' => $quantity,
            ]);
            $total = $item->price * $quantity;
        } else {
            // Handle cart items checkout
            if (empty($selectedItems)) {
                // If no items selected, get all cart items for the user
                $cartItems = CartItem::where('user_id', Auth::id())
                    ->with('item')
                    ->get();
            } else {
                $cartItems = CartItem::where('user_id', Auth::id())
                    ->whereIn('id', $selectedItems)
                    ->with('item')
                    ->get();
            }

            if ($cartItems->isEmpty()) {
                return redirect()->route('user.cart.index')->with('error', 'Your cart is empty.');
            }

            $total = $cartItems->sum(function ($item) {
                return $item->item->price * $item->quantity;
            });
        }

        // If it's a GET request, show the checkout page
        if ($request->isMethod('get')) {
            return view('user.cart.checkout', [
                'cartItems' => $cartItems,
                'total' => $total,
                'productId' => $productId,
                'productType' => $productType,
                'quantity' => $quantity
            ]);
        }

        // Handle POST request for processing the order
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

                $paymentUrl = $attachResponse['data']['attributes']['next_action']['redirect']['url'];

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
                        'item_id' => $item->item->id,
                        'quantity' => $item->quantity,
                        'price' => $item->item->price,
                    ]);
                }

                if ($productId) {
                    // Handle single product checkout
                    if ($productType === 'pet') {
                        $pet = Pet::find($productId);
                        if ($pet) {
                            $pet->update(['status' => 'Sold Out']);
                        }
                    } else {
                        $item = $productType === 'accessory' ? Accessories::find($productId) : Food::find($productId);
                        if ($item) {
                            $item->decrement('stock', $quantity);
                        }
                    }
                } else {
                    // Handle cart items checkout
                    CartItem::whereIn('id', $selectedItems)->delete();
                }

                DB::commit();

                return redirect($paymentUrl);
            } else {
                // Handle Cash on Delivery
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
                        'item_id' => $item->item->id,
                        'quantity' => $item->quantity,
                        'price' => $item->item->price,
                    ]);
                }

                if ($productId) {
                    // Handle single product checkout
                    if ($productType === 'pet') {
                        $pet = Pet::find($productId);
                        if ($pet) {
                            $pet->update(['status' => 'Sold Out']);
                        }
                    } else {
                        $item = $productType === 'accessory' ? Accessories::find($productId) : Food::find($productId);
                        if ($item) {
                            $item->decrement('stock', $quantity);
                        }
                    }
                } else {
                    // Handle cart items checkout
                    CartItem::whereIn('id', $selectedItems)->delete();
                }

                DB::commit();

                // Send order confirmation email
                Mail::to(Auth::user()->email)->send(new \App\Mail\OrderPlacedNotification($order));

                return redirect()->route('user.cart.index')
                    ->with('success', 'Order placed successfully.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('user.cart.checkout')
                ->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}
