<?php

require_once "includes/config.php";
require_once "includes/classes/Account.php";
require_once "includes/classes/Constants.php";
require_once "includes/classes/FormSanitizer.php";

$account = new Account($con);

if (isset($_POST["submitButton"])) {
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $confirm_email = FormSanitizer::sanitizeFormEmail($_POST["confirm_email"]);

    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $confirm_password = FormSanitizer::sanitizeFormPassword($_POST["confirm_password"]);
    
    $account->register($firstName, $lastName, $username, $email, $confirm_email, $password, $confirm_password);
}

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
</head>
<body>
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/img/icons/VideoTubeLogo.png" title="logo" alt="Logo">
                <h3>Sing Up</h3>
                <span>to continue to Chutube</span>
            </div>
            <div class="loginForm">
                <form action="signUp.php" method="POST">
                    <input type="text" name="firstName" placeholder="First name" autocomplete="off" required>
                    <?= $account->getError(Constants::$firstNameCharacters); ?>
                    
                    <input type="text" name="lastName" placeholder="Last name" autocomplete="off" required>
                    <?= $account->getError(Constants::$firstNameCharacters); ?>
                    
                    <input type="text" name="username" placeholder="Username" autocomplete="off" required>
                    <?= $account->getError(Constants::$usernameCharacters); ?>
                    <?= $account->getError(Constants::$usernameTaken); ?>
                    
                    <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                    <input type="email" name="confirm_email" placeholder="Confirm Email" autocomplete="off" required>
                    <?= $account->getError(Constants::$emailsDoNotMatch); ?>
                    <?= $account->getError(Constants::$emailInvalid); ?>
                    <?= $account->getError(Constants::$emailTaken); ?>
                    
                    <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" autocomplete="off" required>
                    <?= $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <?= $account->getError(Constants::$passwordNotAlphanumeric); ?>
                    <?= $account->getError(Constants::$passwordLength); ?>
                    
                    <input type="submit" name="submitButton" value="SUBMIT">
                </form>
            </div>
            <a href="signIn.php" class="signInMessage">Already have an account?</a>
        </div>
    </div>
</body>
</html>