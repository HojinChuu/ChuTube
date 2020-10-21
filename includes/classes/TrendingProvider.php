<?php

class TrendingProvider 
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
        $videos = [];

        $sql = "SELECT * FROM videos 
                WHERE uploadDate >= now() - INTERVAL 7 DAY 
                ORDER BY views DESC LIMIT 15";

        $query = $this->con->prepare($sql);
        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }

        return $videos;
    }
}