<?php

class Video 
{
    private $con;
    private $sqlData;
    private $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj)
    {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if (is_array($input)) {
            $this->sqlData = $input;
        } 
        else {
            $sql = "SELECT * FROM videos WHERE id = :id";
            $query = $this->con->prepare($sql);
            $query->bindParam(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId()
    {
        return $this->sqlData["id"];
    }

    public function getUploadedBy()
    {
        return $this->sqlData["uploadedBy"];
    }

    public function getTitle()
    {
        return $this->sqlData["title"];
    }

    public function getDescription()
    {
        return $this->sqlData["description"];
    }

    public function getPrivacy()
    {
        return $this->sqlData["privacy"];
    }

    public function getFilePath()
    {
        return $this->sqlData["filePath"];
    }

    public function getCategory()
    {
        return $this->sqlData["category"];
    }

    public function getUploadDate()
    {
        $date = $this->sqlData["uploadDate"];
        return date("M j, Y", strtotime($date));
    }

    public function getViews()
    {
        return $this->sqlData["views"];
    }

    public function getDuration()
    {
        return $this->sqlData["duration"];
    }

    public function incrementViews()
    {
        $videoId = $this->getId();
        $sql = "UPDATE videos SET views = views + 1 WHERE id = :id";
        $query = $this->con->prepare($sql);
        $query->bindParam(":id", $videoId);
        $query->execute();

        $this->sqlData["views"] = $this->sqlData["views"] + 1;
    }

    public function getLikes()
    {
        $videoId = $this->getId();
        $sql = "SELECT count(*) as 'count' FROM likes WHERE videoId = :videoId";
        $query = $this->con->prepare($sql);
        $query->bindParam("videoId", $videoId);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    }

    public function getDislikes()
    {
        $videoId = $this->getId();
        $sql = "SELECT count(*) as 'count' FROM dislikes WHERE videoId = :videoId";
        $query = $this->con->prepare($sql);
        $query->bindParam("videoId", $videoId);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    }

    public function like()
    {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if ($this->wasLikedBy()) {
            // user has already liked
            $sql = "DELETE FROM likes WHERE username = :username AND videoId = :videoId";
            $query = $this->con->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = [
                "likes" => -1,
                "dislikes" => 0
            ];

            return json_encode($result);
        } 
        else {
            // user has not liked
            $sql = "DELETE FROM dislikes WHERE username = :username AND videoId = :videoId";
            $query = $this->con->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();
            $count = $query->rowCount();

            $sql = "INSERT INTO likes (username, videoId) VALUES (:username, :videoId)";
            $query = $this->con->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = [
                "likes" => 1,
                "dislikes" => 0 - $count
            ];

            return json_encode($result);
        }
    }

    public function dislike()
    {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if ($this->wasDislikedBy()) {
            // user has already liked
            $sql = "DELETE FROM dislikes WHERE username = :username AND videoId = :videoId";
            $query = $this->con->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = [
                "likes" => 0,
                "dislikes" => -1
            ];

            return json_encode($result);
        } 
        else {
            // user has not liked
            $sql = "DELETE FROM likes WHERE username = :username AND videoId = :videoId";
            $query = $this->con->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();
            $count = $query->rowCount();

            $sql = "INSERT INTO dislikes (username, videoId) VALUES (:username, :videoId)";
            $query = $this->con->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = [
                "likes" => 0 - $count,
                "dislikes" => 1
            ];

            return json_encode($result);
        }
    }

    public function wasLikedBy()
    {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        $sql = "SELECT * FROM likes WHERE username = :username AND videoId = :videoId";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->bindParam(":videoId", $id);
        $query->execute();

        return $query->rowCount() > 0;
    }

    public function wasDislikedBy()
    {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        $sql = "SELECT * FROM dislikes WHERE username = :username AND videoId = :videoId";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->bindParam(":videoId", $id);
        $query->execute();

        return $query->rowCount() > 0;
    }

    public function getNumberOfComments()
    {
        $id = $this->getId();
        $sql = "SELECT * FROM comments WHERE videoId = :videoId";
        $query = $this->con->prepare($sql);
        $query->bindParam(":videoId", $id);
        $query->execute();

        return $query->rowCount();
    }
}