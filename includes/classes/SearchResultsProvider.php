<?php

class SearchResultsProvider 
{
    private $con;
    private $userLoggedInObj;

    public function __construct($con, $userLoggedInObj)
    {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getVideo($term, $orderBy) 
    {
        $sql = "SELECT * FROM videos 
                WHERE title LIKE CONCAT('%', :term, '%') 
                OR uploadedBy LIKE CONCAT('%', :term, '%')
                ORDER BY $orderBy DESC";

        $query = $this->con->prepare($sql);
        $query->bindParam(":term", $term);
        $query->execute();

        $videos = [];

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }

        return $videos;
    }
}