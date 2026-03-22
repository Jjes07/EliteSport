// Counter for comment characters

document.addEventListener("DOMContentLoaded", () => {
    const textarea = document.getElementById("comment");
    const counter = document.getElementById("charCount");

    if (!textarea || !counter) return;

    const updateCounter = () => {
        counter.textContent = textarea.value.length;
    };

    textarea.addEventListener("input", updateCounter);

    // Initialize counter on page load
    updateCounter();
});