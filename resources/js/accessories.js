document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter functionality
    const filterButton = document.getElementById('filter-button');
    const filterSidebar = document.querySelector('.filter-sidebar');
    const filterOverlay = document.querySelector('.filter-overlay');
    const closeFilterButton = document.querySelector('.filter-header button');
    const filterForm = document.querySelector('.filter-sidebar form');

    // Open filter sidebar
    if (filterButton) {
        filterButton.addEventListener('click', () => {
            filterSidebar.classList.add('active');
            filterOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    // Close filter sidebar
    function closeFilter() {
        filterSidebar.classList.remove('active');
        filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close button click
    if (closeFilterButton) {
        closeFilterButton.addEventListener('click', closeFilter);
    }

    // Overlay click
    if (filterOverlay) {
        filterOverlay.addEventListener('click', closeFilter);
    }

    // Handle form submission
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get all form data
            const formData = new FormData(filterForm);
            const params = new URLSearchParams();

            // Add all form data to params
            for (let [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }

            // Redirect to filtered URL
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        });
    }

    // Clear filters
    const clearFiltersButton = document.querySelector('.filter-buttons a');
    if (clearFiltersButton) {
        clearFiltersButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = window.location.pathname;
        });
    }
}); 