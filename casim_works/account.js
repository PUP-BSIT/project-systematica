const PASSWORD_INPUT_ID = 'password';
const CONFIRM_PASSWORD_INPUT_ID = 'confirm-password';

function togglePasswordVisibility(inputId) {
  const passwordInput = document.getElementById(inputId);
  const isPasswordVisible = passwordInput.getAttribute('type') === 'text';

  passwordInput.setAttribute('type', isPasswordVisible ? 'password' : 'text');
}

document.getElementById('password-toggle-btn').addEventListener('click', function() {
  togglePasswordVisibility(PASSWORD_INPUT_ID);
});

document.getElementById('confirm-password-toggle-btn').addEventListener('click', function() {
  togglePasswordVisibility(CONFIRM_PASSWORD_INPUT_ID);
});


document.getElementById('profile_name').textContent = 'Ed Judah Mingo';

function toggleEdit() {
  const fullNameInput = document.getElementById('full_name');
  const profileName = document.getElementById('profile_name');

  if (fullNameInput.value.trim() !== '') {
    profileName.textContent = fullNameInput.value;
  }
}

function saveData() {
  const fullNameInput = document.getElementById('full_name');
  const profileName = document.getElementById('profile_name');

  if (fullNameInput.value.trim() !== '') {
    profileName.textContent = fullNameInput.value;
  }
}