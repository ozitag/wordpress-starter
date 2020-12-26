<?php

namespace Core\Ajax;

abstract class Response
{
    abstract public function getStatusCode(): int;

    abstract public function getData(): array;
}