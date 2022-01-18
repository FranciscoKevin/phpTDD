<?php

use PHPUnit\Framework\TestCase;
use App\Model\TweetModel;

class TweetModelTest extends TestCase
{
    public function testSaveTweet()
    {
        // Setup : on va vider la base de données 
        $pdo = new PDO("mysql:host=localhost;dbname=php_tdd;charset=utf8", "php_tdd", "test", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $pdo->query("DELETE FROM tweet");

        // Etant donné un auteur et un contenu
        $author = "Kev";
        $content = "Mon premier tweet";

        //Quand j'appelle mon model et que je veux sauver un tweet
        $tweetModel = new TweetModel($pdo);
        $result = $tweetModel->saveTweet($content, $author);

        // Alors je reçois bien un identifiant
        //$this->assertNotNull($newTweetId);

        // Et le tweet correspondant à cet identifiant existe bien
        $result = $pdo->query('SELECT t.* FROM tweet AS t');

        //Le tweet a le bon author et le bon content
        $data = $result->fetch();
        //$this->assertNotFalse($tweet);
        $this->assertEquals($author, $data['author']);
        $this->assertEquals($content, $data['content']);
    }
}
