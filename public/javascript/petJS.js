
document.addEventListener("DOMContentLoaded", function() {
    const categorySelect = document.getElementById("category");
    const breedSelect = document.getElementById("breed");

    // Predefined breeds
    const breeds = {
        Dog: ["Labrador", "Golden Retriever", "German Shepherd", "Bulldog", "Shih Tzu"],
        Cat: ["Persian", "Siamese", "Maine Coon", "Bengal", "British Shorthair"]
    };

    function updateBreedOptions() {
        const selectedCategory = categorySelect.value;
        const currentBreed = breedSelect.value; // Store current selection
        breedSelect.innerHTML = "<option value=''>Breed</option>"; // Reset options

        if (selectedCategory && breeds[selectedCategory]) {
            breeds[selectedCategory].forEach(breed => {
                const option = document.createElement("option");
                option.value = breed;
                option.textContent = breed;
                if (breed === currentBreed) {
                    option.selected = true; // Keep selected breed if it exists in new category
                }
                breedSelect.appendChild(option);
            });
        }
    }

    // Update breeds when category changes
    categorySelect.addEventListener("change", updateBreedOptions);

    // Initialize breeds based on current category
    updateBreedOptions();
});
