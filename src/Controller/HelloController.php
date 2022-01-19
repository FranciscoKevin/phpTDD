<?php

namespace App\Controller;

use App\Htpp\Response;

class HelloController
{
    public function hello(): Response
    {
        //Donne dans le tableau GET le "name" et si null alors donne "everbody"
        $name = $_GET["name"] ?? "everybody";

        return new Response("Hello $name");
    }
}