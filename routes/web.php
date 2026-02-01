<?php

use App\Http\Controllers\ProfileController; // Corrected to App\Http\Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPetController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\AccessoriesController;
use App\Models\Accessories;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Mail\OrderPlacedNotification;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\TotalProductsController;

// Include auth routes first
require __DIR__.'/auth.php';

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/pets', [PetController::class, 'index'])->name('user.pets.index');
Route::get('/pets/{pet}', [PetController::class, 'show'])->name('user.pets.show');

Route::get('login', function(){
    return view('auth.login');
})->name('login');

Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

//MENU
Route::get('/services', [MenuController::class, 'services'])->name('services');


Route::middleware(['auth', 'verified'])->group(function () {
    // Test route for order placed email notification
    Route::get('/test-order-email', function () {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $order = Order::with('user')->latest()->where('user_id', $user->id)->first();
        if (!$order) {
            return 'No orders found for user.';
        }
        Mail::to($user->email)->send(new OrderPlacedNotification($order));
        return 'Test order confirmation email sent to ' . $user->email;
    })->name('test.order.email');
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Testimonial submission route
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

    // Pet routes
    Route::get('/pets', [App\Http\Controllers\User\PetController::class, 'index'])->name('user.pets.index');
    Route::get('/pets/{pet}', [App\Http\Controllers\User\PetController::class, 'show'])->name('user.pets.show');
    Route::post('/pets/{pet}/cart', [App\Http\Controllers\User\PetController::class, 'addToCart'])->name('user.pets.add-to-cart');

    // Food routes
    Route::get('/food', [App\Http\Controllers\User\FoodController::class, 'index'])->name('user.food.index');
    Route::get('/food/{food}', [App\Http\Controllers\User\FoodController::class, 'show'])->name('user.food.show');
    Route::post('/food/{food}/cart', [App\Http\Controllers\User\FoodController::class, 'addToCart'])->name('user.food.add-to-cart');

    // Accessories cart routes
    Route::post('/accessories/{accessory}/cart', [App\Http\Controllers\User\AccessoriesController::class, 'addToCart'])->name('user.accessories.add-to-cart');
    
    // Accessories routes
    Route::get('/accessories', [App\Http\Controllers\User\AccessoriesController::class, 'index'])->name('user.accessories.index');
    Route::get('/accessories/{accessory}', [App\Http\Controllers\User\AccessoriesController::class, 'show'])->name('user.accessories.show');

    // Cart routes
    Route::get('/cart', [App\Http\Controllers\User\PetController::class, 'cart'])->name('user.cart.index');
    Route::get('/cart/checkout', [App\Http\Controllers\User\PetController::class, 'checkout'])->name('user.cart.checkout');
    Route::post('/cart/checkout', [App\Http\Controllers\User\PetController::class, 'checkout'])->name('user.cart.checkout');
    Route::delete('/cart/{cartItem}', [App\Http\Controllers\User\PetController::class, 'removeFromCart'])->name('user.cart.remove');
    Route::patch('/cart/{cartItem}/update', [PetController::class, 'update'])->name('user.cart.update'); 

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PayMongo webhook route
    Route::post('/paymongo/webhook', [App\Http\Controllers\PayMongoWebhookController::class, 'handle'])->name('paymongo.webhook');

    // Temporary route to manually update order payment status for testing without webhooks
    Route::post('/order/{order}/update-status', function (\Illuminate\Http\Request $request, $orderId) {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);
        $order = App\Models\Order::findOrFail($orderId);
        $order->payment_status = $request->payment_status;
        $order->save();
        return response()->json(['message' => 'Order payment status updated', 'order' => $order]);
    })->name('order.update-status');

    // PayMongo GCash payment return URL
    Route::get('/payment/return', [App\Http\Controllers\User\PetController::class, 'paymentReturn'])->name('payment.return');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('pets', PetController::class);
    Route::resource('accessories', AccessoriesController::class);
    Route::resource('food', FoodController::class);

    // Admin customer list route
    Route::get('/customers', [App\Http\Controllers\Admin\AdminCustomerController::class, 'index'])->name('customers.index');

    // Admin order routes for COD approval
    Route::get('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/update-status', [App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Total products route
    Route::get('/totals/products', [TotalProductsController::class, 'index'])->name('totals.products');
});
