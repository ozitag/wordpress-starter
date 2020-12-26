<?php

namespace Core\Structures;

class PostType
{
    private string $name;

    private array $args;

    /** @var Taxonomy[] */
    private array $taxonomies = [];

    public function __construct(string $name, array $args)
    {
        $this->name = $name;

        $this->args = $args;
    }

    public function addTaxonomy(Taxonomy $taxonomy)
    {
        $this->taxonomies[] = $taxonomy;
    }

    public function register()
    {
        register_post_type($this->name, $this->args);

        foreach ($this->taxonomies as $taxonomy) {
            $taxonomy->register($this->name);
        }
    }
}