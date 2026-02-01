document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const secondaryNav = document.getElementById('secondary-nav');
    const filterToggle = document.getElementById('filterToggle');
    const filterButton = document.getElementById('filter-button');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterSidebar = document.getElementById('filterSidebar');
    const closeFilter = document.getElementById('closeFilter');
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const mobileSearchInput = document.getElementById('mobileSearchInput');
    const accessoriesGrid = document.getElementById('accessoriesGrid');
    const emptyMessage = document.querySelector('#accessoriesGrid .text-center');

    // Scroll-based hide/show for secondary navbar
    let lastScrollTop = 0;
    window.addEventListener('scroll', () => {
        let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        if (currentScroll > lastScrollTop && currentScroll > 50) {
            secondaryNav.style.transform = 'translateY(-100%)';
        } else if (currentScroll < lastScrollTop) {
            secondaryNav.style.transform = 'translateY(0)';
        }
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    });

    // Fade-in animations
    const elements = document.querySelectorAll('.fade-in');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    elements.forEach(element => observer.observe(element));

    // Close filter function
    function closeFilter() {
        filterSidebar.classList.remove('active');
        filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Open filter function
    function openFilter() {
        filterSidebar.classList.add('active');
        filterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Filter toggle for mobile (secondary nav button)
    if (filterToggle) {
        filterToggle.addEventListener('click', openFilter);
    }

    // Filter button for mobile (fixed button)
    if (filterButton) {
        filterButton.addEventListener('click', openFilter);
    }

    // Close filter on overlay click
    if (filterOverlay) {
        filterOverlay.addEventListener('click', closeFilter);
    }

    // Close filter on X button click
    if (closeFilter) {
        closeFilter.addEventListener('click', closeFilter);
    }

    // Prevent clicks inside the filter sidebar from closing it
    if (filterSidebar) {
        filterSidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Handle form submission
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(filterForm);
            const queryParams = new URLSearchParams();
            for (let [key, value] of formData.entries()) {
                if (value) {
                    queryParams.append(key, value);
                }
            }
            window.location.href = `${filterForm.action}?${queryParams.toString()}`;
        });
    }

    // AJAX search functionality
    function ajaxSearch(input, form) {
        if (input && form) {
            input.addEventListener('input', function(e) {
                const searchTerm = e.target.value;

                const formData = new FormData(form);
                formData.set(input.name, searchTerm);

                const queryParams = new URLSearchParams();
                for (let [key, value] of formData.entries()) {
                    if (value) {
                        queryParams.append(key, value);
                    }
                }

                fetch(`${form.action}?${queryParams.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Clear current accessories grid
                    accessoriesGrid.innerHTML = '';

                    if (data.accessories.length === 0) {
                        accessoriesGrid.innerHTML = `
                            <div class="col-span-full text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No accessories found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                            </div>
                        `;
                        return;
                    }

                    // Render accessories
                    data.accessories.forEach(accessory => {
                        const accessoryHtml = `
                            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:scale-[1.02] fade-in" data-name="${accessory.name}" data-category="${accessory.category}" data-color="${accessory.color}" data-size="${accessory.size}" data-price="${accessory.price}">
                                <div class="relative">
                                    <img src="/storage/${accessory.image1}" alt="${accessory.name}" class="w-full h-44 object-cover rounded-t-xl">
                                    <div class="absolute top-2 right-2">
                                        ${accessory.stock > 0 ? `
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                Available
                                            </span>
                                        ` : `
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                Out of Stock
                                            </span>
                                        `}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900 truncate">${accessory.name}</h3>
                                            <p class="text-sm text-gray-600">${accessory.category}</p>
                                        </div>
                                        <p class="text-base font-medium text-gray-900">₱${parseFloat(accessory.price).toFixed(2)}</p>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 mb-3">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <span>Stock: ${accessory.stock}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="/accessories/${accessory.id}" class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        accessoriesGrid.insertAdjacentHTML('beforeend', accessoryHtml);
                    });
                })
                .catch(error => {
                    console.error('Error fetching accessories:', error);
                });
            });
        }
    }

    const desktopFilterForm = document.getElementById('desktopFilterForm');
    const mobileFilterForm = document.getElementById('mobileFilterForm');

    ajaxSearch(searchInput, desktopFilterForm);
    ajaxSearch(mobileSearchInput, mobileFilterForm);
});
