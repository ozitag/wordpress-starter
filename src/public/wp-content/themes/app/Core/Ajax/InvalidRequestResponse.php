<?php

namespace Core\Ajax;

class InvalidRequestResponse extends Response
{
    private string $error;

    public function __construct(string $error)
    {
        $this->error = $error;
    }

    public function getStatusCode(): int
    {
        return 400;
    }

    public function getData(): array
    {
        return [
            'error' => $this->error
        ];
    }
}