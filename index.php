<?php require_once 'includes/header.php' ?>

<?php
// unset($_SESSION["userLoggedIn"]);
if (isset($_SESSION["userLoggedIn"])) {
    echo "hello " . $userLoggedInObj->getUsername();
} else {
    echo "not Logged In";
}
?>

<?php require_once 'includes/footer.php' ?>
