<?php

namespace App\Controller;

use App\Htpp\Response;
use App\Model\TweetModel;

class TweetController
{
    protected TweetModel $tweetModel;

    public function __construct(TweetModel $tweetModel)
    {
        $this->tweetModel = $tweetModel;
    }

    public function saveTweet(): Response
    {
        $this->tweetModel->saveTweet($_POST["content"], $_POST["author"]);

        return new Response("", [
                "Location" => "/"
            ],
            302
        );
    }
}