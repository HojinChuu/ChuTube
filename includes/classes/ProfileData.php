<?php

class ProfileData
{
    private $con, $profileUserObj;

    public function __construct($con, $profileUsername)
    {
        $this->con = $con;
        $this->profileUserObj = new User($con, $profileUsername);
    }

    public function getProfileUserObj()
    {
        return $this->profileUserObj;
    }

    public function getProfileUsername()
    {
        return $this->profileUserObj->getUsername();
    }

    public function userExists()
    {
        $profileUsername = $this->getProfileUsername();
        $sql = "SELECT * FROM users WHERE username = :username";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $profileUsername);
        $query->execute();

        return $query->rowCount() != 0;
    }

    public function getCoverPhoto()
    {
        return "assets/img/coverPhotos/default-cover-photo.jpg";
    }

    public function getProfileUserFullName()
    {
        return $this->profileUserObj->getName();
    }

    public function getProfilePic()
    {
        return $this->profileUserObj->getProfilePic();
    }

    public function getSubscriberCount()
    {
        return $this->profileUserObj->getSubscriberCount();
    }

    public function getUserVideos()
    {
        $username = $this->getProfileUsername();
        $sql = "SELECT * FROM videos WHERE uploadedBy = :uploadedBy ORDER BY uploadDate DESC";
        $query = $this->con->prepare($sql);
        $query->bindParam(":uploadedBy", $username);
        $query->execute();

        $videos = [];

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $videos[] = new Video($this->con, $row, $username);
        }

        return $videos;
    }

    public function getAllUserDetails()
    {
        return array(
            "Name" => $this->getProfileUserFullName(),
            "Username" => $this->getProfileUsername(),
            "Subscribers" => $this->getSubscriberCount(),
            "Total views" => $this->getTotalViews(),
            "Sign up date" => $this->getSignUpDate()
        );
    }

    private function getTotalViews()
    {
        $username = $this->getProfileUsername();
        $sql = "SELECT sum(views) FROM videos WHERE uploadedBy = :uploadedBy";
        $query = $this->con->prepare($sql);
        $query->bindParam(":uploadedBy", $username);
        $query->execute();

        return $query->fetchColumn();
    }

    private function getSignUpDate()
    {
        $date = $this->profileUserObj->getSignUpdate();
        return date("F jS , Y", strtotime($date));
    }
}