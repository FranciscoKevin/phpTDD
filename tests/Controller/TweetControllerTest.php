<?php

namespace App\Tests\Controller;

use App\Controller\TweetController;
use App\Model\TweetModel;
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
        $this->controller = new TweetController($this->tweetModel);

        $_POST = [];
    }

    public function testUserCanSaveTweet()
    {
        //Etant donné une requete POST vers /tweet.php et que les parametres "content" et "author" sont présents
        $_POST["author"] = "Kevin";
        $_POST["content"] = "Mon premier tweet";

        //Quand mon controller prend la main
        $response = $this->controller->saveTweet();

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

    public function testUserCantSaveTweetWithoutAuthor()
    {
        $_POST["content"] = "Tweet test";
        $response = $this->controller->saveTweet();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("Le champ author est manquant", $response->getContent());
    }

    public function testUserCantSaveTweetWithoutContent()
    {
        $_POST["author"] = "Kevin";
        $response = $this->controller->saveTweet();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("Le champ content est manquant", $response->getContent());
    }
}