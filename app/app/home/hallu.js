console.log("hello");
showPost();

function displayFilePreview() {
    var fileInput = document.getElementById("fileInput");
    var filePreview = document.getElementById("filePreview");
    var fileNameElement = document.getElementById("fileName");

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            filePreview.src = e.target.result;
            fileNameElement.textContent = fileInput.files[0].name;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}

async function showPost() {
    try {
        let url = "/app/home/php/post_get_all.php";
        let response = await fetch(url);
        let result = await response.json();
        console.log(result);

        if (result.success && result.postList && result.postList.length > 0) {
            for (let post of result.postList) {
                putPost(post.username, post.userPost, post.imagePath, post.post_id, post.like_count);
            }
        } else {
            console.log("No posts to display");
        }
    } catch (error) {
        console.error("Error fetching posts:", error);
    }
}

// async function putPost(username, postText, imageFile, post_id, like_count) {
//     try {
//         var newPostContainer = document.createElement("div");
//         newPostContainer.classList.add("post-container");

//         // User profile container
//         var userProfileContainer = document.createElement("div");
//         userProfileContainer.classList.add("user-profile-container");

//         // User profile image
//         var userProfileImage = document.createElement("img");
//         userProfileImage.src = 'path/to/profile-pic.jpg'; // Replace with the actual path
//         userProfileImage.alt = "Profile Picture";

//         // User name
//         var userName = document.createElement("p");
//         userName.textContent = username;

//         userProfileContainer.appendChild(userProfileImage);
//         userProfileContainer.appendChild(userName);

//         var newPost = document.createElement("div");
//         newPost.classList.add("post");

//         if (postText.trim()) {
//             newPost.innerHTML += `<p>${postText}</p>`;
//         }

//         if (imageFile) {
//             // Trim the first 6 characters from imageFile and add "app/assets/"
//             var trimmedImageFile = "../../app/assets/uploads/" + imageFile;

//             console.log(trimmedImageFile);

//             var imgElement = document.createElement("img");
//             imgElement.src = trimmedImageFile; // Assuming trimmedImageFile is the actual path
//             imgElement.alt = trimmedImageFile;
//             newPost.appendChild(imgElement);
//         }

//         // Create a container to display the like count
//         var likeCountContainer = document.createElement("div");
//         likeCountContainer.classList.add("like-count-container");
//         // likeCountContainer.textContent = `Likes: ${like_count}`;
//         // Check if like_count is defined before displaying it
//         if (typeof like_count !== 'undefined') {
//             likeCountContainer.textContent = `Likes: ${like_count}`;
//         } else {
//             likeCountContainer.textContent = 'Likes: 0';
//         }
//         newPost.appendChild(likeCountContainer);

//         var postButtons = document.createElement("div");
//         postButtons.classList.add("post-buttons");

//         var likeButton = document.createElement("img");
//         likeButton.src = "../assets/images/Heart.svg";
//         likeButton.alt = "Like";
//         likeButton.addEventListener("click", function() {
//             likePost(post_id, likeCountContainer); // Pass the post_id and likeCountContainer
//         });

//         var shareButton = document.createElement("img");
//         shareButton.src = "../assets/images/Share.svg";
//         shareButton.alt = "Share";
//         shareButton.addEventListener("click", function() {
//             // Handle share button click
//             alert("Shared!");
//         });

//         postButtons.appendChild(likeButton);
//         postButtons.appendChild(shareButton);

//         newPost.appendChild(postButtons);

//         newPostContainer.appendChild(userProfileContainer); // Add the user profile container
//         newPostContainer.appendChild(newPost);

//         var postsContainer = document.getElementById("postsContainer");
//         postsContainer.prepend(newPostContainer);
        
        // let container = document.querySelector(".posts");
        // container.append(newPostContainer);
//     } catch (error) {
//         console.error("Error creating post:", error);
//     }
// }

async function likePost(post_id, likeCountContainer) {
    try {
        const response = await fetch('/app/home/php/like_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'post_id=' + encodeURIComponent(post_id),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        if (data.success) {
            console.log('Post liked successfully');
            // Increment the like count and update the display
            const updatedLikeCount = parseInt(likeCountContainer.textContent.split(' ')[1]) + 1;
            likeCountContainer.textContent = `Likes: ${updatedLikeCount}`;

            // Toggle the liked class on the heart icon
            const likeButton = likeCountContainer.parentElement.querySelector('.post-buttons img[alt="Like"]');
            likeButton.classList.toggle('liked');
        } else {
            console.error('Error liking post:', data.error);
            // Handle error appropriately
        }
    } catch (error) {
        console.error('Fetch error:', error);
        // Handle fetch error appropriately
    }
}


async function createPost() {
    let url, response, data, requestBody;

    var postText = document.getElementById("postText").value;
    var fileInput = document.getElementById("fileInput");
    var postImage = fileInput.files[0];
    console.log(postImage);

    // Check if both post text and image are empty
    if (!postText.trim() && !postImage) {
        alert("Please enter text or select an image for your post.");
        return;
    }

    url = "/app/home/php/post_create.php";
    requestBody = new FormData();
    requestBody.append('post_text', postText);
    requestBody.append('post_image', postImage);

    console.log("FormData content:");
    for (const pair of requestBody.entries()) {
        console.log(pair[0], pair[1]);
    }

    response = await fetch(url, {
        method: 'POST',
        body: requestBody
    });

    data = await response.json();
    console.log(data);

    // Create and append new post to the posts container
    putPost(data.username, postText, postImage);

    // Clear input fields and close overlay
    document.getElementById("postText").value = "";
    fileInput.value = "";
    document.getElementById("filePreview").src = "";
    document.getElementById("fileName").textContent = "Choose File";

    toggleOverlay();
}

async function putPost(username, postText, imageFile, post_id, like_count) {
    try {
        var newPostContainer = document.createElement("div");
        newPostContainer.classList.add("post-container");

        // User profile container
        var userProfileContainer = document.createElement("div");
        userProfileContainer.classList.add("user-profile-container");

        // User profile image
        var userProfileImage = document.createElement("img");
        userProfileImage.src = '../assets/images/profile-default.jpg'; // Replace with the actual path
        userProfileImage.alt = "Profile Picture";

        // User name
        var userName = document.createElement("p");
        userName.textContent = username;

        userProfileContainer.appendChild(userProfileImage);
        userProfileContainer.appendChild(userName);

        var newPost = document.createElement("div");
        newPost.classList.add("post");

        if (postText.trim()) {
            newPost.innerHTML += `<p>${postText}</p>`;
        }

        if (imageFile) {
            // Trim the first 6 characters from imageFile and add "app/assets/"
            var trimmedImageFile = "../../app/assets/uploads/" + imageFile;

            console.log(trimmedImageFile);

            var imgElement = document.createElement("img");
            imgElement.src = trimmedImageFile; // Assuming trimmedImageFile is the actual path
            imgElement.alt = trimmedImageFile;
            newPost.appendChild(imgElement);
        }

        var postButtons = document.createElement("div");
        postButtons.classList.add("post-buttons");

        var likeButton = document.createElement("img");
        likeButton.src = "../assets/images/Heart.svg";
        likeButton.alt = "Like";
        likeButton.addEventListener("click", function() {
            // Handle like button click
            alert("Liked!");
        });

        var shareButton = document.createElement("img");
        shareButton.src = "../assets/images/Share.svg";
        shareButton.alt = "Share";
        shareButton.addEventListener("click", function() {
            // Handle share button click
            alert("Shared!");
        });

        postButtons.appendChild(likeButton);
        postButtons.appendChild(shareButton);

        newPost.appendChild(postButtons);

        newPostContainer.appendChild(userProfileContainer); // Add the user profile container
        newPostContainer.appendChild(newPost);

        var postsContainer = document.getElementById("postsContainer");
        postsContainer.prepend(newPostContainer);

        // Clear input fields and preview after posting
        document.getElementById("postText").value = "";
        fileInput.value = "";
        document.getElementById("filePreview").src = "";
        document.getElementById("fileName").textContent = "Choose File";
    } catch (error) {
        console.error("Error creating post:", error);
    }
}


// Function to handle editing a post
async function editPost(postID, postElement) {
    var newPostText = prompt("Edit post:", postElement.querySelector("p").innerText);

    if (newPostText !== null) {
        try {
            const response = await fetch('/app/home/php/post_edit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'post_id=' + encodeURIComponent(postID) + '&new_post_text=' + encodeURIComponent(newPostText),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (data.success) {
                console.log('Post updated successfully');
                // Update the post content on the page
                postElement.querySelector("p").innerText = newPostText;
            } else {
                console.error('Error updating post:', data.error);
                // Handle error appropriately
            }
        } catch (error) {
            console.error('Fetch error:', error);
            // Handle fetch error appropriately
        }
    }
}