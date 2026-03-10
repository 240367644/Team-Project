// INVENTORY
// view button
const viewButtons = document.querySelectorAll(".view-btn");
const productModal = document.querySelector(".product-view-modal");
const closeView = document.querySelector(".close-view");

viewButtons.forEach(button => {
    button.onclick = () => {
        productModal.style.display = "block";
    };
});

closeView.onclick = () => {
    productModal.style.display = "none";
};


// restock button
const restockButtons = document.querySelectorAll(".restock-btn");
const restockModal = document.querySelector(".restock-modal");
const cancelRestock = document.querySelector(".cancel-restock");

restockButtons.forEach(button => {
    button.onclick = () => {
        restockModal.style.display = "block";
    };
});

cancelRestock.onclick = () => {
    restockModal.style.display = "none";
};

// alerts
function updateInventoryAlerts() {

let lowStock = document.querySelectorAll(".low-stock").length;
let outStock = document.querySelectorAll(".out-stock").length;

document.getElementById("low-count").textContent = lowStock;
document.getElementById("out-count").textContent = outStock;

}

updateInventoryAlerts();

document.querySelectorAll(".product-table tbody tr").forEach(row => {

if(row.querySelector(".low-stock")){
row.classList.add("low-stock-row");
}

if(row.querySelector(".out-stock")){
row.classList.add("out-stock-row");
}

});

