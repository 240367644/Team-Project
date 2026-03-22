//delete customer
async function deleteCustomer(id) {
    if (!confirm("Are you sure you want to delete this customer?")) return;

    const formData = new FormData();
    formData.append("user_id", id);

    const res = await fetch('customerActions.php?action=delete', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    alert(data.message);

    if (data.status === "success") {
        location.reload(); // refresh table
    }
}


//edit customer
async function editCustomer(id) {

    const name = prompt("Enter new name (leave blank to keep same):");
    const email = prompt("Enter new email (leave blank to keep same):");

    const formData = new FormData();
    formData.append("user_id", id);
    formData.append("username", name);
    formData.append("email", email);

    const res = await fetch('customerActions.php?action=update', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    alert(data.message);

    if (data.status === "success") {
        location.reload();
    }
}

// role
async function updateRole(id, role) {
    const formData = new FormData();
    formData.append("user_id", id);
    formData.append("role", role);

    const res = await fetch('customerActions.php?action=role', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    console.log(data.message);
}

// add
async function addCustomer() {

    const name = prompt("Enter name:");
    const email = prompt("Enter email:");
    const password = prompt("Enter password:");

    if (!name || !email || !password) {
        alert("All fields required");
        return;
    }

    const formData = new FormData();
    formData.append("username", name);
    formData.append("email", email);
    formData.append("password", password);

    const res = await fetch('customerActions.php?action=add', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    alert(data.message);

    if (data.status === "success") {
        location.reload();
    }
}

// search
document.getElementById("searchInput").addEventListener("keyup", function() {
    const search = this.value.toLowerCase();
    const rows = document.querySelectorAll(".customer-table tbody tr");

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();

        if (text.includes(search)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});