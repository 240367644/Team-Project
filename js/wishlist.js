document.addEventListener("DOMContentLoaded", function() {

    const removeButtons = document.querySelectorAll(".remove-wishlist");

    removeButtons.forEach(button => {
        button.addEventListener("click", function() {
            const item = this.closest(".wishlist-item");
            item.remove();
        });
    });

});