<?php

namespace Core\Structures;

class Taxonomy
{
    private string $name;

    private array $args;

    public function __construct(string $name, array $args)
    {
        $this->name = $name;

        $this->args = $args;
    }

    public function register($postType)
    {
        register_taxonomy($this->name, $postType, $this->args);
    }
}