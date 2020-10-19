<?php require_once 'includes/header.php' ?>

<?php
echo isset($_SESSION["userLoggedIn"]) 
? "hello " . $userLoggedInObj->getUsername()
: "not Logged In";
?>

<?php require_once 'includes/footer.php' ?>
