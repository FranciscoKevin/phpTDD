<?php

namespace App\Tests;

use App\Controller\HelloController;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    protected HelloController $controller;

    /**
     * SetUp test
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->controller = new HelloController();
    }

    public function testHomepageSayHello()
    {
        //Etant donné une requête HTTP avec un parametre name qui vaut Kevin
        $_GET["name"] = "Kevin";

        //Quand j'appelle l'action hello du HelloController
        $response = $this->controller->hello();

        //Alors la réponse doit être "Hello Kevin"
        $this->assertEquals("Hello Kevin", $response->getContent());
        //Voir si le statut est 200 (si tout s'est bien passé)
        $this->assertEquals(200, $response->getStatusCode());
        //Voir si l'entête Content-type contient "text/html"
        $contentHeader = $response->getHeaders("Content-type");
        $this->assertEquals('text/html', $contentHeader);
    }

    public function testIfNameInGET()
    {
        $_GET = [];
        $response = $this->controller->hello();

        $this->assertEquals("Hello everybody", $response->getContent());
    }
}