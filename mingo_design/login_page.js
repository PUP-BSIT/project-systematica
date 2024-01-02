document.addEventListener('DOMContentLoaded', function () {
    function handleInputFocusAndBlur(input, labelId) {
        const label = document.getElementById(labelId);

        input.addEventListener('focus', function () {
            if (label && input.value === '') {
                label.querySelector('span').style.opacity = '0';
            }
        });

        input.addEventListener('blur', function () {
            if (label) {
                if (input.value === '') {
                    label.querySelector('span').style.opacity = '1';
                } else {
                    label.querySelector('span').style.opacity = '0';
                }
            }
        });

        input.addEventListener('input', function () {
            if (label && input.value === '') {
                label.querySelector('span').style.opacity = '1';
            } else {
                label.querySelector('span').style.opacity = '0';
            }
        });
    }

    const usernameInput = document.querySelector('.input-container.username input');
    const passwordInput = document.querySelector('.input-container.password input');

    handleInputFocusAndBlur(usernameInput, 'username-label');
    handleInputFocusAndBlur(passwordInput, 'password-label');

    document.querySelector('.login-button').addEventListener('click', login);
    document.querySelector('.likha-button').addEventListener('click', likha);
    document.querySelector('.hypefive-button').addEventListener('click', hypefive);
    document.querySelector('.signup-button').addEventListener('click', signUp);
});

function login() {
    window.location.href = "home_page.html";
}

function likha(event) {
    event.preventDefault();
    alert('Likha button clicked!');
}

function hypefive(event) {
    event.preventDefault();
    alert('Hypefive button clicked!');
}

function signUp() {
    window.location.href = "sign_up.html";
}