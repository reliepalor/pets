document.addEventListener('DOMContentLoaded', function() {
    var openBtn = document.getElementById('openTestimonialModal');
    var closeBtn = document.getElementById('closeTestimonialModal');
    var modal = document.getElementById('testimonialModal');
    if (openBtn && closeBtn && modal) {
        openBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });
        closeBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    }
});