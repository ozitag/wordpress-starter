<?php

namespace Core\Ajax;

abstract class Action
{
    abstract protected function getRequestClass(): string;

    abstract function execute(): ?Response;

    private $request = null;

    public function request(): Request
    {
        if (!$this->request) {
            $requestClassName = $this->getRequestClass();
            $this->request = new $requestClassName;
        }

        return $this->request;
    }
}