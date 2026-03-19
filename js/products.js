const urlParams = new URLSearchParams(window.location.search);
const initialCategory = urlParams.get("category");

let buttons = document.querySelectorAll(".button-val");
let cards = document.querySelectorAll(".card");

function filterProducts() {
    const min = parseFloat(document.getElementById("min-price").value) || 0;
    const max = parseFloat(document.getElementById("max-price").value) || 100;
    const searchText = searchInput.value.toLowerCase();

    let activeBtn = document.querySelector(".button-val.active");
    let category = activeBtn ? activeBtn.dataset.category : "all";

    cards.forEach(card => {
        const price = parseFloat(card.dataset.price) || 0;
        const name = card.querySelector(".product-name").innerText.toLowerCase();

        if (
            (category === "all" || card.classList.contains(category)) &&
            name.includes(searchText) &&
            price >= min && price <= max
        ) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

document.getElementById("price-filter-btn").addEventListener("click", filterProducts);

buttons.forEach(btn => {
    btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
        filterProducts(); 
    });
});

let searchInput = document.getElementById("search-input");
let searchButton = document.getElementById("search-button");

searchButton.addEventListener("click", filterProducts); 

if (initialCategory) {
    buttons.forEach(btn => {
        if (btn.dataset.category === initialCategory) {
            btn.click();
        }
    });
}

searchInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        filterProducts();
    }
});

document.addEventListener("click", e => {
    const card = e.target.closest(".card");
    if (!card) return;

    const productId = card.dataset.id;
    window.location.href = "productDetails.html?id=" + productId;
});

document.getElementById("min-price").addEventListener("input", filterProducts);
document.getElementById("max-price").addEventListener("input", filterProducts);

/* wishlist heart */

document.addEventListener("click", function(e) {
    if (e.target.classList.contains("wishlist-heart")) {
        if (e.target.innerHTML === "♡") {
            e.target.innerHTML = "❤️";
        } else {
            e.target.innerHTML = "♡";
        }
    }
});