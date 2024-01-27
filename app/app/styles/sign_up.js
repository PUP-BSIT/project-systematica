// Selecting form and input elements
const form = document.querySelector("form");
const usernameInput = document.getElementById("username");
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

// ...

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
  const username = usernameInput.value.trim();
  const firstName = firstNameInput.value.trim();
  const middleName = middleNameInput.value.trim();
  const lastName = lastNameInput.value.trim();
  const email = emailInput.value.trim();
  const password = passwordInput.value.trim();
  const confirmPassword = confirmPassInput.value.trim();
  const date = dateInput.value;

  // Regular expression pattern for email validation
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

    // Regular expression pattern for username validation
  const usernamePattern = /^[a-zA-Z0-9_!@#$%^&*(),.?":{}|<>]{1,20}$/;

  // Regular expression patterns for password validation
  const hasChar = /[a-zA-Z]/;
  const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/;
  const hasNumber = /\d/;

  // Clearing previous error messages
  document.querySelectorAll(".form-group .error").forEach(field => field.classList.remove("error"));
  document.querySelectorAll(".error-text").forEach(errorText => errorText.remove());

  // Performing validation checks
  if (!usernamePattern.test(username)) {
      showError(usernameInput, "Enter a valid username (up to 20 characters)");
  }
  if (!/^[a-zA-Z]+(\s[a-zA-Z]+)*$/.test(firstName)) {
      showError(firstNameInput, "Enter a valid first name");
  }
  if (!/^[a-zA-Z]+(\s[a-zA-Z]+)*$/.test(middleName)) {
      showError(middleNameInput, "Enter a valid middle name");
  }
  if (!/^[a-zA-Z]+(\s[a-zA-Z]+)*$/.test(lastName)) {
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
  if (confirmPassword === "") {
      showError(confirmPassInput, "Please confirm your password");
  }

  // Checking for any remaining errors before form submission
  const errorInputs = document.querySelectorAll(".form-group .error");
  if (errorInputs.length > 0) return;

  // Submitting the form
  form.submit();
}

// ...


// Toggling password visibility
passToggleBtn.addEventListener('click', () => {
    const passwordInputType = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = passwordInputType;
    passToggleBtn.className = passwordInputType === 'password' ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
});

// Handling form submission event
form.addEventListener("submit", handleFormData);

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("randomImagesContainer");
    const numImages = 15;
    const minDistance = 20;
  
    for (let i = 1; i <= numImages; i++) {
      const image = document.createElement("img");
      image.src = `assets/images/white_star.png`; // Replace with the actual paths to your images
      image.className = "random-image";
      applyRandomStyles(image, container, minDistance);
      container.appendChild(image);
    }
  });
  
  function applyRandomStyles(element, container, minDistance) {
    const randRotate = Math.random() * 360;
  
    do {
      const randX = Math.random() * (100 - element.width / window.innerWidth * 100);
      const randY = Math.random() * (100 - element.height / window.innerHeight * 100);
  
      element.style.left = `${randX}%`;
      element.style.top = `${randY}%`;
  
    } while (
      isOverlapping(element, container) ||
      isTooClose(element, container, minDistance)
    );
  
    element.style.position = "absolute";
    element.style.transform = `rotate(${randRotate}deg)`;
  }
  
  function isOverlapping(element, container) {
    const rect = element.getBoundingClientRect();
    const containerRect = container.getBoundingClientRect();
  
    return (
      rect.right > containerRect.left &&
      rect.left < containerRect.right &&
      rect.bottom > containerRect.top &&
      rect.top < containerRect.bottom
    );
  }
  
  function isTooClose(element, container, minDistance) {
    const images = container.querySelectorAll(".random-image");
    const rect = element.getBoundingClientRect();
  
    for (const image of images) {
      if (image !== element) {
        const imageRect = image.getBoundingClientRect();
  
        const distance = Math.sqrt(
          Math.pow(rect.left - imageRect.left, 2) +
          Math.pow(rect.top - imageRect.top, 2)
        );
  
        if (distance < minDistance) {
          return true;
        }
      }
    }
  
    return false;
  }
  