const PASSWORD_INPUT_ID = 'password';
const CONFIRM_PASSWORD_INPUT_ID = 'confirm_password';

function toggle_password_visibility(input_id) {
	const password_input = document.getElementById(input_id);
	const is_password_visible = password_input.getAttribute('type') === 'text';

	password_input.setAttribute('type', is_password_visible ? 'password' : 'text');
}

document.getElementById('password_toggle_btn').addEventListener('click', function() {
	toggle_password_visibility(PASSWORD_INPUT_ID);
});

document.getElementById('confirm_password_toggle_btn').addEventListener('click', function() {
	toggle_password_visibility(CONFIRM_PASSWORD_INPUT_ID);
});

document.getElementById('profile_name').textContent = 'Ed Judah Mingo';

function toggle_edit() {
	const full_name_input = document.getElementById('full_name');
	const profile_name = document.getElementById('profile_name');

	if (full_name_input.value.trim() !== '') {
		profile_name.textContent = full_name_input.value;
	}
}

function save_data() {
	const full_name_input = document.getElementById('full_name');
	const profile_name = document.getElementById('profile_name');

	if (full_name_input.value.trim() !== '') {
		profile_name.textContent = full_name_input.value;
	}
}