function loginAccount() {
    const email = document.getElementById("email_field").value;
    const password = document.getElementById("password_field").value;

    // Get redirect_url and application_name from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const redirectUrl = urlParams.get("redirect_url");
    const applicationName = urlParams.get("application_name");

    // Prepare the data to be sent in the request
    const requestData = {
        email: email,
        password: password,
        redirect_url: redirectUrl,
        application_name: applicationName,
    };
}