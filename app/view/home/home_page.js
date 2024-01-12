var heartIcon = document.getElementById('heartIcon');

heartIcon.addEventListener('click', function() {
    heartIcon.classList.toggle('red');
});

document.getElementById('shareImage').addEventListener('click', function() {
    window.location.href = 'sharepage.html';
});

function logout() {
    // Make an AJAX request to the server to log the user out
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'logout.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Redirect to the login page or perform any other action
            window.location.href = '../login/login.html';
        }
    };
    xhr.send();
}