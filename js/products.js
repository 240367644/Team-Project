const urlParams = new URLSearchParams(window.location.search);
const initialCategory = urlParams.get("category");

let buttons = document.querySelectorAll(".button-val");
let cards = document.querySelectorAll(".card");
buttons.forEach(btn => {
    btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
        let category = btn.dataset.category;
        cards.forEach(card => {
            if (category === "all") {
                card.style.display = "block";
            } else if (card.classList.contains(category)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});

let searchInput = document.getElementById("search-input");
let searchButton = document.getElementById("search-button");

searchButton.addEventListener("click", () => {
    let searchText = searchInput.value.toLowerCase();
    cards.forEach(card => {
        let name = card.querySelector(".product-name").innerText.toLowerCase();
        if (name.includes(searchText)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
});

if (initialCategory) {
    buttons.forEach(btn => {
        if (btn.dataset.category === initialCategory) {
            btn.click();
        }
    });
}

searchInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        searchButton.click();
    }
});

document.addEventListener("click", e => {
    const card = e.target.closest(".card");
    if (!card) return;
    const productId = card.dataset.id;
    window.location.href = "productDetails.html?id=" + productId;
});

/* wishlist heart */

document.addEventListener("click", function(e){
    if(e.target.classList.contains("wishlist-heart")){
        if(e.target.innerHTML === "♡"){
            e.target.innerHTML = "❤️";
        } else {
            e.target.innerHTML = "♡";
        }
    }
});
