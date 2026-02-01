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
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <button id="closeTestimonialModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="text-xl font-semibold mb-4">Leave a Testimonial</h3>
                <form method="POST" action="{{ route('testimonials.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 font-medium mb-2">Comment</label>
                        <textarea id="comment" name="comment" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="rating" class="block text-gray-700 font-medium mb-2">Rating</label>
                        <div class="flex space-x-1">
                            <input type="radio" id="star5" name="rating" value="5" required class="hidden" />
                            <label for="star5" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">&#9733;</label>
                            <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                            <label for="star4" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">&#9733;</label>
                            <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                            <label for="star3" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">&#9733;</label>
                            <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                            <label for="star2" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">&#9733;</label>
                            <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                            <label for="star1" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400">&#9733;</label>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-md hover:bg-purple-700 transition duration-200">Submit</button>
                </form>
            </div>
        </div>
    </footer>