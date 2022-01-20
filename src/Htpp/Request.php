<?php

namespace App\Htpp;

class Request
{
    protected array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }
}
