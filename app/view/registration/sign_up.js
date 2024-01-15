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
};

// Function to toggle password visibility
const togglePasswordVisibility = (inputField) => {
    inputField.type = inputField.type === "password" ? "text" : "password";
};

// Function to handle form submission
const handleFormData = (e) => {
    e.preventDefault();

    // Retrieving input elements
    const fullnameInput = document.getElementById("fullname");
    const emailInput = document.getElementById("email");
    const dateInput = document.getElementById("date");
    const genderInput = document.getElementById("gender");

    // Getting trimmed values from input fields
    const fullname = fullnameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    const confirmPassword = confirmPassInput.value.trim();
    const date = dateInput.value;
    const gender = genderInput.value;

    // Regular expression pattern for email validation
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

    // Clearing previous error messages
    document.querySelectorAll(".form-group .error").forEach((field) =>
        field.classList.remove("error")
    );
    document.querySelectorAll(".error-text").forEach((errorText) =>
        errorText.remove()
    );

    // Performing validation checks
    if (fullname === "") {
        showError(fullnameInput, "Enter your full name");
    }
    if (!emailPattern.test(email)) {
        showError(emailInput, "Enter a valid email address");
    }
    if (password === "") {
        showError(passwordInput, "Enter your password");
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
};

// Toggling password visibility for both password and confirm password
passToggleBtn.addEventListener("click", () => {
    togglePasswordVisibility(passwordInput);
    togglePasswordVisibility(confirmPassInput);

    // Toggling icon based on the password input field type
    passToggleBtn.className =
        passwordInput.type === "password" ?
        "fa-solid fa-eye-slash" :
        "fa-solid fa-eye";
});

// Handling form submission event
form.addEventListener("submit", handleFormData);