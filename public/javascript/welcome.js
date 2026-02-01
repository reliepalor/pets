/***********************NAV BAR******************/
document.addEventListener('DOMContentLoaded', function() {
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  
  if (!menuBtn || !mobileMenu) {
    console.error('Menu button or mobile menu not found');
    return;
  }

  // Add debug logging for click events
  console.log('Menu button initialized');
  
  menuBtn.addEventListener('click', function(event) {
    console.log('Menu button clicked');
    event.preventDefault();
    event.stopPropagation();
    
    // Toggle mobile menu visibility
    mobileMenu.classList.toggle('hidden');
    mobileMenu.classList.toggle('opacity-0');
    mobileMenu.classList.toggle('opacity-100');
    
    // Toggle hamburger menu animation
    menuBtn.classList.toggle('menu-open');
  });
  
  // Make sure the whole button area is clickable
  menuBtn.style.cursor = 'pointer';
  
  // Close mobile menu when clicking outside
  document.addEventListener('click', function(event) {
    if (!mobileMenu.contains(event.target) && !menuBtn.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
      mobileMenu.classList.add('hidden');
      mobileMenu.classList.add('opacity-0');
      mobileMenu.classList.remove('opacity-100');
      menuBtn.classList.remove('menu-open');
    }
  });
});
  /********************LABEL GRADIENT******************/

function Badge({ icon, label }) {
    return `
      <div class="flex flex-col items-center text-sm text-gray-700 min-w-[100px]">
        <div class="text-3xl mb-2">${icon}</div>
        <span>${label}</span>
      </div>
    `;
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.animate-scroll').forEach(container => {
      container.innerHTML = container.innerHTML.replace(/<Badge([^>]+)\/>/g, (_, props) => {
        const match = /icon="([^"]+)"\s+label="([^"]+)"/.exec(props);
        return Badge({ icon: match[1], label: match[2] });
      });
    });
  });

  window.addEventListener("DOMContentLoaded", () => {
  const scrollContainer = document.getElementById("scroll-container");
  const original = scrollContainer.querySelector(".badge-group");
  const containerWidth = scrollContainer.offsetWidth;
  const groupWidth = original.offsetWidth;

  const minTotalWidth = containerWidth * 3;
  let currentWidth = groupWidth;

  while (currentWidth < minTotalWidth) {
    const clone = original.cloneNode(true);
    scrollContainer.appendChild(clone);
    currentWidth += groupWidth;
  }
});
  /********************SEARCHH******************/

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const petsContainer = document.getElementById('petsContainer');
  const accessoriesContainer = document.getElementById('accessoriesContainer');

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase().trim();
    
    // Handle pets
    const petCards = petsContainer.querySelectorAll('.card');
    petsContainer.style.opacity = '0.3';
    
    setTimeout(() => {
      petCards.forEach(card => {
        const name = card.dataset.name;
        const breed = card.dataset.breed;
        const category = card.dataset.category;
        
        if (query === '' || name.includes(query) || breed.includes(query) || category.includes(query)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
      petsContainer.style.opacity = '1';
    }, 300);

    // Handle accessories
    const accessoryCards = accessoriesContainer.querySelectorAll('.accessory-card');
    accessoriesContainer.style.opacity = '0.3';
    
    setTimeout(() => {
      accessoryCards.forEach(card => {
        const name = card.dataset.name;
        const category = card.dataset.category;
        
        if (query === '' || name.includes(query) || category.includes(query)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
      accessoriesContainer.style.opacity = '1';
    }, 300);
  });
});