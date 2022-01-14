<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    public function testHomepage()
    {
        $name = $_GET["name"] = "Kevin";

        $controller = new \App\Controller\HelloController();
        $response = $controller->hello();

        $this->assertEquals("Hello Kevin", $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());

        $contentHeader = $response->getHeaders()["Content-type"];
        $this->assertEquals('text/html', $contentHeader);
    }
}