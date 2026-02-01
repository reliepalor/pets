document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput') || document.getElementById('mobileSearchInput');
    const cards = document.querySelectorAll('#foodGrid > div');
    const emptyMessage = document.querySelector('#foodGrid .text-center');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            cards.forEach(card => {
                const foodName = card.dataset.name.toLowerCase();
                card.style.display = foodName.includes(searchTerm) ? '' : 'none';
            });
            const visibleCards = Array.from(cards).filter(card => card.style.display !== 'none');
            if (emptyMessage) {
                emptyMessage.style.display = visibleCards.length === 0 ? 'block' : 'none';
            }
        });
    }
});
