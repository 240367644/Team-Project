async function loadProducts() {
    try {
        const res = await fetch("database_products.php?path=getProducts");
        const data = await res.json();

        if (data.status !== "success") {
            console.error("Failed to load products");
            return;
        }

        const products = data.data;
        const display = document.getElementById("products-display");
        display.innerHTML = "";

        products.forEach(p => {
            let card = document.createElement("div");
            card.classList.add("card");

            let imgContainer = document.createElement("div");
            imgContainer.classList.add("image-container");
            let image = document.createElement("img");
            image.src = "images/sample-product.jpg";
            imgContainer.appendChild(image);

            let container = document.createElement("div");
            container.classList.add("container");

            let name = document.createElement("h5");
            name.classList.add("product-name");
            name.innerText = p.product_name;
            container.appendChild(name);

            let price = document.createElement("h6");
            price.innerText = "£" + p.product_price;
            container.appendChild(price);

            card.appendChild(imgContainer);
            card.appendChild(container);

            display.appendChild(card);
        });

    } catch (err) {
        console.error("Error loading products:", err);
    }
}

window.onload = loadProducts;
