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

    handleInputFocusAndBlur(usernameInput, 'usernameLabel'); // Corrected label ID
    handleInputFocusAndBlur(passwordInput, 'passwordLabel'); // Corrected label ID

    //document.querySelector('.login-button').addEventListener('click', login);
    document.querySelector('.likha-button').addEventListener('click', likha);
    document.querySelector('.hypefive-button').addEventListener('click', hypefive);
    document.querySelector('.signup-button').addEventListener('click', signUp);
});

function login() {
    const emailInput = document.getElementById("email").value;
    const passwordInput = document.getElementById("password").value;

    // Assuming your login.php script expects POST data, you can send it like this
    const formData = new FormData();
    formData.append('email', emailInput);
    formData.append('password', passwordInput);

    // Use the fetch API to make a POST request to your login.php script
    fetch('controller/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
        console.log(data);
        window.location.href = "home/homepage.php";
    })
    .catch(error => {
        // Handle errors
        console.error('Error:', error);
    });
}


function likha(event) {
    window.location.href = "postify-auth/token-likha.php";
    // window.location.href = "postify-auth/token-postify.php";
}

function hypefive(event) {
    event.preventDefault();
    window.location.href = "postify-auth/token-hypehive.php";
    // window.location.href = "postify-auth/token-postify.php";
}

function signUp() {
    window.location.href = 'signup.html';
}