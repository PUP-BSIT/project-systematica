// Get the heart icon element by its ID
var heartIcon = document.getElementById('heartIcon');

// Add a click event listener to the heart icon
heartIcon.addEventListener('click', function() {
  // Toggle the 'red' class on click
  heartIcon.classList.toggle('red');
});

document.addEventListener('DOMContentLoaded', function () {
  var cancelButton = document.getElementById('cancelButton');
  if (cancelButton) {
    cancelButton.addEventListener('click', function () {
      // Redirect to home_page.html
      window.location.href = 'home_page.html';
    });
  }
});