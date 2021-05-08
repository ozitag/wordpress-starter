<?php

namespace Core\Ajax;

class SuccessResponse extends Response
{
    public function getStatusCode(): int
    {
        return 200;
    }

    public function getData()
    {
        return [
            'success' => true
        ];
    }
}