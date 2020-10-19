<?php

class Account 
{
    private $con;
    private $errorArray = [];
    
    public function __construct($con) {
        $this->con = $con;
    }

    public function login($username, $password) 
    {
        $password = hash("sha512", $password);

        $sql = "SELECT * FROM users 
                WHERE username = :username 
                AND password = :password";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();

        if ($query->rowCount() == 1) {
            return true;
        } else {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }

    public function register($firstName, $lastName, $username, $email, $confirm_email, $password, $confirm_password) 
    {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUsername($username);
        $this->validateEmails($email, $confirm_email);
        $this->validatePasswords($password, $confirm_password);

        if (empty($this->errorArray)) {
            return $this->insertUserDetails($firstName, $lastName, $username, $email, $password);
        } else {
            return false;
        }
    }

    private function insertUserDetails($firstName, $lastName, $username, $email, $password)
    {
        $password = hash("sha512", $password);
        $profilePic = "assets/img/profilePictures/default.png";

        $sql = "INSERT INTO users (firstName, lastName, username, email, password, profilePic) 
                VALUES (:firstName, :lastName, :username, :email, :password, :profilePic)";
        $query = $this->con->prepare($sql);
        $query->bindParam(":firstName", $firstName);
        $query->bindParam(":lastName", $lastName);
        $query->bindParam(":username", $username);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);
        $query->bindParam(":profilePic", $profilePic);

        return $query->execute();
    }

    private function validateFirstName($firstName) 
    {
        if (strlen($firstName) > 25 || strlen($firstName) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($lastName) 
    {
        if (strlen($lastName) > 25 || strlen($lastName) < 2) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($username) 
    {
        if (strlen($username) > 25 || strlen($username) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $sql = "SELECT username FROM users WHERE username = :username";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($email, $confirm_email) 
    {
        if ($email != $confirm_email) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $sql = "SELECT email FROM users WHERE email = :email";
        $query = $this->con->prepare($sql);
        $query->bindParam(":email", $email);
        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePasswords($password, $confirm_password) 
    {
        if ($password != $confirm_password) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if (preg_match("/[^A-Za-z0-9]/", $password)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }

        if (strlen($password) > 30 || strlen($confirm_password) < 5) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }
}