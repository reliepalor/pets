<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order, {{ $order->user->name }}!</h1>
    <p>We have received your order with the following details:</p>

    <h2>Order Summary</h2>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>
                {{ $item->item->name }} ({{ ucfirst(class_basename($item->item_type)) }}) x {{ $item->quantity }} - ₱{{ number_format($item->price * $item->quantity, 2) }}
            </li>
        @endforeach
    </ul>

    <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
    <p><strong>Shipping Address:</strong></p>
    <p>
        {{ $order->street_address }}<br>
        {{ $order->city }}, {{ $order->province }}<br>
        {{ $order->postal_code }}<br>
        {{ $order->country }}
    </p>

    <p>If you have any questions, feel free to contact our support team.</p>

    <p>Thank you for shopping with us!</p>
</body>
</html>
