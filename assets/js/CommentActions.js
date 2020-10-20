function postComment(button, postedBy, videoId, replyTo, containerClass) {
    const textarea = $(button).siblings("textarea");
    const commentText = textarea.val();
    textarea.val("");

    if (commentText) {
        $.post("requests/postComment.php", { commentText, postedBy, videoId, "responseTo": replyTo })
        .done(comment => {
            if (!replyTo) {
                $("." + containerClass).prepend(comment);
            } else {
                $(button).parent().siblings("." + containerClass).append(comment);
            }
        });
    }
    else {
        alert("You can't post an empty comment");
    }

    // remove
    const parent = $(button).closest(".itemContainer"); 
    const commentForm = parent.find(".commentForm").first();
    commentForm.toggleClass("hidden");
}

function toggleReply(button) {
    const parent = $(button).closest(".itemContainer"); // 바로 위 부모하나만
    const commentForm = parent.find(".commentForm").first();
    commentForm.toggleClass("hidden");
}

function likeComment(commentId, button, videoId) {
    $.post("requests/likeComment.php", { commentId, videoId })
    .done(numToChange => {
        const likeButton = $(button);
        const dislikeButton = $(button).siblings(".dislikeButton");

        likeButton.addClass("active");
        dislikeButton.removeClass("active");

        const likesCount = $(button).siblings(".likesCount");
        updateLikesValue(likesCount, numToChange);

        if (numToChange < 0) {
            likeButton.removeClass("active");
            likeButton.find("img:first").attr("src", "assets/img/icons/thumb-up.png");
        } else {
            likeButton.find("img:first").attr("src", "assets/img/icons/thumb-up-active.png");
        }

        dislikeButton.find("img:first").attr("src", "assets/img/icons/thumb-down.png");
    });
}

function dislikeComment(commentId, button, videoId) {
    $.post("requests/dislikeComment.php", { commentId, videoId })
    .done(numToChange => {
        const dislikeButton = $(button);
        const likeButton = $(button).siblings(".likeButton");

        dislikeButton.addClass("active");
        likeButton.removeClass("active");

        const likesCount = $(button).siblings(".likesCount");
        updateLikesValue(likesCount, numToChange);

        if (numToChange > 0) {
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

function getReplies(commentId, button, videoId) {
    $.post("requests/getCommentReplies.php", { commentId, videoId })
    .done(comments => {
        const replies = $("<div>").addClass("repliesSection");
        replies.append(comments);

        $(button).replaceWith(replies); // button 대신 replies
    })
}