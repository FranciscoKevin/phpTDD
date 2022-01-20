<?php

namespace App\Controller;

use App\Htpp\Request;
use App\Htpp\Response;
use App\Model\TweetModel;
use App\Validation\RequestValidator;

class TweetController
{
    protected TweetModel $tweetModel;
    protected RequestValidator $requestValidator;
    protected array $requiredFields = [
        'author', 'content',
    ];

    public function __construct(TweetModel $tweetModel, RequestValidator $requestValidator)
    {
        $this->tweetModel = $tweetModel;
        $this->requestValidator = $requestValidator;
    }

    /**
     * Retourne une reponse si les champs en base sont remplies
     *
     * @param Request $request
     * @return Response
     */
    public function saveTweet(Request $request): Response
    {
        if ($response = $this->requestValidator->validateFields($request, $this->requiredFields)) {
            return $response;
        }

        $this->tweetModel->saveTweet($request->get("content"), $request->get("author"));

        return new Response("", [
                "Location" => "/"
            ],
            302
        );
    }
}
