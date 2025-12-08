let products = {
    data: [
        {
            id: 1,
            productName: "Duvet",
            category: "bedroom",
            price: "10.00",
            image: "images/duvet.png",
            description: "A soft, breathable duvet to keep you warm. Lightweight and easy to wash but comfortable enough for colder nights."
        },
        {
            id: 2,
            productName: "Pillows",
            category: "bedroom",
            price: "10.00",
            image: "images/pillows.png",
            description: "A two pack of firm but comfortable pillows. Made with hypoallergenic filling, perfect for a good night’s rest."
        },
        {
            id: 3,
            productName: "Hangers",
            category: "bedroom",
            price: "5.00",
            image: "images/hangers.png",
            description: "A set of durable, wooden hangers to save space and keep your wardrobe neat. Ideal to help you organise your clothing items."
        },
        {
            id: 4,
            productName: "Alarm Clock",
            category: "bedroom",
            price: "7.00",
            image: "images/alarm.png",
            description: "A reliable digital alarm clock with adjustable volume and a clear display. Essential to keep you on time for your classes."
        },
        {
            id: 5,
            productName: "Small Bin",
            category: "bedroom",
            price: "4.00",
            image: "images/bin.png",
            description: "A lightweight, compact bin for your bedroom so you can dispose your everyday rubbish and keep your space tidy."
        },
        {
            id: 6,
            productName: "Plates",
            category: "kitchen",
            price: "5.00",
            image: "images/plates.png",
            description: "A set of durable, microwave-safe plates that are easy to clean. Essential for your daily meals or quick snacks."
        },
        {
            id: 7,
            productName: "Cutlery Set",
            category: "kitchen",
            price: "4.00",
            image: "images/cutlery.png",
            description: "A set of stainless-steel cutlery including forks, spoons and knives. Designed for daily use and dishwasher-friendly."
        },
        {
            id: 8,
            productName: "Mug",
            category: "kitchen",
            price: "4.00",
            image: "images/mug.png",
            description: "A durable, ceramic mug ideal for hot or cold drinks. Comfortable to hold and dishwasher-friendly."
        },
        {
            id: 9,
            productName: "Frying Pan",
            category: "kitchen",
            price: "5.00",
            image: "images/pan.png",
            description: "A non-stick frying pan that heats evenly. Made using safe materials and easy to clean in the dishwasher."
        },
        {
            id: 10,
            productName: "Chopping Board",
            category: "kitchen",
            price: "3.00",
            image: "images/choppingboard.png",
            description: "A durable, easy to clean chopping board suitable for fruit, vegetables and meat. Sturdy and lightweight, perfect for small shared kitchens."
        },
        {
            id: 11,
            productName: "Towel",
            category: "bathroom",
            price: "2.00",
            image: "images/towel.png",
            description: "A soft and absorbent bath towel that dries quickly. Comfortable on skin and durable enough for frequent washing."
        },
        {
            id: 12,
            productName: "Toothbrush Holder",
            category: "bathroom",
            price: "1.00",
            image: "images/toothbrushpot.png",
            description: "A compact, hygienic toothbrush holder to keep bathroom surfaces tidy. Ideal for shared bathrooms."
        },
        {
            id: 13,
            productName: "Laundry Basket",
            category: "bathroom",
            price: "2.00",
            image: "images/laundrybasket.png",
            description: "A foldable and lightweight laundry basket. Useful to manage laundry easily and keep clothes organised."
        },
        {
            id: 14,
            productName: "Soap Dispenser",
            category: "bathroom",
            price: "2.00",
            image: "images/soapdispenser.png",
            description: "A reusable soap dispenser with a pump. Suitable for hand soap and easy to refill."
        },
        {
            id: 15,
            productName: "Detergent",
            category: "bathroom",
            price: "4.00",
            image: "images/detergent.png",
            description: "A bottle of gentle laundry detergent suitable for all fabric types. Compact-sized bottle for storage and fresh, clean results."
        },
        {
            id: 16,
            productName: "Desk Lamp",
            category: "desk-study",
            price: "5.00",
            image: "images/desklamp.png",
            description: "An adjustable LED lamp that reduces eye strain while studying. Flexible neck for optimal lighting angles."
        },
        {
            id: 17,
            productName: "Pen Holder",
            category: "desk-study",
            price: "1.00",
            image: "images/penholder.png",
            description: "A pen holder to keep your desk clutter-free. Easy access to your stationary such as pens, markers, etc."
        },
        {
            id: 18,
            productName: "Laptop Stand",
            category: "desk-study",
            price: "3.00",
            image: "images/laptopstand.png",
            description: "An ergonomic laptop stand designed to raise your screen to eye level, improving posture and reducing eye strain. Foldable and lightweight."
        },
        {
            id: 19,
            productName: "Small Whiteboard",
            category: "desk-study",
            price: "3.00",
            image: "images/whiteboard.png",
            description: "A dry-erase whiteboard perfect for reminders or quick studying. Comes with a pen and can mount on walls."
        },
        {
            id: 20,
            productName: "Pack of Pens",
            category: "desk-study",
            price: "2.00",
            image: "images/pens.png",
            description: "A pack of smooth pens for studying. Long-lasting ink and a comfortable grip for extended writing."
        },
        {
            id: 21,
            productName: "Small House Plant",
            category: "decor-lighting",
            price: "3.00",
            image: "images/houseplant.png",
            description: "A small, fake house plant to add life to your room. Perfect for desks, shelves, etc."
        },
        {
            id: 22,
            productName: "Photo Frame",
            category: "decor-lighting",
            price: "2.00",
            image: "images/frame.png",
            description: "A simple and stylish photo frame to showcase your favourite memories. Great to personalise your space."
        },
        {
            id: 23,
            productName: "Table Lamp",
            category: "decor-lighting",
            price: "5.00",
            image: "images/tablelamp.png",
            description: "A bright lamp to create a warm atmosphere in your room. Great for adding ambient lighting."
        },
        {
            id: 24,
            productName: "Scented Candle",
            category: "decor-lighting",
            price: "2.00",
            image: "images/candle.png",
            description: "A calming scented candle to add fragrance to your room. Perfect for a day of relaxing."
        },
        {
            id: 25,
            productName: "Fairy Lights",
            category: "decor-lighting",
            price: "3.00",
            image: "images/fairylights.png",
            description: "A set of warm LED fairy lights to create a cosy and aesthetic atmosphere. Easy to set up on shelves, walls, etc."
        }
    ]
};

const urlParams = new URLSearchParams(window.location.search);
const initialCategory = urlParams.get("category");

for (let i of products.data) {
    let card = document.createElement("div");
    card.classList.add("card", i.category);
    card.dataset.name = i.productName;
    card.dataset.price = i.price;
    card.dataset.description = i.description;
    card.dataset.image = i.image;
    card.dataset.id = i.id;
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
            btn.click();   
        }
    });
}

searchInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        searchButton.click();
    }
});

const popupBg = document.getElementById('popupBg');
const popupName = document.getElementById('popupName');
const popupDesc = document.getElementById('popupDesc');
const popupPrice = document.getElementById('popupPrice');
const addToCartBtn = document.getElementById('addToCart');

let currentProduct = null;

document.addEventListener("click", e => {
    const card = e.target.closest(".card");
    if (!card) return;

    currentProduct = {
        id: card.dataset.id,
        name: card.dataset.name,
        price: card.dataset.price,
        description: card.dataset.description,
        image: card.dataset.image
    };

    popupName.textContent = currentProduct.name;
    popupDesc.textContent = currentProduct.description;
    popupPrice.textContent = currentProduct.price;
    document.getElementById("popupImg").src = currentProduct.image;

    popupBg.style.display = "flex";
});

function openPopup() {
    document.getElementById("popupImg").src = currentProduct.image;
    document.querySelector(".popup-box").style.display = "block";
}

function closePopup() {
    document.getElementById("popupBg").style.display = "none";
}

addToCartBtn.addEventListener("click", () => {
    if (!currentProduct) return;

    fetch("basket.php?path=addItem", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "product_id=" + encodeURIComponent(currentProduct.id)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            closePopup();
        } else {
            console.error(data.message);
        }
    });
});

