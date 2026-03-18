let wishlistContainer = document.querySelector(".wishlist-container");

let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

if (wishlist.length === 0) {
    wishlistContainer.innerHTML = "<p>Your wishlist is empty.</p>";
}

wishlist.forEach(product => {

    let item = document.createElement("div");
    item.classList.add("wishlist-item");

    item.innerHTML = `
        <img src="${product.image}" alt="${product.productName}">
        <h3>${product.productName}</h3>
        <p class="wishlist-price">£${product.price}</p>

        <div class="wishlist-buttons">
            <button class="add-basket">Add to Basket</button>
            <button class="remove-wishlist">Remove</button>
        </div>
    `;

    item.querySelector(".remove-wishlist").addEventListener("click", () => {
        removeFromWishlist(product.id);
    });

    wishlistContainer.appendChild(item);

});

function removeFromWishlist(id) {

    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    wishlist = wishlist.filter(item => item.id != id);

    localStorage.setItem("wishlist", JSON.stringify(wishlist));

    location.reload();
}
