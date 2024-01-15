 function displayFilePreview() {
        var fileInput = document.getElementById("fileInput");
        var filePreview = document.getElementById("filePreview");
        var fileNameElement = document.getElementById("fileName");

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

        if (!postText.trim() && !imageFile) {
            alert("Please enter text or select an image for your post.");
            return;
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
        shareButton.src = "./images/Forward_Arrow.svg"; // Replace with your image
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

        document.getElementById("postText").value = "";
        fileInput.value = "";
        document.getElementById("filePreview").src = "";
        document.getElementById("fileName").textContent = "Choose File";

        toggleOverlay();
    }

    function toggleOverlay() {
        var overlay = document.getElementById("overlay");
        overlay.style.display = (overlay.style.display === "none" || overlay.style.display === "") ? "block" : "none";
    }
