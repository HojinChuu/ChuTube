<?php

require_once "../includes/config.php";
require_once "../includes/classes/User.php";
require_once "../includes/classes/Comment.php";

if (isset($_POST["commentText"]) && isset($_POST["postedBy"]) && isset($_POST["videoId"])) {
    
    $postedBy = $_POST["postedBy"];
    $videoId = $_POST["videoId"];
    $responseTo = $_POST["responseTo"];
    $commentText = $_POST["commentText"];

    $sql = "INSERT INTO comments (postedBy, videoId, responseTo, body) 
            VALUES (:postedBy, :videoId, :responseTo, :body)";
    $query = $con->prepare($sql);
    $query->bindParam(":postedBy", $postedBy);
    $query->bindParam(":videoId", $videoId);
    $query->bindParam(":responseTo", $responseTo);
    $query->bindParam(":body", $commentText);
    $query->execute();

    $lastInsertId = $con->lastInsertId(); // 유저에서 선택쿼리 실행되기 때문에 먼저 할당
    $username = $_SESSION["userLoggedIn"];
    
    // return new comment html
    $userLoggedInObj = new User($con, $username);
    $newComment = new Comment($con, $lastInsertId, $userLoggedInObj, $videoId);
    echo $newComment->create();

}
else {
    echo "One or more parameters are not passed into subscribe.php the file";
} 