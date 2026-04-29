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
        input.addEventListener('change', function () {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });

    // Handle all confirmation buttons (delete, remove, cancel)
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });

    // Handle modal toggle buttons
    const toggleModalButtons = document.querySelectorAll('[data-toggle-modal]');
    toggleModalButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const modalId = this.dataset.toggleModal;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('d-none');
            }
        });
    });

    // Handle modal close buttons
    const closeModalButtons = document.querySelectorAll('[data-close-modal]');
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const modalId = this.dataset.closeModal;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('d-none');
            }
        });
    });
});