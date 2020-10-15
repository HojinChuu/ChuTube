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

    public function getUsername()
    {
        return $this->sqlData["username"];
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
}