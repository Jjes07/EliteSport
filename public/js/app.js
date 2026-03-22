// Counter for comment characters
document.addEventListener("DOMContentLoaded", () => {
    const textarea = document.getElementById("comment");
    const counter = document.getElementById("charCount");

    if (textarea && counter) {
        const updateCounter = () => {
            counter.textContent = textarea.value.length;
        };

        textarea.addEventListener("input", updateCounter);
        updateCounter();
    }

    // Rating filters auto-submit
    const ratingCheckboxes = document.querySelectorAll('.rating-filter');
    const filterForm = document.getElementById('filter-form');
    
    if (ratingCheckboxes.length && filterForm) {
        ratingCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    }
});