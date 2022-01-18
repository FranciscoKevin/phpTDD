<?php

namespace App\Tests\Controller;

use App\Model\TweetModel;
use PDO;
use PHPUnit\Framework\TestCase;

class TweetControllerTest extends TestCase
{
    public function testUserSaveTweet()
    {
        //Set up bdd
        $pdo = new PDO("mysql:host=localhost;dbname=php_tdd;charset=utf8", "php_tdd", "test", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $pdo->query('DELETE FROM tweet');

        //Etant donné une requete POST vers /tweet.php et que les parametres "content" et "author" sont présents
        $_POST["author"] = "Kevin";
        $_POST["content"] = "Mon premier tweet";

        //Instance du model
        $tweetModel = new TweetModel($pdo);

        //Quand mon controller prend la main
        $controller = new \App\Controller\TweetController($tweetModel);
        $response = $controller->saveTweet();

        //Alors je m'attends à être rediriger vers /
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals("/", $response->getHeaders("Location"));

        //Et je m'attends à trouver  un tweet dans la base de données
        $result = $pdo->query('SELECT t.* FROM tweet AS t');
        $this->assertEquals(1, $result->rowCount());
    
        //Le tweet a le bon author et le bon content
        $data = $result->fetch();
        $this->assertEquals("Kevin", $data["author"]);
        $this->assertEquals("Mon premier tweet", $data["content"]);
    }
}