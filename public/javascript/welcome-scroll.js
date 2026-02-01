document.addEventListener('DOMContentLoaded', function () {
  const petsContainer = document.getElementById('petsContainer');
  const scrollLeftPets = document.getElementById('scrollLeftPets');
  const scrollRightPets = document.getElementById('scrollRightPets');

  const accessoriesContainer = document.getElementById('accessoriesContainer');
  const scrollLeftAccessories = document.getElementById('scrollLeftAccessories');
  const scrollRightAccessories = document.getElementById('scrollRightAccessories');

  const scrollAmount = 240; // Amount to scroll on each arrow click

  scrollLeftPets.addEventListener('click', () => {
    petsContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
  });

  scrollRightPets.addEventListener('click', () => {
    petsContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  });

  scrollLeftAccessories.addEventListener('click', () => {
    accessoriesContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
  });

  scrollRightAccessories.addEventListener('click', () => {
    accessoriesContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  });
});
