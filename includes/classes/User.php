<?php

class User 
{
    private $con;
    private $sqlData;

    public function __construct($con, $username)
    {
        $this->con = $con;

        $sql = "SELECT * FROM users WHERE username = :username";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION["userLoggedIn"]);
    }

    public function getUsername()
    {
        return User::isLoggedIn() ? $this->sqlData["username"] : null;
    }

    public function getName()
    {
        return $this->sqlData["firstName"] . " " . $this->sqlData["lastName"];
    }

    public function getFirstName()
    {
        return $this->sqlData["firstName"];
    }

    public function getLastName()
    {
        return $this->sqlData["lastName"];
    }

    public function getEmail()
    {
        return $this->sqlData["email"];
    }

    public function getProfilePic()
    {
        return $this->sqlData["profilePic"];
    }

    public function getSignUpDate()
    {
        return $this->sqlData["signUpDate"];
    }

    public function isSubscribedTo($userTo)
    {
        $username = $this->getusername();
        $sql = "SELECT * FROM subscribers 
                WHERE userTo = :userTo AND userFrom = :userFrom";
        $query = $this->con->prepare($sql);
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $username);
        $query->execute();

        return $query->rowCount() > 0;
    }

    public function getSubscriberCount()
    {
        $username = $this->getusername();
        $sql = "SELECT * FROM subscribers WHERE userTo = :userTo";
        $query = $this->con->prepare($sql);
        $query->bindParam(":userTo", $username);
        $query->execute();
        
        return $query->rowCount();
    }
}