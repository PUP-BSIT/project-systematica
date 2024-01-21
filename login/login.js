document.addEventListener('DOMContentLoaded', function() {
    function handleInputFocusAndBlur(input, labelId) {
        const label = document.getElementById(labelId);

        input.addEventListener('focus', function() {
            if (label && input.value === '') {
                label.querySelector('span').style.opacity = '0';
            }
        });

        input.addEventListener('blur', function() {
            if (label) {
                if (input.value === '') {
                    label.querySelector('span').style.opacity = '1';
                } else {
                    label.querySelector('span').style.opacity = '0';
                }
            }
        });

        input.addEventListener('input', function() {
            if (label && input.value === '') {
                label.querySelector('span').style.opacity = '1';
            } else {
                label.querySelector('span').style.opacity = '0';
            }
        });
    }

    const usernameInput = document.querySelector('.input-container.username input');
    const passwordInput = document.querySelector('.input-container.password input');

    handleInputFocusAndBlur(usernameInput, 'usernameLabel');
    handleInputFocusAndBlur(passwordInput, 'passwordLabel');

    document.querySelector('.login-button').addEventListener('click', login);
    document.querySelector('.likha-button').addEventListener('click', likha);
    document.querySelector('.hypefive-button').addEventListener('click', hypefive);
    document.querySelector('.signup-button').addEventListener('click', signUp);
});

function login() {
    const usernameValue = document.getElementById('username').value;
    const passwordValue = document.getElementById('password').value;

    if (usernameValue && passwordValue) {
        window.location.href = 'home/homepage.php';
    } else {
        alert('Please fill in both username and password.');
    }
}

function likha(event) {
    window.location.href = "postify-auth/token-likha.php";
}

function hypefive(event) {
    window.location.href = "postify-auth/token-hypehive.php";
    // window.location.href = "postify-auth/token-postify.php";
}

function signUp() {
    window.location.href = "signup.html";
}