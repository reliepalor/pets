<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accessory Details</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col items-center p-8">
        <h1 class="text-3xl font-bold mb-6">Accessory Details</h1>
        <div class="bg-white p-6 rounded shadow-md w-full max-w-3xl">
            <h2 class="text-2xl font-semibold mb-4">{{ $accessory->name }}</h2>
            <p><strong>Category:</strong> {{ $accessory->category }}</p>
            <p><strong>Price:</strong> ₱{{ number_format($accessory->price, 2) }}</p>
            <p><strong>Stock:</strong> {{ $accessory->stock }}</p>
            <p><strong>Color:</strong> {{ $accessory->color }}</p>
            <p><strong>Size:</strong> {{ $accessory->size }}</p>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($accessory->{'image' . $i})
                        <img src="{{ asset('storage/' . $accessory->{'image' . $i}) }}" alt="Image {{ $i }}" class="rounded shadow-md">
                    @endif
                @endfor
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.accessories.index') }}" class="text-blue-600 hover:underline">Back to Accessories</a>
            </div>
        </div>
    </div>
</body>
</html>
