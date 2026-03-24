document.addEventListener("DOMContentLoaded", () => {

    // Review: Counter for comment characters
    const textarea = document.getElementById("comment");
    const counter = document.getElementById("charCount");

    if (textarea && counter) {
        const updateCounter = () => {
            counter.textContent = textarea.value.length;
        };

        textarea.addEventListener("input", updateCounter);
        updateCounter();
    }

    // Review Filters: Rating filters auto-submit
    const ratingCheckboxes = document.querySelectorAll('.rating-filter');
    const filterForm = document.getElementById('filter-form');
    
    if (ratingCheckboxes.length && filterForm) {
        ratingCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    }

    // Cart: Auto-submit when quantity changes
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
});