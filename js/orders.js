function updateOrder(orderId, newStatus) {
    fetch('updateOrder.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            order_id: orderId,
            status: newStatus
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Update failed");
        }
    })
    .catch(err => console.error(err));
}

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const rows = document.querySelectorAll(".orders-table tbody tr");

    function filterOrders() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const rowStatus = row.querySelector("td:nth-child(4)").innerText.toLowerCase();

            const matchesSearch = text.includes(search);
            const matchesStatus = (status === "all orders") || (rowStatus === status);

            if (matchesSearch && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    searchInput.addEventListener("input", filterOrders);
    statusFilter.addEventListener("change", filterOrders);
});