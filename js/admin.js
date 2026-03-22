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
const confirmRestock = document.querySelector(".confirm-restock");

restockButtons.forEach(button => {
    ////the code below automatically fills the product id so 
    //when restocking you dont need to manually type it in
    button.onclick = (e) => { 
        // Find product ID from the table row to pre-fill the modal
        const row = e.target.closest('tr');
        const productIdCell = row ? row.querySelector('td:first-child') : null;
        
        if (productIdCell) {
             const inputs = restockModal.querySelectorAll('input');
             if (inputs.length >= 1) inputs[0].value = productIdCell.textContent; // Pre-fill Product ID
        }

        restockModal.style.display = "block";
    };
});

cancelRestock.onclick = () => {
    restockModal.style.display = "none";
};

//here the confirm restock button is clicked.
if (confirmRestock) {
    confirmRestock.onclick = async () => { //when confirm restock is clicked
        const inputs = restockModal.querySelectorAll('input'); //input from the model is taken
        const productId = inputs[0] ? inputs[0].value : null; //product id is taken from the first input
        const quantity = inputs[1] ? inputs[1].value : null; //quantity is taken from the second input

        //if product or quantity id is not valid a message is shown.
        if (!productId || !quantity || quantity <= 0) {
            alert("Please enter a valid Product ID and Quantity");
            return;
        }

        //here a request is sent to update_stock.php, where the stock is updated.
        try {
            const response = await fetch('update_stock.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    amount: parseInt(quantity)
                })
            });

            const text = await response.text(); // Get raw text first
            try {
                const data = JSON.parse(text); // Try parsing as JSON
                
                //success=a success alert message is given and page is refreshed.
                if (data.status === "success" || data.success) {
                    alert("Restock successful!");
                    location.reload(); // Refresh the page to see the new stock
                //failure=an error alert message is given.
                } else {
                    alert("Restock failed: " + (data.message || "Unknown error"));
                }
            } catch (jsonErr) {
                console.error("Not a valid JSON response:", text);
                alert("Server Error. Check console! Response: " + text.substring(0, 100));
            }
        } catch (error) {
            console.error("Error during restock fetch:", error);
            alert("Network error: " + error.message);
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

