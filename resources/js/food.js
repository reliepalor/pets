document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter functionality
    const filterButton = document.getElementById('filter-button');
    const filterSidebar = document.querySelector('.filter-sidebar');
    const filterOverlay = document.querySelector('.filter-overlay');
    const closeFilterButton = document.querySelector('.filter-header button');
    const mobileFilterForm = document.querySelector('.filter-sidebar form');
    const desktopFilterForm = document.querySelector('.hidden.md\\:block form');

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

    // Handle form submission for both mobile and desktop forms
    function handleFormSubmit(e) {
        e.preventDefault();
        
        // Get all form data
        const formData = new FormData(e.target);
        const params = new URLSearchParams();

        // Add all form data to params
        for (let [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }

        // Close mobile filter if open
        if (filterSidebar.classList.contains('active')) {
            closeFilter();
        }

        // Redirect to filtered URL
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Add submit handlers to both forms
    if (mobileFilterForm) {
        mobileFilterForm.addEventListener('submit', handleFormSubmit);
    }

    if (desktopFilterForm) {
        desktopFilterForm.addEventListener('submit', handleFormSubmit);
    }

    // Clear filters
    const clearFiltersButtons = document.querySelectorAll('.filter-buttons a');
    clearFiltersButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (filterSidebar.classList.contains('active')) {
                closeFilter();
            }
            window.location.href = window.location.pathname;
        });
    });
}); 