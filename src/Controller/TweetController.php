<?php

namespace App\Controller;

use App\Htpp\Response;
use App\Model\TweetModel;

class TweetController
{
    protected TweetModel $tweetModel;
    protected array $requiredFields = [
        'author', 'content',
    ];

    public function __construct(TweetModel $tweetModel)
    {
        $this->tweetModel = $tweetModel;
    }

    public function saveTweet(): Response
    {
        foreach ($this->requiredFields as $field) {
            if (empty($_POST[$field])) {
                return new Response("Le champ $field est manquant", [], 400);
            }
        }

        $this->tweetModel->saveTweet($_POST["content"], $_POST["author"]);

        return new Response("", [
                "Location" => "/"
            ],
            302
        );
    }
}