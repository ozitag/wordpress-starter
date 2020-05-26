<?php

add_action('init', 'custom_init');
function custom_init()
{
    add_theme_support('post-thumbnails');

    /*
    add_image_size('achievements-icon', 140, 140);
    add_image_size('achievements-icon@2x', 280, 280);
    */
}

add_action('after_setup_theme', 'register_my_menu');
function register_my_menu()
{
    // register_nav_menu('header_menu', 'Header Menu');
    // register_nav_menu('footer_menu', 'Footer Menu');
}

add_filter('body_class', function ($classes) {
    if (\OziTag\lib\is_webp_support()) {
        $classes[] = 'webp';
    }

    return $classes;
});
