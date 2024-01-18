document.addEventListener('DOMContentLoaded', function () {
  const svgElement = document.querySelector('svg');
  const modalOverlay = document.getElementById('modal-overlay');
  svgElement.addEventListener('click', function () {
    modalOverlay.style.display = 'flex';
  });
  modalOverlay.addEventListener('click', function (event) {
    if (event.target === modalOverlay) {
      modalOverlay.style.display = 'none';
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('modal-overlay');
    const cancelButton = document.getElementById('cancelButton');
    const shareBuzzing = document.getElementById('shareBuzzing');
    const shareLikha = document.getElementById('shareLikha');

    cancelButton.addEventListener('click', function () {
        modalOverlay.style.display = 'none';
    });

    shareBuzzing.addEventListener('click', function () {
        console.log('Sharing to Buzzing');
        modalOverlay.style.display = 'none';
    });

    shareLikha.addEventListener('click', function () {
        console.log('Sharing to Likha');
        modalOverlay.style.display = 'none';
    });

    const textWrapperClickable = document.querySelector('.text-wrapper-10');
    textWrapperClickable.addEventListener('click', function () {
        console.log('Text wrapper clicked');
    });

    const svgElement = document.querySelector('svg');
    svgElement.addEventListener('click', function () {
        modalOverlay.style.display = 'flex';
    });

    modalOverlay.addEventListener('click', function (event) {
        if (event.target === modalOverlay) {
            modalOverlay.style.display = 'none';
        }
    });
});
  const cancelBtn = document.getElementById('cancelBtn');
  const hypeHiveBtn = document.getElementById('hypeHiveBtn');
  const likhaBtn = document.getElementById('likhaBtn');
  cancelBtn.addEventListener('click', function() {
    console.log('Cancel button clicked');
  });
  hypeHiveBtn.addEventListener('click', function() {
    console.log('Share to HypeHive clicked');
  });
  likhaBtn.addEventListener('click', function() {
    console.log('Share to Likha clicked');
  });