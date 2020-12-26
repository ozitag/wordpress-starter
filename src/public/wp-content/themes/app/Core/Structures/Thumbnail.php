<?php

namespace Core\Structures;

class Thumbnail
{
    private ?int $width;

    private ?int $height;

    private bool $use2x;

    private bool $crop;

    public function __construct(?int $width = null, ?int $height = null, bool $use2x = false, bool $crop = false)
    {
        $this->width = $width;
        $this->height = $height;
        $this->use2x = $use2x;
        $this->crop = $crop;
    }

    public function register(string $name)
    {
        add_image_size($name, $this->width, $this->height, $this->crop);

        if ($this->use2x) {
            add_image_size($name . '@2x', $this->width * 2, $this->height * 2, $this->crop);
        }
    }
}