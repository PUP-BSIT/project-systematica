function createButtonPage() {
  return `
    <div class="create-button-page">
      <div class="outer-frame-for-share-button">
        <div id="createdPosts" class="created-posts"></div>
        <div class="create-post-form" 
			id="postForm" style="display: none;">
          <textarea id="postContent" 
			placeholder="Type your post..."></textarea>
          <input type="file" id="photoInput" 
			accept="image/*" style="display: none;">
          <button class="create-post-button" 
			onclick="createPost()">Post</button>
        </div>
      </div>
    </div>
  `;
}

function render() {
  document.getElementById('app').innerHTML = createButtonPage();
}

function toggleFormVisibility() {
  const postForm = document.getElementById('postForm');
  const photoInput = document.getElementById('photoInput');

  if (postForm.style.display === 'none') {
    postForm.style.display = 'block';
    photoInput.style.display = 'block';
  } else {
    postForm.style.display = 'none';
    photoInput.style.display = 'none';
  }
}

function createPost() {
  const postContent = document.getElementById('postContent').value.trim();
  const photoInput = document.getElementById('photoInput');

  if (!postContent && photoInput.files.length === 0) {
    alert('Please enter text or choose a file before posting.');
    return;
  }

  const photoUrl = photoInput.files.length > 
	0 ? URL.createObjectURL(photoInput.files[0]) : '';

  const newPostElement = document.createElement('div');
  newPostElement.className = 'post';
  newPostElement.innerHTML = `
    <div class="post-content">${postContent}</div>
    <img class="post-photo" src="${photoUrl}" alt="Uploaded Photo">
  `;

  const createdPostsContainer = document.getElementById('createdPosts');
  createdPostsContainer.insertBefore
	(newPostElement, createdPostsContainer.firstChild);

  document.getElementById('postContent').value = '';
  photoInput.value = '';

  toggleFormVisibility();
}

render();

document.getElementById('Create')
	.addEventListener('click', toggleFormVisibility);