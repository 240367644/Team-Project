let reviewFormBtn = document.getElementById("submit-review");
let reviewsDisplay = document.getElementById("reviews-display");

let reviews = JSON.parse(localStorage.getItem("reviews")) || [];

displayReviews();

reviewFormBtn.addEventListener("click", () => {

    let name = document.getElementById("review-name").value;
    let rating = document.getElementById("review-rating").value;
    let text = document.getElementById("review-text").value;

    if(name === "" || text === ""){
        alert("Please fill in all fields");
        return;
    }

    let newReview = {
        name: name,
        rating: rating,
        text: text
    };

    reviews.push(newReview);

    localStorage.setItem("reviews", JSON.stringify(reviews));

    displayReviews();

    document.getElementById("review-name").value = "";
    document.getElementById("review-text").value = "";

});


function displayReviews(){

    reviewsDisplay.innerHTML = "";

    reviews.forEach(review => {

        let reviewCard = document.createElement("div");
        reviewCard.classList.add("review-card");

        reviewCard.innerHTML = `
        <h3>${review.name}</h3>
        <p class="review-stars">${"⭐".repeat(review.rating)}</p>
        <p>${review.text}</p>
        `;

        reviewsDisplay.appendChild(reviewCard);

    });

}