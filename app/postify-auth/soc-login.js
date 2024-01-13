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

    fetch("socmed.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(requestData),
        })
        .then((response) => response.json())
        .then((data) => {
            console.log("Data from server:", data);

            if (data.status === "Login Successful") {
                // Access additional parameters
                const redirectUrl = data.redirect_url;
                const applicationName = data.application_name;

                // Redirect to the specified URL after successful login
                const redirectParams = new URLSearchParams({
                    redirect_url: redirectUrl,
                    application_name: applicationName,
                }).toString();

                window.location.href = `authpage.php?${redirectParams}`;
            } else {
                throw new Error("Login failed");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            // Display error in a modal or handle it accordingly
        });
}