let products = {
    data:[
        {
        productName: "House Plant",
        category: "decor-lighting",
        price: "5",
        image: "../images/houseplant.jpg"

    },
    {
        productName: "Table Lamp",
        category: "decor-lighting",
        price: "6",
        image: "../images/tablelamp.png"

    },
    {
        productName: "Table Lamp",
        category: "decor-lighting",
        price: "6",
        image: "../images/tablelamp.png"

    },

],
};

const urlParams = new URLSearchParams(window.location.search);
const initialCategory = urlParams.get("category");

for (let i of products.data) {
    let card = document.createElement("div");
    card.classList.add("card", i.category);
    let imgContainer = document.createElement("div");
    imgContainer.classList.add("image-container");
    let image = document.createElement("img");
    image.setAttribute("src", i.image);
    imgContainer.appendChild(image);
    card.appendChild(imgContainer);
    let container = document.createElement("div");
    container.classList.add("container");
    let name = document.createElement("h5");
    name.classList.add("product-name");
    name.innerText = i.productName.toUpperCase();
    container.appendChild(name);
    let price = document.createElement("h6");
    price.innerText = "£"+i.price;
    container.appendChild(price);

    card.appendChild(container);
    document.getElementById("products-display").appendChild(card);


}

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
            btn.click();   // simulate clicking the button
        }
    });
}

/* searchInput.addEventListener("keyup", () => {
    let searchText = searchInput.value.toLowerCase();

    cards.forEach(card => {
        let name = card.querySelector(".product-name").innerText.toLowerCase();

        if (name.includes(searchText)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}); */

searchInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        searchButton.click();
    }
});