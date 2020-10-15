<?php 

require_once "includes/config.php";
require_once "includes/classes/User.php"; 
require_once 'includes/classes/Video.php';

$usernameLoggedIn = User::isLoggedIn() ? $_SESSION["userLoggedIn"] : "";
$userLoggedInObj = new User($con, $usernameLoggedIn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>ChuTube</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="assets/js/commonActions.js"></script>
</head>
<body>
    <div id="pageContainer">
        <div id="mastHeadContainer">

            <button class="navShowHide">
                <img src="assets/img/icons/menu.png">
            </button>

            <a class="logoContainer" href="index.php">
                <img src="assets/img/icons/VideoTubeLogo.png" title="logo" alt="Logo">
            </a>

            <div class="searchBarContainer">
                <form method="GET" action="search.php">
                    <input type="text" class="searchBar" name="term" placeholder="Search..">
                    <button class="searchButton">
                        <img src="assets/img/icons/search.png">
                    </button>
                </form>
            </div>

            <div class="rightIcons">
                <a href="upload.php">
                    <img class="upload" src="assets/img/icons/upload.png">
                </a>
                <a href="#">
                    <img class="upload" src="assets/img/profilePictures/default.png">
                </a>
            </div>

        </div>
        <div id="sideNavContainer">
        
        </div>
        <div id="mainSectionContainer">
            <div id="mainContentContainer">