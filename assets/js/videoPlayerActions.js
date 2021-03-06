function likeVideo(button, videoId) {
    $.post("requests/likeVideo.php", { videoId })
    .done(res => {
        const likeButton = $(button);
        const dislikeButton = $(button).siblings(".dislikeButton");

        likeButton.addClass("active");
        dislikeButton.removeClass("active");

        const result = JSON.parse(res);
        updateLikesValue(likeButton.find(".text"), result.likes);
        updateLikesValue(dislikeButton.find(".text"), result.dislikes);

        if (result.likes < 0) {
            likeButton.removeClass("active");
            likeButton.find("img:first").attr("src", "assets/img/icons/thumb-up.png");
        } else {
            likeButton.find("img:first").attr("src", "assets/img/icons/thumb-up-active.png");
        }

        dislikeButton.find("img:first").attr("src", "assets/img/icons/thumb-down.png");
    });
}

function dislikeVideo(button, videoId) {
    $.post("requests/dislikeVideo.php", { videoId })
    .done(res => {
        const dislikeButton = $(button);
        const likeButton = $(button).siblings(".likeButton");

        dislikeButton.addClass("active");
        likeButton.removeClass("active");

        const result = JSON.parse(res);
        updateLikesValue(likeButton.find(".text"), result.likes);
        updateLikesValue(dislikeButton.find(".text"), result.dislikes);

        if (result.dislikes < 0) {
            dislikeButton.removeClass("active");
            dislikeButton.find("img:first").attr("src", "assets/img/icons/thumb-down.png");
        } else {
            dislikeButton.find("img:first").attr("src", "assets/img/icons/thumb-down-active.png");
        }

        likeButton.find("img:first").attr("src", "assets/img/icons/thumb-up.png");
    });
}

function updateLikesValue(element, num) {
    let likesCountVal = element.text() || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));
}