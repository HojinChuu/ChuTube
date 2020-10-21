<?php

require_once "includes/header.php";

if (isset($_GET["username"])) {
    $profileUsername = $_GET["username"];
    echo $profileUsername;
} 
else {
    echo "Channel not found";
    exit();
}