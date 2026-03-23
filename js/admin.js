// INVENTORY MANAGEMENT

// ── Helpers ──────────────────────────────────────────────────────────────────

function getStockStatus(qty) {
    qty = parseInt(qty, 10);
    if (qty <= 0) return { cls: "out-stock", label: "Out of Stock" };
    if (qty <= 10) return { cls: "low-stock", label: "Low Stock" };
    return { cls: "in-stock", label: "In Stock" };
}

function updateInventoryAlerts() {
    const lowStock = document.querySelectorAll("#productTableBody .low-stock").length;
    const outStock = document.querySelectorAll("#productTableBody .out-stock").length;
    document.getElementById("low-count").textContent = lowStock;
    document.getElementById("out-count").textContent = outStock;
}

function applyRowHighlight(row) {
    row.classList.remove("low-stock-row", "out-stock-row");
    if (row.querySelector(".low-stock")) row.classList.add("low-stock-row");
    if (row.querySelector(".out-stock")) row.classList.add("out-stock-row");
}

function refreshTableHighlights() {
    document.querySelectorAll("#productTableBody tr").forEach(applyRowHighlight);
}

// ── Modal overlay ─────────────────────────────────────────────────────────────

const overlay = document.getElementById("modalOverlay");

function openModal(modal) {
    modal.style.display = "block";
    overlay.style.display = "block";
}

function closeModal(modal) {
    modal.style.display = "none";
    overlay.style.display = "none";
}

// ── View Modal ────────────────────────────────────────────────────────────────

const viewModal = document.getElementById("viewModal");
const closeViewBtn = document.getElementById("closeViewBtn");

function openViewModal(row) {
    document.getElementById("viewId").textContent       = row.dataset.id;
    document.getElementById("viewName").textContent     = row.dataset.name;
    document.getElementById("viewCategory").textContent = row.dataset.category;
    document.getElementById("viewPrice").textContent    = parseFloat(row.dataset.price).toFixed(2);
    document.getElementById("viewStock").textContent    = row.dataset.stock;
    document.getElementById("viewDescription").textContent = row.dataset.description || "—";

    const status = getStockStatus(row.dataset.stock);
    const statusEl = document.getElementById("viewStatus");
    statusEl.textContent = status.label;
    statusEl.className = status.cls;

    const imgWrap = document.getElementById("viewImageWrap");
    const imgEl   = document.getElementById("viewProductImage");
    if (row.dataset.image) {
        imgEl.src = row.dataset.image;
        imgWrap.style.display = "block";
    } else {
        imgWrap.style.display = "none";
    }

    openModal(viewModal);
}

closeViewBtn.onclick = () => closeModal(viewModal);

// ── Restock Modal ─────────────────────────────────────────────────────────────

const restockModal       = document.getElementById("restockModal");
const confirmRestockBtn  = document.getElementById("confirmRestockBtn");
const cancelRestockBtn   = document.getElementById("cancelRestockBtn");
let restockTargetRow     = null;

function openRestockModal(row) {
    restockTargetRow = row;
    document.getElementById("restockProductName").textContent = row.dataset.name + " (Current stock: " + row.dataset.stock + ")";
    document.getElementById("restockQty").value = "";
    openModal(restockModal);
}

cancelRestockBtn.onclick = () => closeModal(restockModal);

confirmRestockBtn.onclick = () => {
    const qty = parseInt(document.getElementById("restockQty").value, 10);
    if (!qty || qty <= 0) { alert("Please enter a positive quantity to restock."); return; }
    if (!restockTargetRow) return;

    const newStock = parseInt(restockTargetRow.dataset.stock, 10) + qty;
    updateRowStock(restockTargetRow, newStock);
    closeModal(restockModal);
    updateInventoryAlerts();
    refreshTableHighlights();
};

// ── Remove Stock Modal ────────────────────────────────────────────────────────

const removeStockModal       = document.getElementById("removeStockModal");
const confirmRemoveStockBtn  = document.getElementById("confirmRemoveStockBtn");
const cancelRemoveStockBtn   = document.getElementById("cancelRemoveStockBtn");
let removeStockTargetRow     = null;

function openRemoveStockModal(row) {
    removeStockTargetRow = row;
    document.getElementById("removeStockProductName").textContent = row.dataset.name;
    document.getElementById("removeStockCurrent").textContent = row.dataset.stock;
    document.getElementById("removeStockQty").value = "";
    openModal(removeStockModal);
}

cancelRemoveStockBtn.onclick = () => closeModal(removeStockModal);

confirmRemoveStockBtn.onclick = () => {
    const qty = parseInt(document.getElementById("removeStockQty").value, 10);
    if (!qty || qty <= 0) { alert("Please enter a positive quantity to remove."); return; }
    if (!removeStockTargetRow) return;

    const current = parseInt(removeStockTargetRow.dataset.stock, 10);
    const newStock = Math.max(0, current - qty);
    updateRowStock(removeStockTargetRow, newStock);
    closeModal(removeStockModal);
    updateInventoryAlerts();
    refreshTableHighlights();
};

// ── Edit Modal ────────────────────────────────────────────────────────────────

const editModal      = document.getElementById("editModal");
const saveEditBtn    = document.getElementById("saveEditBtn");
const cancelEditBtn  = document.getElementById("cancelEditBtn");
let editTargetRow    = null;
let editNewImageData = null;

function openEditModal(row) {
    editTargetRow    = row;
    editNewImageData = null;

    document.getElementById("editName").value        = row.dataset.name;
    document.getElementById("editCategory").value    = row.dataset.category;
    document.getElementById("editPrice").value       = row.dataset.price;
    document.getElementById("editStock").value       = row.dataset.stock;
    document.getElementById("editDescription").value = row.dataset.description || "";
    document.getElementById("editImage").value       = "";

    const imgWrap = document.getElementById("editCurrentImageWrap");
    const imgEl   = document.getElementById("editCurrentImage");
    if (row.dataset.image) {
        imgEl.src = row.dataset.image;
        imgWrap.style.display = "flex";
    } else {
        imgWrap.style.display = "none";
    }

    openModal(editModal);
}

cancelEditBtn.onclick = () => closeModal(editModal);

document.getElementById("editImage").addEventListener("change", function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        editNewImageData = e.target.result;
        document.getElementById("editCurrentImage").src = editNewImageData;
        document.getElementById("editCurrentImageWrap").style.display = "flex";
    };
    reader.readAsDataURL(file);
});

saveEditBtn.onclick = () => {
    const name        = document.getElementById("editName").value.trim();
    const category    = document.getElementById("editCategory").value.trim();
    const price       = parseFloat(document.getElementById("editPrice").value);
    const stock       = parseInt(document.getElementById("editStock").value, 10);
    const description = document.getElementById("editDescription").value.trim();

    if (!name || !category || isNaN(price) || isNaN(stock)) {
        alert("Please fill in all required fields.");
        return;
    }

    editTargetRow.dataset.name        = name;
    editTargetRow.dataset.category    = category;
    editTargetRow.dataset.price       = price.toFixed(2);
    editTargetRow.dataset.stock       = stock;
    editTargetRow.dataset.description = description;
    if (editNewImageData) editTargetRow.dataset.image = editNewImageData;

    const cells = editTargetRow.querySelectorAll("td");
    cells[1].textContent = name;
    cells[2].textContent = category;
    cells[3].textContent = "£" + price.toFixed(2);
    cells[4].textContent = stock;

    const status = getStockStatus(stock);
    cells[5].textContent = status.label;
    cells[5].className   = status.cls;

    closeModal(editModal);
    updateInventoryAlerts();
    refreshTableHighlights();
};

// ── Add Product Modal ─────────────────────────────────────────────────────────

const addModal      = document.getElementById("addModal");
const confirmAddBtn = document.getElementById("confirmAddBtn");
const cancelAddBtn  = document.getElementById("cancelAddBtn");
let addNewImageData = null;

document.getElementById("addProductBtn").onclick = () => {
    document.getElementById("addName").value        = "";
    document.getElementById("addCategory").value    = "";
    document.getElementById("addPrice").value       = "";
    document.getElementById("addStock").value       = "";
    document.getElementById("addDescription").value = "";
    document.getElementById("addImage").value       = "";
    document.getElementById("addImagePreviewWrap").style.display = "none";
    addNewImageData = null;
    openModal(addModal);
};

cancelAddBtn.onclick = () => closeModal(addModal);

document.getElementById("addImage").addEventListener("change", function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        addNewImageData = e.target.result;
        document.getElementById("addImagePreview").src = addNewImageData;
        document.getElementById("addImagePreviewWrap").style.display = "block";
    };
    reader.readAsDataURL(file);
});

confirmAddBtn.onclick = () => {
    const name        = document.getElementById("addName").value.trim();
    const category    = document.getElementById("addCategory").value.trim();
    const price       = parseFloat(document.getElementById("addPrice").value);
    const stock       = parseInt(document.getElementById("addStock").value, 10);
    const description = document.getElementById("addDescription").value.trim();

    if (!name || !category || isNaN(price) || isNaN(stock)) {
        alert("Please fill in all required fields.");
        return;
    }

    productIdCounter++;
    const newId = "P" + productIdCounter;
    const status = getStockStatus(stock);
    const imageData = addNewImageData || "";

    const tbody = document.getElementById("productTableBody");
    const tr = document.createElement("tr");
    tr.dataset.id          = newId;
    tr.dataset.name        = name;
    tr.dataset.category    = category;
    tr.dataset.price       = price.toFixed(2);
    tr.dataset.stock       = stock;
    tr.dataset.description = description;
    tr.dataset.image       = imageData;

    tr.innerHTML = `
        <td>${newId}</td>
        <td>${name}</td>
        <td>${category}</td>
        <td>£${price.toFixed(2)}</td>
        <td>${stock}</td>
        <td class="${status.cls}">${status.label}</td>
        <td>
            <button class="view-btn">View</button>
            <button class="edit-btn">Edit</button>
            <button class="restock-btn">Restock</button>
            <button class="remove-stock-btn">Remove Stock</button>
            <button class="delete-btn">Delete</button>
        </td>`;

    tbody.appendChild(tr);
    bindRowButtons(tr);
    applyRowHighlight(tr);
    closeModal(addModal);
    updateInventoryAlerts();
    applySearchAndFilter();
};

// ── Delete ────────────────────────────────────────────────────────────────────

function deleteRow(row) {
    if (!confirm("Are you sure you want to delete this product?")) return;
    row.remove();
    updateInventoryAlerts();
}

// ── Update row stock helper ───────────────────────────────────────────────────

function updateRowStock(row, newStock) {
    row.dataset.stock = newStock;
    const cells = row.querySelectorAll("td");
    cells[4].textContent = newStock;
    const status = getStockStatus(newStock);
    cells[5].textContent = status.label;
    cells[5].className   = status.cls;
}

// ── Bind buttons to a row ─────────────────────────────────────────────────────

function bindRowButtons(row) {
    row.querySelector(".view-btn").onclick         = () => openViewModal(row);
    row.querySelector(".edit-btn").onclick         = () => openEditModal(row);
    row.querySelector(".restock-btn").onclick      = () => openRestockModal(row);
    row.querySelector(".remove-stock-btn").onclick = () => openRemoveStockModal(row);
    row.querySelector(".delete-btn").onclick       = () => deleteRow(row);
}

// Bind all existing rows
document.querySelectorAll("#productTableBody tr").forEach(bindRowButtons);

// ── Overlay click closes all modals ───────────────────────────────────────────

overlay.onclick = () => {
    [viewModal, restockModal, removeStockModal, editModal, addModal].forEach(m => m.style.display = "none");
    overlay.style.display = "none";
};

// ── Product ID counter (derived from highest existing ID) ─────────────────────

let productIdCounter = Array.from(document.querySelectorAll("#productTableBody tr")).reduce((max, row) => {
    const num = parseInt((row.dataset.id || "").replace(/\D/g, ""), 10);
    return isNaN(num) ? max : Math.max(max, num);
}, 0);

// ── Search & Filter ───────────────────────────────────────────────────────────

function applySearchAndFilter() {
    const term   = document.getElementById("searchBar").value.toLowerCase();
    const filter = document.getElementById("statusFilter").value;

    document.querySelectorAll("#productTableBody tr").forEach(row => {
        const name     = row.dataset.name.toLowerCase();
        const category = row.dataset.category.toLowerCase();
        const matchSearch = !term || name.includes(term) || category.includes(term);

        let matchFilter = true;
        if (filter !== "all") {
            const statusCell = row.querySelectorAll("td")[5];
            matchFilter = statusCell && statusCell.classList.contains(filter);
        }

        row.style.display = matchSearch && matchFilter ? "" : "none";
    });
}

document.getElementById("searchBar").addEventListener("input", applySearchAndFilter);
document.getElementById("statusFilter").addEventListener("change", applySearchAndFilter);

// ── Initialise ────────────────────────────────────────────────────────────────

refreshTableHighlights();
updateInventoryAlerts();

