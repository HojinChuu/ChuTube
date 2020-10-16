<?php

require_once "../includes/config.php";

if (isset($_POST["userTo"]) && isset($_POST["userFrom"])) {
    
    $userTo = $_POST["userTo"];
    $userFrom = $_POST["userFrom"];

    // check if the user is subbed
    $sql = "SELECT * FROM subscribers WHERE userTo = :userTo AND userFrom = :userFrom";
    $query = $con->prepare($sql);
    $query->bindParam(":userTo", $userTo);
    $query->bindParam(":userFrom", $userFrom);
    $query->execute();

    if ($query->rowCount() == 0) {
        // if not subbed - insert
        $sql = "INSERT INTO subscribers (userTo, userFrom) VALUES (:userTo, :userFrom)";
        $query = $con->prepare($sql);
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);
        $query->execute();
    } 
    else {
        // if subbed - delete
        $sql = "DELETE FROM subscribers WHERE userTo = :userTo AND userFrom = :userFrom";
        $query = $con->prepare($sql);
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);
        $query->execute();
    }

    // return new number of subs
    $sql = "SELECT * FROM subscribers WHERE userTo = :userTo";
    $query = $con->prepare($sql);
    $query->bindParam(":userTo", $userTo);
    $query->execute();

    echo $query->rowCount();
    
}
else {
    echo "One or more parameters are not passed into subscribe.php the file";
} 