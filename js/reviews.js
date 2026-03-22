document.addEventListener("DOMContentLoaded", () => {

    let reviewFormBtn = document.getElementById("submit-review");
    let reviewsDisplay = document.getElementById("reviews-display");

    displayReviews();

    reviewFormBtn.addEventListener("click", async () => {

        let rating = document.getElementById("review-rating").value;
        let text = document.getElementById("review-text").value;

        if (text === "") {
            alert("Please fill in all fields");
            return;
        }

        let res = await fetch("reviews.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: "add",
                rating: rating,
                text: text
            })
        });

        let result = await res.text();
        console.log(result);

        if (result === "not_logged_in") {
            alert("Please log in first");
            return;
        }

        displayReviews();

        document.getElementById("review-text").value = "";
    });


    async function displayReviews() {

        const res = await fetch("reviews.php?reviews=true");
        const reviews = await res.json();

        reviewsDisplay.innerHTML = "";

        reviews.forEach(review => {

            let reviewCard = document.createElement("div");
            reviewCard.classList.add("review-card");

            reviewCard.innerHTML = `
                <h3>${review.username}</h3>
                <p class="review-stars">${"⭐".repeat(review.rating)}</p>
                <p>${review.text}</p>
                ${review.isOwner ? `<button onclick="deleteReview(${review.id})">Delete</button>` : ""}
            `;

            reviewsDisplay.appendChild(reviewCard);

        });

    }


    window.deleteReview = async function(id) {

        await fetch("reviews.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: "delete",
                id: id
            })
        });

        displayReviews();
    };


    // on homepage

    window.scrollReviews = function(direction) {
        const container = document.getElementById("reviewsContainer");
        const scrollAmount = 300;
        container.scrollLeft += direction * scrollAmount;
    };

    window.scrollCategories = function(direction) {
        const container = document.getElementById("categoryScroll");
        const scrollAmount = 400;
        container.scrollLeft += direction * scrollAmount;
    };

});