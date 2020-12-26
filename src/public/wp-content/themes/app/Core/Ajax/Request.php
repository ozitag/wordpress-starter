<?php

namespace Core\Ajax;

abstract class Request
{
    abstract public function validate(): ?string;

    private array $files = [];

    private array $data = [];

    public function __construct()
    {
        $this->loadData();
        $this->loadFiles();
    }

    private function getContentType(): ?string
    {
        if (!isset($_SERVER['CONTENT_TYPE'])) {
            return null;
        }

        if (substr($_SERVER['CONTENT_TYPE'], 0, strlen('multipart/form-data')) == 'multipart/form-data') {
            return 'multipart/form-data';
        }

        if (substr($_SERVER['CONTENT_TYPE'], 0, strlen('application/x-www-form-urlencoded')) == 'application/x-www-form-urlencoded') {
            return 'application/x-www-form-urlencoded';
        }

        return $_SERVER['CONTENT_TYPE'];
    }

    private function loadData(): void
    {
        if ($this->getContentType() == 'application/json') {
            $entityBody = file_get_contents('php://input');
            $bodyParams = json_decode($entityBody, true);
        } else {
            $bodyParams = $_POST;
        }

        $queryParams = $_GET;
        if (isset($queryParams['action'])) {
            unset($queryParams['action']);
        }

        $this->data = array_merge($bodyParams, $queryParams);
    }

    private function loadFiles()
    {
        if (!empty($_FILES)) {
            foreach ($_FILES as $param => $file) {
                $this->files[$param] = new UploadedFile($file);
            }
        }
    }

    public function file(string $param): ?UploadedFile
    {
        return $this->files[$param] ?? null;
    }

    public function param(string $param, ?string $default = null)
    {
        return $this->data[$param] ?? $default;
    }
}