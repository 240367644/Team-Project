let wishlistContainer = document.querySelector(".wishlist-container");

let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

if (wishlist.length === 0) {
    wishlistContainer.innerHTML = "<p>Your wishlist is empty.</p>";
}

// wishlist display
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

// remove
function removeFromWishlist(id) {

    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    wishlist = wishlist.filter(item => item.id != id);

    localStorage.setItem("wishlist", JSON.stringify(wishlist));

    location.reload();
}

document.addEventListener('DOMContentLoaded', async () => {

    const container = document.querySelector('.wishlist-container');
    const emptyMsg = document.getElementById('empty-message');

    container.innerHTML = '';

    try {
        const res = await fetch('wishlist.php?path=get', {
            credentials: 'include'
        });

        const items = await res.json();

        if (items.length === 0) {
            emptyMsg.style.display = 'block';
            return;
        }

        items.forEach(item => {
            const div = document.createElement('div');
            div.classList.add('product-card');

            div.innerHTML = `
                <span class="wishlist-star">★</span>
                <img src="${item.image}" alt="${item.name}">
                <h3>${item.name}</h3>
                <p>£${item.price}</p>
                <button>Add to Basket</button>
            `;

            container.appendChild(div);
        });

    } catch (err) {
        console.error(err);
    }
});

document.querySelectorAll('.remove-wishlist').forEach(button => {
    button.addEventListener('click', async () => {

        const productId = button.getAttribute('data-id');

        const formData = new FormData();
        formData.append('product_id', productId);

        const res = await fetch('wishlist.php?path=remove', {
            method: 'POST',
            body: formData,
            credentials: 'include'
        });

        const data = await res.json();
        alert(data.message);

        location.reload();
    });
});
