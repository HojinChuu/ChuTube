<?php

class VideoPlayer
{
    private $video;

    public function __construct($video)
    {
        $this->video = $video;
    }

    public function create($autoPlay)
    {
        $autoPlay = $autoPlay ? "autoplay" : "";
        $filePath = $this->video->getFilePath();

        return "<video class='videoPlayer' controls $autoPlay muted>
                    <source src='$filePath' type='video/mp4'>
                    Your browser does not support the video tag
                </video>";
    }
}