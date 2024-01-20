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

// Event listener for sidebar links
// Event listener for sidebar links
sidebarLinks.forEach(link => {
  link.addEventListener('click', function (event) {
    event.preventDefault();
    const pageUrl = link.getAttribute('data-page') || link.getAttribute('href');
    loadLocalContent(pageUrl);
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

// Function to load local content
function loadLocalContent(pageUrl) {
  fetch(pageUrl)
    .then(response => response.text())
    .then(html => {
      contentContainer.innerHTML = html;
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

sidebarLinks.forEach(link => {
  link.addEventListener('click', function (event) {
    // Remove the 'clicked' class from all links
    sidebarLinks.forEach(link => {
      link.classList.remove('clicked');
    });

    // Add the 'clicked' class to the clicked link
    link.classList.add('clicked');

    // Continue with the default link behavior
  });
});

logoutLink.addEventListener('click', function (event) {
  event.preventDefault();

  // Perform logout actions here, such as clearing user authentication status

  // Redirect to the login page
  window.location.href = './login.html';
});

if (window.innerWidth < 768) {
  sidebar.classList.add("close");
} else {
  sidebar.classList.remove("close");
}
