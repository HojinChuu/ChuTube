function postComment(button, postedBy, videoId, replyTo, containerClass) {
    const textarea = $(button).siblings("textarea");
    const commentText = textarea.val();
    textarea.val("");

    if (commentText) {
        
        $.post("requests/postComment.php", { commentText, postedBy, videoId, "responseTo": replyTo })
        .done(comment => {
            
            $("." + containerClass).prepend(comment);

        });

    }
    else {
        alert("You can't post an empty comment");
    }
}

function toggleReply(button) {
    const parent = $(button).closest(".itemContainer"); // 바로 위 부모하나만
    const commentForm = parent.find(".commentForm").first();

    commentForm.toggleClass("hidden");
}