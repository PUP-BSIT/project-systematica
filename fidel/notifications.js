document.addEventListener('DOMContentLoaded', function () {
  const notificationButton = document.querySelector('.btn3');
  const rectangleDiv = document.querySelector('.rectangle-parent');
  
  function showNotification(message) {
    rectangleDiv.style.display = 'block';
    console.log(message);
  }
  function hideNotifications() {
    rectangleDiv.style.display = 'none';
  }
  function reactToPost() {
    showNotification('Someone reacted to your post!');
  }
  function sharePost() {
    showNotification('Someone shared your post!');
  }
  function addAsFriend() {
    showNotification('Someone added you as a friend!');
  }
  function replyToComment() {
    showNotification('Someone replied to your comment!');
  }
  notificationButton.addEventListener('click', function () {
    reactToPost();
    setTimeout(hideNotifications, 4000);
  });
  notificationButton.addEventListener('mouseover', function () {
    console.log('Hovered over the notification button!');
  });
});