<?php

namespace Core\Ajax;

use Core\Helpers\MimeType;

class UploadedFile
{
    protected string $fileName;

    protected string $mimeType;

    protected string $tempName;

    protected int $size;

    protected int $error;

    public function __construct(array $fileData)
    {
        $this->fileName = $fileData['name'] ?? null;
        $this->mimeType = $fileData['type'] ?? null;
        $this->tempName = $fileData['tmp_name'] ?? null;
        $this->size = $fileData['size'] ?? null;
        $this->error = $fileData['error'] ?? null;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function checkExtension(array $validExtensions): bool
    {
        $validExtensions = array_map(function ($ext) {
            return strtolower($ext);
        }, $validExtensions);

        return in_array($this->getExtension(), $validExtensions);
    }

    public function saveAs(string $filename): bool
    {
        return move_uploaded_file($this->tempName, $filename);
    }

    public function getExtension(): ?string
    {
        if (!empty($this->mimeType)) {
            $result = MimeType::getExtensionByMime($this->mimeType);

            if (!empty($result)) {
                return strtolower($result);
            }
        }

        $p = strrpos($this->fileName, '.');
        if ($p !== false) {
            return strtolower(substr($this->fileName, $p));
        }

        return null;
    }
}