<?php

namespace App\Htpp;

class Response
{
    protected string $content = "";
    protected array $headers = [];
    protected int $statusCode = 200;

    public function __construct(string $content = "", array $headers = ["Content-type" => "text/html"], int $statusCode = 200)
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function sendResponse(): void
    {
        echo $this->content;

        foreach($this->headers as $key => $value) {
            header($key . ": " . $value);
        }
        
        http_response_code($this->statusCode);
    }
}