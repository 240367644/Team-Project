// INVENTORY

// the view button
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


// the restock button
const restockButtons=document.querySelectorAll(".restock-btn");
const restockModal= document.querySelector(" .restock-modal");
const cancelRestock=document.querySelector(".cancel-restock");

restockButtons.forEach(button=>{
    button.onclick = () =>{
        restockModal.style.display="block";
    };
});

cancelRestock.onclick = () => {
    restockModal.style.display="none";
};

// alerts
function updateInventoryAlerts(){

let lowStock = document.querySelectorAll(".low-stock").length ;
let outStock = document.querySelectorAll(".out-stock").length;

document.getElementById("low-count").textContent= lowStock;
document.getElementById("out-count").textContent= outStock ;

}

updateInventoryAlerts();

document.querySelectorAll(".product-table tbody tr").forEach(row =>{

if(row.querySelector(".low-stock") ){
row.classList.add("low-stock-row");
}

if(row.querySelector(".out-stock")){
row.classList.add ("out-stock-row");
}

});

// search/filter functionality
const searchInput=document.getElementById("searchInput");
const categoryFilter =document.getElementById("categoryFilter");
const statusFilter=document.getElementById("statusFilter");
const filterBtn= document.getElementById("filterBtn");

if(filterBtn){
    const rows= document.querySelectorAll(".product-table tbody tr");
    
    //  categories filled out dynamically
    const categories = new Set();
    rows.forEach(row => {
        const cat=row.cells[2].textContent.trim();
        if(cat)categories.add(cat);
    });
    
    categories.forEach(cat => {
        const option=document.createElement("option");
        option.value=cat.toLowerCase();
        option.textContent=cat;
        categoryFilter.appendChild(option);
    });

    function applyFilters() {
        const searchTerm=searchInput.value.toLowerCase();
        const categoryTerm=categoryFilter.value.toLowerCase();
        const statusTerm=statusFilter.value.toLowerCase();

        rows.forEach(row =>{
            const productId=row.cells[0].textContent.toLowerCase();
            const productName=row.cells[1].textContent.toLowerCase();
            const category=row.cells[2].textContent.toLowerCase();
            const status=row.cells[5].textContent.trim().toLowerCase();
            
            const matchesSearch= productId.includes(searchTerm)||productName.includes(searchTerm);
            const matchesCategory=categoryTerm===""||category===categoryTerm;
            const matchesStatus=statusTerm===""|| status===statusTerm;
            
            if(matchesSearch&&matchesCategory&& matchesStatus) {
                row.style.display=""; // Show row
            }else{
                row.style.display="none"; // Hide row
            }
        });
    }

    filterBtn.addEventListener("click",applyFilters);
    searchInput.addEventListener("input",applyFilters );
    categoryFilter.addEventListener("change",applyFilters);
    statusFilter.addEventListener("change",applyFilters );
}
