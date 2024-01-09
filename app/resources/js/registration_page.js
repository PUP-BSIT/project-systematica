function showLabel(labelId) {
	const allLabels = document.querySelectorAll('.input-container label');
	allLabels.forEach(label => {
		label.classList.remove('hidden');
		});

const label = document.getElementById(labelId);
label.classList.add('hidden');
}

function login() {
  window.location.href = "home_page.html";
}

function googleLogin() {
  alert('Google Login button clicked!');
}

function signUp() {
  window.location.href = "signin.html";
}