

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Edit Pet</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">
    <link rel="stylesheet" href="{{ asset('css/Sidebar.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
<!-- Sidebar -->
<div class="sidebar expanded fixed left-4 top-4 h-[calc(100vh-2rem)] bg-white rounded-2xl p-4 z-50">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <span class="sidebar-title">pawhaven</span>
        <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6 text-gray-600 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Items -->
    <nav class="space-y-2 flex flex-col h-full">
        <div>
            <a href="{{ route('admin.totals.products') }}" class="flex items-center p-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.totals.products') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4v17M20 4v17" />
                </svg>
                <span class="nav-text ml-3">Totals</span>
            </a>
            <a href="{{ route('admin.pets.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.pets.*') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="nav-text ml-3">Pets</span>
            </a>
            <a href="{{ route('admin.accessories.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.accessories.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 014 12V7a4 4 0 013-4z" />
                </svg>
                <span class="nav-text ml-3">Accessories</span>
            </a>
            <a href="{{ route('admin.food.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.food.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4" />
                </svg>
                <span class="nav-text ml-3">Food</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="nav-text ml-3">Orders</span>
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="nav-text ml-3">Customer List</span>
            </a>
        </div>
        <hr class="my-4">

        <!-- Bottom section - positioned at the bottom of the nav -->
        <div class="absolute bottom-0 left-0 right-0 p-4">
            <div class="flex flex-col space-y-2">
                <a href="" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('images/default-profile.png') }}" 
                        alt="Admin Profile" 
                        class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="text-gray-900 font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-sm">Administrator</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="nav-text ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>  

        <!-- Main Content -->
        <div class="main-content flex-1 ml-[270px] p-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Pet</h2>
                        <a href="{{ route('admin.pets.index') }}" class="text-blue-600 hover:text-blue-800">
                            Back to Pets
                        </a>
                    </div>

                    <form action="{{ route('admin.pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Pet Images -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Pet Images</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Main Image -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Main Image</label>
                                    <div class="image-preview selected" data-image="1">
                                        <img src="{{ asset('storage/' . $pet->pet_image1) }}" alt="Main Image" class="w-full h-48 object-cover rounded-lg">
                                        <span class="main-image-badge">Main Image</span>
                                        <input type="file" name="pet_image1" class="hidden" accept="image/*">
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="text-sm text-blue-600 hover:text-blue-800" onclick="document.querySelector('input[name=pet_image1]').click()">
                                            Change Image
                                        </button>
                                    </div>
                                    @error('pet_image1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Additional Images -->
                                @for($i = 2; $i <= 5; $i++)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Image {{ $i-1 }}</label>
                                        <div class="image-preview" data-image="{{ $i }}">
                                            @if($pet->{'pet_image'.$i})
                                                <img src="{{ asset('storage/' . $pet->{'pet_image'.$i}) }}" alt="Additional Image {{ $i-1 }}" class="w-full h-48 object-cover rounded-lg">
                                            @else
                                                <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <span class="text-gray-400">No image</span>
                                                </div>
                                            @endif
                                            <span class="main-image-badge">Main Image</span>
                                            <input type="file" name="pet_image{{ $i }}" class="hidden" accept="image/*">
                                        </div>
                                        <div class="mt-2 flex justify-between">
                                            <button type="button" class="text-sm text-blue-600 hover:text-blue-800" onclick="document.querySelector('input[name=pet_image{{ $i }}]').click()">
                                                {{ $pet->{'pet_image'.$i} ? 'Change Image' : 'Add Image' }}
                                            </button>
                                            @if($pet->{'pet_image'.$i})
                                                <button type="button" class="text-sm text-red-600 hover:text-red-800" onclick="removeImage({{ $i }})">
                                                    Remove
                                                </button>
                                            @endif
                                        </div>
                                        @error('pet_image'.$i)
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endfor
                            </div>
                            <input type="hidden" name="main_image" id="main_image" value="1">
                        </div>

                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $pet->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">category</label>
                                    <input type="text" name="category" value="{{ old('category', $pet->category) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Breed</label>
                                    <input type="text" name="breed" value="{{ old('breed', $pet->breed) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('breed')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Age (years)</label>
                                    <input type="number" step="0.1" name="age" value="{{ old('age', $pet->age) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('age')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                                    <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Color</label>
                                    <input type="text" name="color" value="{{ old('color', $pet->color) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('color')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Price (₱)</label>
                                    <input type="number" name="price" value="{{ old('price', $pet->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" name="quantity" value="{{ old('quantity', $pet->quantity) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                        <option value="Adopted" {{ old('status') == 'Adopted' ? 'selected' : '' }}>Adopted</option>
                                        <option value="Reserved" {{ old('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Description</h3>
                            <div>
                                <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $pet->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Pet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('javascript/Sidebar.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image Preview and Selection
            const imagePreviews = document.querySelectorAll('.image-preview');
            const mainImageInput = document.getElementById('main_image');

            // Set initial main image selection
            const currentMainImage = "{{ $pet->main_image ?? 1 }}";
            document.querySelector(`.image-preview[data-image="${currentMainImage}"]`).classList.add('selected');
            mainImageInput.value = currentMainImage;

            imagePreviews.forEach(preview => {
                // Handle image selection
                preview.addEventListener('click', function() {
                    // Remove selected class from all previews
                    imagePreviews.forEach(p => p.classList.remove('selected'));
                    // Add selected class to clicked preview
                    this.classList.add('selected');
                    // Update main image input
                    mainImageInput.value = this.dataset.image;
                });

                // Handle file input change
                const fileInput = this.querySelector('input[type="file"]');
                fileInput.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = preview.querySelector('img');
                            if (img) {
                                img.src = e.target.result;
                            } else {
                                const newImg = document.createElement('img');
                                newImg.src = e.target.result;
                                newImg.className = 'w-full h-48 object-cover rounded-lg';
                                preview.innerHTML = '';
                                preview.appendChild(newImg);
                                preview.appendChild(document.createElement('span')).className = 'main-image-badge';
                                preview.appendChild(fileInput);
                            }
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
        });

        function removeImage(imageNumber) {
            if (confirm('Are you sure you want to remove this image?')) {
                const preview = document.querySelector(`.image-preview[data-image="${imageNumber}"]`);
                preview.innerHTML = `
                    <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400">No image</span>
                    </div>
                    <span class="main-image-badge">Main Image</span>
                    <input type="file" name="pet_image${imageNumber}" class="hidden" accept="image/*">
                `;
            }
        }
    </script>
</body>
</html> 