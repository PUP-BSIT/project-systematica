const PASSWORD_INPUT_ID = 'password';
const CONFIRM_PASSWORD_INPUT_ID = 'confirm_password';

function toggle_password_visibility(input_id, toggle_id) {
    const password_input = document.getElementById(input_id);
    const eye_open = document.getElementById(`${toggle_id}_open`);
    const eye_close = document.getElementById(`${toggle_id}_close`);

    if (password_input.getAttribute('type') === 'password') {
        password_input.setAttribute('type', 'text');
        eye_open.style.display = 'none';
        eye_close.style.display = 'inline';
    } else {
        password_input.setAttribute('type', 'password');
        eye_open.style.display = 'inline';
        eye_close.style.display = 'none';
    }
}
document.getElementById('password_toggle_btn').addEventListener('click', function () {
    toggle_password_visibility(PASSWORD_INPUT_ID, 'password_toggle_btn');
});

document.getElementById('confirm_password_toggle_btn').addEventListener('click', function () {
    toggle_password_visibility(CONFIRM_PASSWORD_INPUT_ID, 'confirm_password_toggle_btn');
});

document.getElementById('profile_name').textContent = 'chuchuchuchu';

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
