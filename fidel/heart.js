let heartCount = 69;

let isHeartFilled = false;

document.getElementById("heart").addEventListener("click", function () {
  isHeartFilled = !isHeartFilled;
  this.style.fill = isHeartFilled ? 'red' : 'gray';

  heartCount += isHeartFilled ? 1 : -1;
  document.getElementById("heartCount").innerText = heartCount;

  this.style.animation = 'pulse 0.5s ease-in-out';

  setTimeout(() => {
    this.style.animation = 'none';
  }, 500);
});