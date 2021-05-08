<?php

namespace Core\Ajax;

abstract class Response
{
    const ContentTypeHtml = 'html';
    const ContentTypeJson = 'json';

    abstract public function getStatusCode(): int;

    abstract public function getData();

    protected function getContentType(): string
    {
        return static::ContentTypeJson;
    }

    public function isJson(): bool
    {
        return $this->getContentType() === static::ContentTypeJson;
    }

    public function isHtml(): bool
    {
        return $this->getContentType() === static::ContentTypeHtml;
    }
}