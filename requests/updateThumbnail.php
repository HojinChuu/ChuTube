<?php

require_once "../includes/config.php";

if (isset($_POST["videoId"]) && isset($_POST["thumbnailId"])) {
    
    $videoId = $_POST["videoId"];
    $thumbnailId = $_POST["thumbnailId"];

    $sql = "UPDATE thumbnails SET selected = 0 WHERE videoId = :videoId";
    $query = $con->prepare($sql);
    $query->bindParam(":videoId", $videoId);
    $query->execute();

    $sql = "UPDATE thumbnails SET selected = 1 WHERE id = :thumbnailId";
    $query = $con->prepare($sql);
    $query->bindParam(":thumbnailId", $thumbnailId);
    $query->execute();

}
else {
    echo "One or more parameters are not passed into updateThumbnail.php the file";
} 