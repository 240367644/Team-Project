// Validate form
function validateForm() {
    let name = document.forms["form"]["name"].value;
    if (name == "") {
      alert("Full Name must be filled out.");
      return false;
    }

    let email = document.forms["form"]["email"].value;
    if (email == "") {
      alert("Email must be filled out.");
      return false;
    }

    let confirmemail = document.forms["form"]["confirm-email"].value;
    if (confirmemail == "") {
      alert("Email must be confirmed.");
      return false;
    }

    let phone = document.forms["form"]["phone"].value;
    if (phone == "") {
      alert("Phone Number must be filled out.");
      return false;
    }

    let x = document.forms["form"]["name"].value;
    if (x == "") {
      alert("Full Name must be filled out.");
      return false;
    }

    let date = document.forms["form"]["date"].value;
    if (date == "") {
      alert("Date of Appointment must be filled out.");
      return false;
    }
  }

  let form = document.getElementById("form");
  let first_email = document.getElementById("email");
  let confirm_email = document.getElementById("confirm-email");
  first_email.onchange = checkEmails;
  confirm_email.onchange = checkEmails;

// Validate & confirm email
function checkEmails() {
    let form = document.getElementById("form");
    let first_email = document.getElementById("email");
    let confirm_email = document.getElementById("confirm-email");
    let error = '';

    if (first_email.value !== confirm_email.value) {
        error = "Emails must match.";
    }

    confirm_email.setCustomValidity(error);
    confirm_email.reportValidity();

    if (!first_email.value.endsWith("@aston.ac.uk")) {
        alert("You have entered an invalid email address!");
        return false;
    }

    return true;
}

// Choose future date only
function checkDate() {
    let date = document.getElementById("date").value;
    const today = new Date();
    const string = today.toISOString().split('T')[0];

    if (date < string) {
        alert("Choose a future date!");
        document.getElementById("date").value = '';
    }
}
    
