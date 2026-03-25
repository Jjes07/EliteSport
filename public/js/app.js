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

    const ratingCheckboxes = document.querySelectorAll('.rating-filter');
    const filterForm = document.getElementById('filter-form');

    if (ratingCheckboxes.length && filterForm) {
        ratingCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    }

    const quantityInputs = document.querySelectorAll('.quantity-input');

    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });

    const cancelBtn = document.getElementById('cancel-order-btn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
            }
        });
    }
});