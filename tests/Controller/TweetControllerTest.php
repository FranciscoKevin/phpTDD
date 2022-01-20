<?php

namespace App\Tests\Controller;

use App\Controller\TweetController;
use App\Htpp\Request;
use App\Model\TweetModel;
use App\Validation\RequestValidator;
use PDO;
use PHPUnit\Framework\TestCase;

class TweetControllerTest extends TestCase
{
    protected PDO $pdo;
    protected TweetModel $tweetModel;
    protected TweetController $controller;

    /**
     * SetUp test
     *
     * @return void
     */
    protected function setUp(): void
    {
        //Instance PDO
        $this->pdo = new PDO("mysql:host=localhost;dbname=php_tdd;charset=utf8", "php_tdd", "test", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $this->pdo->query('DELETE FROM tweet');

        //Instance du Model
        $this->tweetModel = new TweetModel($this->pdo);
        //Instance du Controller
        $this->controller = new TweetController(
            $this->tweetModel,
            new RequestValidator
        );
    }

    public function testUserCanSaveTweet()
    {
        //Etant donné une requete POST vers /tweet.php et que les parametres "content" et "author" sont présents
        $request = new Request([
           "author" => "Kevin",
           "content" => "Mon premier tweet"
        ]);

        //Quand mon controller prend la main
        $response = $this->controller->saveTweet($request);

        //Alors je m'attends à être rediriger vers /
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals("/", $response->getHeaders("Location"));

        //Et je m'attends à trouver  un tweet dans la base de données
        $result = $this->pdo->query('SELECT t.* FROM tweet AS t');
        $this->assertEquals(1, $result->rowCount());
    
        //Le tweet a le bon author et le bon content
        $data = $result->fetch();
        $this->assertEquals("Kevin", $data["author"]);
        $this->assertEquals("Mon premier tweet", $data["content"]);
    }

    public function missingFieldsProvider()
    {
        return [
            [
                ["content" => "Test tweet"],
                "Le champ author est manquant"
            ],
            [
                ["author" => "Kevin"],
                "Le champ content est manquant"
            ],
            [
                [],
                "Les champs author, content sont manquants"
            ]
        ];
    }

    /**
     * @dataProvider missingFieldsProvider
     * @param array $postData
     * @param string $errorMessage
     */
    public function testTweetFieldsAreMissing($postData, $errorMessage)
    {
        $request = new Request($postData) ;

        $response = $this->controller->saveTweet($request);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($errorMessage, $response->getContent());
    }
}
