var heartIcon = document.getElementById('heartIcon');

heartIcon.addEventListener('click', function() {
  heartIcon.classList.toggle('red');
});

document.addEventListener('DOMContentLoaded', function () {
  var cancelButton = document.getElementById('cancelButton');
  if (cancelButton) {
    cancelButton.addEventListener('click', function () {
      window.location.href = 'home_page.html';
    });
  }
});