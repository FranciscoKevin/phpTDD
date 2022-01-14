<?php

namespace App\Controller;

use App\Htpp\Response;

class HelloController
{
    public function hello(): Response
    {
        $name = $_GET["name"];

        return new Response("Hello $name");
    }
}