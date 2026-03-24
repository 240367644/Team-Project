// INVENTORY

// the view button
const viewButtons=document.querySelectorAll(".view-btn");
const productModal=document.querySelector(".product-view-modal");
const closeView=document.querySelector(".close-view");


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
//edit Button
const editButtons=document.querySelectorAll(".edit-btn");
const editModal=document.querySelector(".edit-modal");
const cancelEdit=document.querySelector(".cancel-edit");

editButtons.forEach(button =>{
    button.onclick = () =>{
        document.getElementById("edit-id").value=button.dataset.id;
        document.getElementById("edit-name").value=button.dataset.name;
        document.getElementById("edit-category").value=button.dataset.category;
        document.getElementById("edit-price").value=button.dataset.price;
        document.getElementById("edit-stock").value=button.dataset.stock;
        editModal.style.display="block";
    };
});
document.getElementById("closeEdit").onclick = () => {
    editModal.style.display="none";
};
const saveBtn=document.getElementById("saveEdit");
if (saveBtn) {
    saveBtn.onclick = async () => {

        const data = {
            id: document.getElementById("edit-id").value,
            name: document.getElementById("edit-name").value,
            category: document.getElementById("edit-category").value,
            price: document.getElementById("edit-price").value,
            stock: document.getElementById("edit-stock").value
        };

        try {
            const res = await fetch("edit_product.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();
            alert(result.message);

            location.reload(); // refresh table

        } catch (err) {
            console.error("Error:", err);
            alert("Failed to save changes");
        }
    };
}

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

