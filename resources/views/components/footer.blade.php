<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeIn 0.3s ease-out forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .modal-exit {
            animation: modalExit 0.3s ease-in;
        }
        @keyframes modalExit {
            from {
                opacity: 1;
                transform: scale(1);
            }
            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }
    </style>
</head>
<body>
    <!-- Footer -->
    <footer class="px-6 py-12 bg-gray-900 text-white relative">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <h3 class="text-xl font-bold mb-4">Nest</h3>
                <input type="email" placeholder="Enter your email" class="w-full px-4 py-2 rounded-full text-black">
                <button class="mt-2 px-4 py-2 bg-white text-black rounded-full hover:bg-gray-200">Subscribe</button>
                <!-- Testimonial Modal Trigger -->
                <button id="openTestimonialModal" class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-full text-sm font-medium hover:bg-purple-700 transition duration-200">
                    Leave a Testimonial
                </button>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Shop</h3>
                <a href="#" class="block hover:text-gray-400">All Products</a>
                <a href="#" class="block hover:text-gray-400">Categories</a>
                <a href="#" class="block hover:text-gray-400">Wishlist</a>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Information</h3>
                <a href="#" class="block hover:text-gray-400">Shipping Policy</a>
                <a href="#" class="block hover:text-gray-400">Returns & Refunds</a>
                <a href="#" class="block hover:text-gray-400">FAQs</a>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Company</h3>
                <a href="#" class="block hover:text-gray-400">About Us</a>
                <a href="#" class="block hover:text-gray-400">Privacy Policy</a>
                <a href="#" class="block hover:text-gray-400">Terms & Conditions</a>
            </div>
        </div>
        <p class="text-center mt-8">© Pawhaven 2025</p>

        <!-- Testimonial Modal -->
        <div id="testimonialModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative modal-enter">
                <button id="closeTestimonialModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Leave a Testimonial</h3>
                <form method="POST" action="{{ route('testimonials.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="rating" class="block text-gray-700 font-medium mb-2">Rating</label>
                        <div class="flex space-x-1">
                            <input type="radio" id="star1" name="rating" value="1" required class="hidden" />
                            <label for="star1" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">★</label>
                            <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                            <label for="star2" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">★</label>
                            <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                            <label for="star3" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">★</label>
                            <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                            <label for="star4" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">★</label>
                            <input type="radio" id="star5" name="rating" value="5" class="hidden" />
                            <label for="star5" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">★</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 font-medium mb-2">Comment</label>
                        <textarea id="comment" name="comment" rows="4" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 text-gray-900 placeholder-gray-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-md hover:bg-purple-700 transition duration-200">Submit</button>
                </form>
            </div>
        </div>
    </footer>
    <button
        x-data="{ hovering: false }"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        @mouseenter="hovering = true"
        @mouseleave="hovering = false"
        :class="hovering ? 'w-36 px-4' : 'w-12 px-0'"
        class="fixed bottom-8 right-8 bg-blue-300 hover:bg-blue-600 text-white rounded-full shadow-lg h-12 flex items-center justify-center overflow-hidden transition-all duration-300 ease-in-out"
        aria-label="Back to top"
    >
        <!-- Up Arrow Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 transition-all duration-300 z-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
        <!-- Back to Top Text -->
        <span
            class="ml-2 whitespace-nowrap transition-all duration-300 ease-in-out"
            :class="hovering ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-2'"
        >
            Back to top
        </span>
    </button>

    <script src="{{ asset('javascript/testimonials.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            ratingInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const selectedRating = parseInt(this.value);
                    const labels = document.querySelectorAll('label[for^="star"]');
                    labels.forEach(label => {
                        const starValue = parseInt(label.getAttribute('for').replace('star', ''));
                        if (starValue <= selectedRating) {
                            label.classList.remove('text-gray-300');
                            label.classList.add('text-yellow-400');
                        } else {
                            label.classList.remove('text-yellow-400');
                            label.classList.add('text-gray-300');
                        }
                    });
                });
            });

            // Initial state based on existing selection (if any)
            const initialSelected = document.querySelector('input[name="rating"]:checked');
            if (initialSelected) {
                const selectedRating = parseInt(initialSelected.value);
                const labels = document.querySelectorAll('label[for^="star"]');
                labels.forEach(label => {
                    const starValue = parseInt(label.getAttribute('for').replace('star', ''));
                    if (starValue <= selectedRating) {
                        label.classList.remove('text-gray-300');
                        label.classList.add('text-yellow-400');
                    } else {
                        label.classList.remove('text-yellow-400');
                        label.classList.add('text-gray-300');
                    }
                });
            }
        });
    </script>
</body>
</html>