<?php

class LikedVideosProvider 
{
    private $con;
    private $userLoggedInObj;

    public function __construct($con, $userLoggedInObj)
    {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getVideos()
    {
        $username = $this->userLoggedInObj->getUsername();
        $videos = [];

        $sql = "SELECT videoId FROM likes 
                WHERE username = :username 
                ORDER BY id DESC";

        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $videos[] = new Video($this->con, $row["videoId"], $this->userLoggedInObj);
            // array_push($videos, $video);
        }

        return $videos;
    }
}