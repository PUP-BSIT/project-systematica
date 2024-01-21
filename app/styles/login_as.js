function togglePasswordVisibility() {
    const passwordInput = document.getElementById("passwordInput");
    const eyeClosed = document.getElementById("eyeClosed");
    const eyeOpen = document.getElementById("eyeOpen");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeClosed.style.display = "none";
        eyeOpen.style.display = "inline";
    } else {
        passwordInput.type = "password";
        eyeClosed.style.display = "inline";
        eyeOpen.style.display = "none";
    }
}