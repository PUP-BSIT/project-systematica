// Selecting form and input elements
const form = document.querySelector("form");
const passwordInput = document.getElementById("password");
const confirmPassInput = document.getElementById("confirm-password");
const passToggleBtn = document.getElementById("pass-toggle-btn");

// Function to display error messages
const showError = (field, errorText) => {
    field.classList.add("error");
    const errorElement = document.createElement("small");
    errorElement.classList.add("error-text");
    errorElement.innerText = errorText;
    field.closest(".form-group").appendChild(errorElement);
}

// Function to handle form submission
const handleFormData = (e) => {
    e.preventDefault();

    // Retrieving input elements
    const firstNameInput = document.getElementById("first-name");
    const middleNameInput = document.getElementById("middle-name");
    const lastNameInput = document.getElementById("last-name");
    const emailInput = document.getElementById("email");
    const dateInput = document.getElementById("date");
    const genderInput = document.getElementById("gender");

    // Getting trimmed values from input fields
    const firstName = firstNameInput.value.trim();
    const middleName = middleNameInput.value.trim();
    const lastName = lastNameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    const confirmPassword = confirmPassInput.value.trim();
    const date = dateInput.value;
    const gender = genderInput.value;

    // Regular expression pattern for email validation
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

    // Regular expression patterns for password validation
    const hasChar = /[a-zA-Z]/;
    const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/;
    const hasNumber = /\d/;

    // Clearing previous error messages
    document.querySelectorAll(".form-group .error").forEach(field => field.classList.remove("error"));
    document.querySelectorAll(".error-text").forEach(errorText => errorText.remove());

    // Performing validation checks
    if (!/^[a-zA-Z]+$/.test(firstName)) {
        showError(firstNameInput, "Enter a valid first name");
    }
    if (!/^[a-zA-Z]+$/.test(middleName)) {
        showError(middleNameInput, "Enter a valid middle name");
    }
    if (!/^[a-zA-Z]+$/.test(lastName)) {
        showError(lastNameInput, "Enter a valid last name");
    }
    if (!emailPattern.test(email)) {
        showError(emailInput, "Enter a valid email address");
    }
    if (password.length < 8) {
        showError(passwordInput, "Password must be a minimum of 8 characters");
    } else if (password.length > 20) {
        showError(passwordInput, "Password must be a maximum of 20 characters");
    } else if (!(hasChar.test(password) && hasSymbol.test(password) && hasNumber.test(password))) {
        showError(passwordInput, "Password must include at least one character, one symbol, and one number");
    } else if (password !== confirmPassword) {
        showError(confirmPassInput, "Passwords do not match");
    }
    if (date === "") {
        showError(dateInput, "Select your date of birth");
    }
    if (gender === "") {
        showError(genderInput, "Select your gender");
    }

    // Checking for any remaining errors before form submission
    const errorInputs = document.querySelectorAll(".form-group .error");
    if (errorInputs.length > 0) return;

    // Submitting the form
    form.submit();
}

// Toggling password visibility
passToggleBtn.addEventListener('click', () => {
    passToggleBtn.className = passwordInput.type === "password" ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
});

// Handling form submission event
form.addEventListener("submit", handleFormData);
