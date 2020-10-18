<?php

require_once "ButtonProvider.php";
require_once "CommentControls.php";

class Comment
{
    private $con;
    private $sqlData;
    private $userLoggedInObj;
    private $videoId;

    public function __construct($con, $input, $userLoggedInObj, $videoId)
    {
        if (!is_array($input)) {
            $sql = "SELECT * FROM comments WHERE id = :id";
            $query = $con->prepare($sql);
            $query->bindParam(":id", $input);
            $query->execute();
            $input = $query->fetch(PDO::FETCH_ASSOC);
        }

        $this->sqlData = $input;
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->videoId = $videoId;
    }

    public function create()
    {
        $id = $this->sqlData["id"];
        $videoId = $this->getVideoId();
        $body = $this->sqlData["body"];
        $postedBy = $this->sqlData["postedBy"];
        $profileButton = ButtonProvider::createUserProfileButton($this->con, $postedBy);
        $timespan = $this->time_elapsed_string($this->sqlData["datePosted"]);

        $commentControlsObj = new CommentControls($this->con, $this, $this->userLoggedInObj);
        $commentControls = $commentControlsObj->create();

        $numResponses = $this->getNumberOfReplies();
        $viewRepliesText = "";

        if ($numResponses > 0) {
            $viewRepliesText = "<span class='repliesSection viewReplies' onclick='getReplies($id, this, $videoId)'>
                                    View all $numResponses replies
                                </span>";
        } else {
            $viewRepliesText = "<div class='repliesSection'></div>";
        }

        return "<div class='itemContainer'>
                    <div class='comment'>
                        $profileButton

                        <div class='mainContainer'>
                            <div class='commentHeader'>
                                <a href='profile.php?username=$postedBy'>
                                    <span class='username'>$postedBy</span>
                                </a>
                                <span class='timestamp'>$timespan</span>
                            </div>

                            <div class='body'>
                                $body
                            </div>
                        </div>
                    </div>
                    $commentControls
                    $viewRepliesText
                </div>";
    }

    public function getNumberOfReplies()
    {
        $id = $this->sqlData["id"];
        $sql = "SELECT count(*) FROM comments WHERE responseTo = :responseTo";
        $query = $this->con->prepare($sql);
        $query->bindParam(":responseTo", $id);
        $query->execute();

        return $query->fetchColumn();
    }

    // timestamp ago
    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function getId()
    {
        return $this->sqlData["id"];
    }

    public function getVideoId()
    {
        return $this->videoId;
    }

    public function wasLikedBy()
    {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        $sql = "SELECT * FROM likes WHERE username = :username AND commentId = :commentId";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->bindParam(":commentId", $id);
        $query->execute();

        return $query->rowCount() > 0;
    }

    public function wasDislikedBy()
    {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        $sql = "SELECT * FROM dislikes WHERE username = :username AND commentId = :commentId";
        $query = $this->con->prepare($sql);
        $query->bindParam(":username", $username);
        $query->bindParam(":commentId", $id);
        $query->execute();

        return $query->rowCount() > 0;
    }

    public function getLikes()
    {
        $commentId = $this->getId();

        $sql = "SELECT count(*) as 'count' FROM likes WHERE commentId = :commentId";
        $query = $this->con->prepare($sql);
        $query->bindParam(":commentId", $commentId);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $numLikes = $data["count"];

        $sql = "SELECT count(*) as 'count' FROM dislikes WHERE commentId = :commentId";
        $query = $this->con->prepare($sql);
        $query->bindParam(":commentId", $commentId);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $numDislikes = $data["count"];

        return $numLikes - $numDislikes;
    }
}