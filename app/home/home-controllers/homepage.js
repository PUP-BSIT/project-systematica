const body = document.querySelector("body");
const darkLight = document.querySelector("#darkLight");
const sidebar = document.querySelector(".sidebar");
const submenuItems = document.querySelectorAll(".submenu_item");
const sidebarOpen = document.querySelector("#sidebarOpen");
const sidebarClose = document.querySelector(".collapse_sidebar");
const sidebarExpand = document.querySelector(".expand_sidebar");
const contentContainer = document.getElementById('content-container');
const sidebarLinks = document.querySelectorAll('.nav_link'); // Updated selector for all nav_links
const logoutLink = document.getElementById('logoutLink');
const submenu = document.querySelector('.submenu');
let lastClickedContent = null;

// Event listener for sidebar links
sidebarLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        const pageUrl = link.getAttribute('data-page') || link.getAttribute('href');
        loadLocalContent(pageUrl);
        lastClickedContent = pageUrl;
    });
});

sidebarClose.addEventListener("click", () => {
    sidebar.classList.add("close", "hoverable");
});

sidebarExpand.addEventListener("click", () => {
    sidebar.classList.remove("close", "hoverable");
});

sidebar.addEventListener("mouseenter", () => {
    if (sidebar.classList.contains("hoverable")) {
        sidebar.classList.remove("close");
    }
});

sidebar.addEventListener("mouseleave", () => {
    if (sidebar.classList.contains("hoverable")) {
        sidebar.classList.add("close");
    }
});

function loadLocalContent(pageUrl) {
    console.log('Loading content for pageUrl:', pageUrl);

    if (pageUrl === null || pageUrl === undefined) {
        console.error('Invalid pageUrl:', pageUrl);
        return;
    }

    if (pageUrl.includes("setting")) {
        // Handle Settings link differently (show/hide submenu)
        const submenu = document.querySelector('.submenu');
        submenu.classList.toggle('show_submenu');
    } else {
        // Load content for other links
        fetch(pageUrl)
            .then(response => response.text())
            .then(html => {
                contentContainer.innerHTML = html;

                // Apply inlined styles
                const styleTags = contentContainer.querySelectorAll('style');
                styleTags.forEach(styleTag => {
                    const newStyle = document.createElement('style');
                    newStyle.innerHTML = styleTag.innerHTML;
                    styleTag.parentNode.replaceChild(newStyle, styleTag);
                });

                contentContainer.scrollIntoView();

                // If the fetched page contains scripts, re-run them
                const scripts = contentContainer.querySelectorAll('script');
                scripts.forEach(script => {
                    const newScript = document.createElement('script');
                    newScript.innerHTML = script.innerHTML;
                    script.parentNode.replaceChild(newScript, script);
                });
            })
            .catch(error => {
                console.error('Error fetching page:', error);
            });
    }
}



darkLight.addEventListener("click", () => {
    body.classList.toggle("dark");
    contentContainer.classList.toggle("dark", body.classList.contains("dark"));

    if (body.classList.contains("dark")) {
        darkLight.classList.replace("bx-sun", "bx-moon");
    } else {
        darkLight.classList.replace("bx-moon", "bx-sun");
    }
});

submenuItems.forEach((item, index) => {
    item.addEventListener("click", () => {
        item.classList.toggle("show_submenu");
        submenuItems.forEach((item2, index2) => {
            if (index !== index2) {
                item2.classList.remove("show_submenu");
            }
        });
    });
});

settingLink.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default behavior of the link
    submenu.classList.toggle('show_submenu');
});

sidebarLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        // Remove the 'clicked' class from all links
        sidebarLinks.forEach(link => {
            link.classList.remove('clicked');
        });

        // Add the 'clicked' class to the clicked link
        link.classList.add('clicked');

        // Continue with the default link behavior
    });
});

const homeButton = document.querySelector('.nav_link[data-page="hallu.html"]');
if (homeButton) {
    homeButton.click();
}

logoutLink.addEventListener('click', function(event) {
    event.preventDefault();

    // Perform logout actions here, such as clearing user authentication status

    // Redirect to the login page
    window.location.href = 'home-controllers/logout.php';
});

if (window.innerWidth < 768) {
    sidebar.classList.add("close");
} else {
    sidebar.classList.remove("close");
}

// Initial load of last clicked content
// if (lastClickedContent) {
//   loadLocalContent(lastClickedContent);
// }


// Function to extract token from URL
function getAuthToken() {
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('authorization_token');

    if (token) {
        console.log(`Authorization token found in the URL: ${token}`);
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Response from home.php:', xhr.responseText);
            }
        };

        // Adjust the URL as needed
        const apiUrl = 'home.php?authorization_token=' + encodeURIComponent(token);
        xhr.open('GET', apiUrl, true);
        xhr.send();
    } else {
        console.log('Authorization token not found in the URL.');
    }
}


// Call the function when the page loads
window.onload = function() {
    console.log('Page loaded');
    getAuthToken();
    var apiUrl = 'home.php';

    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            // Process the response data
            console.log('Data fetched:', data);
        })
        .catch(error => {
            console.error('Error during fetch operation:', error);
        });
};

// Function to logout
function logout() {
    console.log('Logout clicked');
    window.location.href = "home-controllers/logout.php";
}

// Attach the logout function to the logout link
logoutLink.addEventListener("click", logout);