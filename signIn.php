<?php require_once "includes/config.php" ?>

<!DOCTYPE html>
<html>
<head>
    <title>ChuTube</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/img/icons/VideoTubeLogo.png" title="logo" alt="Logo">
                <h3>Sing In</h3>
                <span>to continue to Chutube</span>
            </div>
            <div class="loginForm">
                <form action="signIn.php">
                    <input type="text" name="username" placeholder="Username" required autocomplete="off">
                    
                    <input type="password" name="password" placeholder="Password" required>
                    
                    <input type="submit" name="submitButton" value="SUBMIT">
                </form>
            </div>
            <a href="signUp.php" class="signInMessage">Need an account?</a>
        </div>
    </div>
</body>
</html>