        // Scroll-based hide/show for secondary navbar
        let lastScrollTop = 0;
        const secondaryNav = document.getElementById('secondary-nav');
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
        document.addEventListener('DOMContentLoaded', () => {
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
        });

        // Mobile Filter Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const filterToggle = document.getElementById('filterToggle');
            const filterSidebar = document.getElementById('filterSidebar');
            const filterOverlay = document.getElementById('filterOverlay');
            const closeFilter = document.getElementById('closeFilter');
            const filterButton = document.getElementById('filter-button');

            function openFilter() {
                filterSidebar.classList.add('active');
                filterOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeFilterFunc() {
                filterSidebar.classList.remove('active');
                filterOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (filterToggle) {
                filterToggle.addEventListener('click', openFilter);
            }

            if (filterButton) {
                filterButton.addEventListener('click', openFilter);
            }

            if (closeFilter) {
                closeFilter.addEventListener('click', closeFilterFunc);
            }

            if (filterOverlay) {
                filterOverlay.addEventListener('click', closeFilterFunc);
            }

            if (filterSidebar) {
                filterSidebar.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });

        // Search Functionality
        const searchInput = document.getElementById('searchInput') || document.getElementById('mobileSearchInput');
        const cards = document.querySelectorAll('#petsGrid > div');
        
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            cards.forEach(card => {
                const petName = card.dataset.name.toLowerCase();
                card.style.display = petName.includes(searchTerm) ? '' : 'none';
            });
            const visibleCards = Array.from(cards).filter(card => card.style.display !== 'none');
            const emptyMessage = document.querySelector('#petsGrid .text-center');
            if (emptyMessage) {
                emptyMessage.style.display = visibleCards.length === 0 ? 'block' : 'none';
            }
        });