document.addEventListener("DOMContentLoaded", function() {

    const removeButtons = document.querySelectorAll(".remove-wishlist");

    removeButtons.forEach(button => {
        button.addEventListener("click", function() {
            const item = this.closest(".wishlist-item");
            item.remove();
        });
    });

});

document.addEventListener("click", function(e){

    if(e.target.classList.contains("wishlist-heart")){

        if(e.target.innerHTML === "♡"){
            e.target.innerHTML = "❤️";
        } else {
            e.target.innerHTML = "♡";
        }

    }

});

