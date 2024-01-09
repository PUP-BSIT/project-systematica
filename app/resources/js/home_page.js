var heartIcon = document.getElementById('heartIcon');

heartIcon.addEventListener('click', function() {
  heartIcon.classList.toggle('red');
});

document.getElementById('shareImage').addEventListener('click', function() {
  window.location.href = 'sharepage.html';
});
