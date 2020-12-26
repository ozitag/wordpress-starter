<?php

namespace Core\Helpers;

class Page
{
    public static function getPageByTemplate(string $template): ?\WP_Post
    {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => mb_substr($template, -4) === '.php' ? $template : $template . '.php',
            'hierarchical' => 0
        ));

        return count($pages) ? $pages[0] : null;
    }

    public static function getHomePageId(): int
    {
        return (int)get_option('page_on_front');
    }
}