function allowUser() {
    // Get the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const redirectUrl = urlParams.get('redirect_url');
    const applicationName = urlParams.get('application_name');

    console.log(redirectUrl);
    console.log(applicationName);

    // Check if both parameters are present
    if (!redirectUrl || !applicationName) {
        console.error("Missing required parameters");
        return;
    }

    // Use try-catch block for better error handling
    try {
        fetch("socmedAuth.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ redirect_url: redirectUrl, application_name: applicationName }),
            })
            .then(response => {
                // Log the raw response for debugging
                console.log("Raw response:", response);
                return response.json();
            })
            .then(data => {
                console.log(data.authorization_token);
                // Check if the response contains the authorization token
                if (data && data.authorization_token) {
                    // Log a success message after a successful response
                    console.log("Request successful");
                    //  window.location.href = "../home/home.php?authorization_token=" + data.authorization_token;
                    const authorizationToken = data.authorization_token;
                    const redirectUrl = data.redirect_url; // Assuming this is the redirect URL from PHP
                    const applicationName = data.application_name;
                    // Append the authorization_token query parameter to the redirect URL
                    const newUrl = `${redirectUrl}?authorization_token=${authorizationToken}&application_name=${applicationName}`;

                    // Redirect the user to the new URL
                    window.location.href = newUrl;
                } else {
                    // Handle the case where the response does not contain the token
                    console.error("Error: Authorization token not found in the response");
                }
            })
            .catch((error) => {
                console.error("Error during logout:", error);
            });

    } catch (error) {
        console.error("Error outside the fetch operation:", error);
    }
}