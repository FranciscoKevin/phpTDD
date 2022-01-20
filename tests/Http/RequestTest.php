<?php

namespace App\Tests\Http;

use App\Htpp\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testInstanceRequest()
    {
        $request = new Request([
            "author" => "Kevin",
            "content" => "Test tweet"
        ]);

        $this->assertEquals("Kevin", $request->get("author"));
        $this->assertEquals("Test tweet", $request->get("content"));
        $this->assertNull($request->get("champ inexistant"));
    }
}
