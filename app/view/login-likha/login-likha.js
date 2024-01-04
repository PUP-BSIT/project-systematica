function loginWithLikha() {
    const email = document.getElementById("likha_email").value;
    const password = document.getElementById("likha_password").value;
    const api_url = "https://likha.website/api.php";
    const applicationName = "Likha";

    fetch(api_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return response.json();
            } else {
                return response.text();
            }
        })
        .then((data) => {
            console.log("Data:", data);

            if (data.status === "success") {
                console.log("Likha Login Successful");

                const userId = data.data.user_id;
                const username = data.data.username;
                const email = data.data.email;
                const redirectURL = `../authorization/authorization-page.php?userName=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&app_likha=${encodeURIComponent(applicationName)}`;
                window.location.href = redirectURL;
            } else {
                console.error("Likha Login failed:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}



/*

const apiKey = "J7hP2fR1dVgQ9sX4tY0aL6mB3nZ8cO5";

fetch(apiKey, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                Authorization: `Bearer ${apiKey}`,
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            // Check if the response is JSON
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return response.json(); // Parse the response as JSON
            } else {
                return response.text(); // Return the response as text
            }
        })
        .then((data) => {
            console.log("Data:", data);

            if (data.status === "success") {
                console.log("Likha Login Successful");

                const userId = data.data.user_id;
                const username = data.data.username;
                const email = data.data.email;
                const redirectURL = `../authorization/authorization-page.php?userName=${encodeURIComponent(
            username
          )}&email=${encodeURIComponent(
            email
          )}&app_likha=${encodeURIComponent(applicationName)}`; //rename this
                window.location.href = redirectURL;
            } else {
                console.error("Likha Login failed:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}


*/