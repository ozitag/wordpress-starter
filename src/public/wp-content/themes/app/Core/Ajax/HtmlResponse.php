<?php

namespace Core\Ajax;

class HtmlResponse extends Response
{
    protected string $html;

    public function __construct(string $html)
    {
        $this->html = $html;
    }

    public function getStatusCode(): int
    {
        return 200;
    }

    public function getData()
    {
        return $this->html;
    }

    public function getContentType(): string
    {
        return self::ContentTypeHtml;
    }
}