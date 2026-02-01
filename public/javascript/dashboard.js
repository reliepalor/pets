 const testimonialModal = document.getElementById('testimonialModal');
        const openBtn = document.getElementById('openTestimonialModal');
        const closeBtn = document.getElementById('closeTestimonialModal');

        openBtn.addEventListener('click', () => {
            testimonialModal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                testimonialModal.classList.add('opacity-100');
                testimonialModal.querySelector('div').classList.remove('scale-95');
                testimonialModal.querySelector('div').classList.add('scale-100');
            }, 10);
        });

        closeBtn.addEventListener('click', () => {
            testimonialModal.classList.remove('opacity-100');
            testimonialModal.querySelector('div').classList.remove('scale-100');
            testimonialModal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                testimonialModal.classList.add('hidden', 'opacity-0', 'pointer-events-none');
            }, 300);
        });

        // Close modal on outside click
        window.addEventListener('click', (event) => {
            if (event.target === testimonialModal) {
                closeBtn.click();
            }
        });

        // Star rating hover and selection
        const stars = document.querySelectorAll('#testimonialModal label[for^="star"]');
        stars.forEach(star => {
            star.addEventListener('mouseenter', () => {
                const val = star.getAttribute('for').replace('star', '');
                highlightStars(val);
            });
            star.addEventListener('mouseleave', () => {
                const checkedStar = document.querySelector('#testimonialModal input[name="rating"]:checked');
                if (checkedStar) {
                    highlightStars(checkedStar.value);
                } else {
                    highlightStars(0);
                }
            });
            star.addEventListener('click', () => {
                highlightStars(star.getAttribute('for').replace('star', ''));
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                const starVal = star.getAttribute('for').replace('star', '');
                if (starVal <= rating) {
                    star.classList.add('text-yellow-400');
                    star.classList.remove('text-gray-300');
                } else {
                    star.classList.add('text-gray-300');
                    star.classList.remove('text-yellow-400');
                }
            });
        }

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