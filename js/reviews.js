document.addEventListener("DOMContentLoaded", () => {
    let reviewFormBtn = document.getElementById("submit-review");

    if (reviewFormBtn) {
        reviewFormBtn.addEventListener("click", async () => {

            let name = document.getElementById("review-name").value;
            let rating = document.getElementById("review-rating").value;
            let text = document.getElementById("review-text").value;

            // This is where we mathematically grab the PHP ID that we stored in the button!
            let productId = reviewFormBtn.getAttribute("data-product-id");

            if (name === "" || text === "") {
                alert("Please fill in your name and review text");
                return;
            }

            let formData = new FormData();
            formData.append("product_id", productId);
            formData.append("reviewer_name", name);
            formData.append("rating", rating);
            formData.append("text", text);

            try {
                let response = await fetch("submit_review.php", {
                    method: "POST",
                    body: formData
                });

                let data = await response.json();

                if (data.status === "success") {
                    alert("Review submitted!");
                    location.reload();
                } else {
                    alert("Error: " + data.message);
                }
            } catch (error) {
                console.error("Error submitting review:", error);
                alert("Network error occurred.");
            }
        });
    }
});
