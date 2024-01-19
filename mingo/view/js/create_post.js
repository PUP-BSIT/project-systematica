var currentPostContainer;
    // Load existing posts from localStorage on page load
    document.addEventListener("DOMContentLoaded", function () {
        loadPosts();
    });

    function displayFilePreview(mode) {
        var fileInput;
        var filePreview;
        var fileNameElement;

        if (mode === 'edit') {
            fileInput = document.getElementById("editFileInput");
            filePreview = document.getElementById("editFilePreview");
            fileNameElement = document.getElementById("editFileName");
        } else {
            fileInput = document.getElementById("fileInput");
            filePreview = document.getElementById("filePreview");
            fileNameElement = document.getElementById("fileName");
        }

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                filePreview.src = e.target.result;
                fileNameElement.textContent = fileInput.files[0].name;
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }


    function createPost() {
        var postText = document.getElementById("postText").value;
        var fileInput = document.getElementById("fileInput");
        var imageFile = fileInput.files[0];

        if (!postText.trim() && !imageFile) {
            alert("Please enter text or select an image for your post.");
            return;
        }

        var newPostContainer = document.createElement("div");
        newPostContainer.classList.add("post-container");

        var newPost = document.createElement("div");
        newPost.classList.add("post");

        if (postText.trim()) {
            newPost.innerHTML += `<p>${postText}</p>`;
        }

        if (imageFile) {
            newPost.innerHTML += `<img src="${URL.createObjectURL(imageFile)}" alt="Posted Image">`;
        }

        // Add like and share buttons
        var postButtons = document.createElement("div");
        postButtons.classList.add("post-buttons");

        var likeButton = document.createElement("img");
        likeButton.src = "./images/Heart.svg"; // Replace with your image
        likeButton.alt = "Like";
        likeButton.addEventListener("click", function () {
            // Handle like button click
            alert("Liked!");
        });

        var shareButton = document.createElement("img");
        shareButton.src = "./images/Share.svg"; // Replace with your image
        shareButton.alt = "Share";
        shareButton.addEventListener("click", function () {
            // Handle share button click
            alert("Shared!");
        });

        postButtons.appendChild(likeButton);
        postButtons.appendChild(shareButton);

        newPost.appendChild(postButtons);

        newPostContainer.appendChild(newPost);

        var postsContainer = document.getElementById("postsContainer");
        postsContainer.appendChild(newPostContainer);

        // Save posts to localStorage
        savePosts();

        document.getElementById("postText").value = "";
        fileInput.value = "";
        document.getElementById("filePreview").src = "";
        document.getElementById("fileName").textContent = "Choose File";

        toggleOverlay();

        var manageButton = document.createElement("button");
        manageButton.classList.add("manage-button");
        manageButton.innerHTML = `<img src="./images/manage.svg" alt="Manage">`;
        manageButton.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents the click from propagating to the post container
            openManageOverlay(newPostContainer);
        });

        newPostContainer.appendChild(manageButton);
    }

    function toggleOverlay() {
        var overlay = document.getElementById("overlay");
        overlay.style.display = (overlay.style.display === "none" || overlay.style.display === "") ? "block" : "none";
    }

    function loadPosts() {
        var posts = JSON.parse(localStorage.getItem("posts")) || [];

        var postsContainer = document.getElementById("postsContainer");
        postsContainer.innerHTML = ""; // Clear existing posts

        posts.forEach(function (post) {
            var newPostContainer = document.createElement("div");
            newPostContainer.classList.add("post-container");

            var newPost = document.createElement("div");
            newPost.classList.add("post");

            if (post.text) {
                newPost.innerHTML += `<p>${post.text}</p>`;
            }

            if (post.image) {
                newPost.innerHTML += `<img src="${post.image}" alt="Posted Image">`;
            }

            // Add the manage button on the top right side of each post
            var manageButton = document.createElement("button");
            manageButton.classList.add("manage-button");
            manageButton.innerHTML = `<img src="./images/manage.svg" alt="Manage">`;
            manageButton.addEventListener("click", function (event) {
                event.stopPropagation(); // Prevents the click from propagating to the post container
                openManageOverlay(newPostContainer);
            });

            newPostContainer.appendChild(manageButton);


            // Always add like and share buttons
            var postButtons = document.createElement("div");
            postButtons.classList.add("post-buttons");

            var likeButton = document.createElement("img");
            likeButton.src = "./images/Heart.svg"; // Replace with your image
            likeButton.alt = "Like";
            likeButton.addEventListener("click", function () {
                // Handle like button click
                alert("Liked!");
            });

            var shareButton = document.createElement("img");
            shareButton.src = "./images/Share.svg"; // Replace with your image
            shareButton.alt = "Share";
            shareButton.addEventListener("click", function () {
                // Handle share button click
                alert("Shared!");
            });

            postButtons.appendChild(likeButton);
            postButtons.appendChild(shareButton);

            newPost.appendChild(postButtons);

            newPostContainer.appendChild(newPost);

            postsContainer.appendChild(newPostContainer);
        });
    }

    function openManageOverlay(postContainer) {
        currentPostContainer = postContainer;

        var manageOverlay = document.getElementById("manageOverlay");

        // Calculate position based on the postContainer position
        var postRect = postContainer.getBoundingClientRect();
        manageOverlay.style.top = postRect.top + "px";
        manageOverlay.style.left = postRect.right + "px";

        manageOverlay.style.display = "block";
    }

    function closeManageOverlay() {
        var manageOverlay = document.getElementById("manageOverlay");
        manageOverlay.style.display = "none";
    }

    function deleteSelectedPost() {
        if (currentPostContainer) {
            currentPostContainer.remove();
            savePosts();
            closeManageOverlay();
        }
    }

    function editSelectedPost() {
        if (currentPostContainer) {
            var editPostText = document.getElementById("editPostText");
            var editFileInput = document.getElementById("editFileInput");
            var editFilePreview = document.getElementById("editFilePreview");
            var editFileName = document.getElementById("editFileName");

            var postText = currentPostContainer.querySelector(".post p");
            var postImage = currentPostContainer.querySelector(".post img");

            // Populate the edit overlay with the content of the selected post
            if (postText) {
                editPostText.value = postText.textContent;
            }

            if (postImage) {
                // Display the image preview in the edit overlay
                var imageURL = postImage.src;
                
                // Remove unwanted characters at the beginning of the URL
                if (imageURL.startsWith("data:image/")) {
                    imageURL = "";
                }

                editFilePreview.src = imageURL;

                // Set the file name in the edit overlay
                var fileName = imageURL.substring(imageURL.lastIndexOf('/') + 1);
                editFileName.textContent = fileName;
            }

            // Show the edit overlay
            toggleEditOverlay();

            // Close the manage overlay
            closeManageOverlay();
        }
    }

    function toggleEditOverlay() {
        var editOverlay = document.getElementById("editOverlay");
        editOverlay.style.display = (editOverlay.style.display === "none" || editOverlay.style.display === "") ? "block" : "none";
    }

    function updatePost() {
        // Implement your logic to update the selected post
        if (currentPostContainer) {
            var editPostText = document.getElementById("editPostText");
            var editFileInput = document.getElementById("editFileInput");
            var postText = currentPostContainer.querySelector(".post p");
            var postImage = currentPostContainer.querySelector(".post img");

            if (postText) {
                postText.textContent = editPostText.value;
            }

            if (editFileInput.files && editFileInput.files[0]) {
                // Update image if a new file is selected
                var reader = new FileReader();

                reader.onload = function (e) {
                    postImage.src = e.target.result;
                };

                reader.readAsDataURL(editFileInput.files[0]);
            }

            savePosts();
            closeEditOverlay();
        }
    }

    function closeEditOverlay() {
        var editOverlay = document.getElementById("editOverlay");
        editOverlay.style.display = "none";
    }

    function cancelManage() {
        closeManageOverlay();
    }

    function savePosts() {
        var posts = [];

        var postsContainer = document.getElementById("postsContainer");
        var postContainers = postsContainer.getElementsByClassName("post-container");

        for (var i = 0; i < postContainers.length; i++) {
            var postContainer = postContainers[i];
            var post = {};

            var postText = postContainer.querySelector(".post p");
            if (postText) {
                post.text = postText.textContent;
            }

            var postImage = postContainer.querySelector(".post img");
            if (postImage) {
                post.image = postImage.src;
            }

            posts.push(post);
        }

        localStorage.setItem("posts", JSON.stringify(posts));
    }