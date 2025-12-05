const basketItems = document.querySelector(".basket-items");
const subtotalEl = document.querySelector(".summary-line span:last-child");
const totalEl = document.querySelector(".summary-total span:last-child");

function loadBasket() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    basketItems.innerHTML = ""; // clear existing

    if (cart.length === 0) {
        basketItems.innerHTML = "<p>Your basket is empty.</p>";
        subtotalEl.textContent = "£0.00";
        totalEl.textContent = "£0.00";
        return;
    }

    let subtotal = 0;

    cart.forEach((item, index) => {
        subtotal += Number(item.price);

        const div = document.createElement("div");
        div.classList.add("basket-item");

        div.innerHTML = `
            <div class="item-details">
                <h3>${item.name}</h3>
                <p class="item-price">£${item.price}</p>
                <button class="remove-item" data-index="${index}">Remove</button>
            </div>
        `;

        basketItems.appendChild(div);
    });

    subtotalEl.textContent = "£" + subtotal.toFixed(2);
    totalEl.textContent = "£" + subtotal.toFixed(2);
}

document.addEventListener("click", e => {
    if (e.target.classList.contains("remove-item")) {
        let index = e.target.dataset.index;
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        loadBasket();
    }
});

loadBasket();