function setNewThumbnail(thumbnailId, videoId, itemElement) {
    $.post("requests/updateThumbnail.php", { videoId, thumbnailId })
    .done(() => {
        const item = $(itemElement);
        const itemClass = item.attr("class");

        $("." + itemClass).removeClass("selected");

        item.addClass("selected");
        alert("Thumbnail updated !");
    })
}