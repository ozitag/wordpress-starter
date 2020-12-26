<?php

namespace Core\Ajax;

class ServerErrorResponse extends Response
{
    private string $error;

    private ?array $data;

    public function __construct(string $error, ?array $data = null)
    {
        $this->error = $error;

        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return 500;
    }

    public function getData(): array
    {
        $result = [
            'error' => $this->error
        ];

        if ($this->data !== null) {
            $result['data'] = $this->data;
        }

        return $result;
    }
}