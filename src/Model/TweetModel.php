<?php

namespace App\Model;

use PDO;

class TweetModel
{
    protected PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveTweet(string $content, string $author)
    {
        $query = $this->pdo->prepare('INSERT INTO tweet SET content = :content, author = :author, created_at = NOW()');
        $query->execute([
            "content" => $content,
            "author" => $author
        ]);
    }
}