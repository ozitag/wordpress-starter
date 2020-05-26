<?php

add_action('init', 'init_post_types');
function init_post_types()
{
    /*
    $labels = array(
        'name' => _x('Products', 'post type general name', 'your-plugin-textdomain'),
        'singular_name' => _x('Product', 'post type singular name', 'your-plugin-textdomain'),
        'menu_name' => _x('Products', 'admin menu', 'your-plugin-textdomain'),
        'name_admin_bar' => _x('Product', 'add new on admin bar', 'your-plugin-textdomain'),
        'add_new' => _x('Add new', 'book', 'your-plugin-textdomain'),
        'add_new_item' => __('Add new product', 'your-plugin-textdomain'),
        'new_item' => __('New product', 'your-plugin-textdomain'),
        'edit_item' => __('Edit product', 'your-plugin-textdomain'),
        'view_item' => __('View product', 'your-plugin-textdomain'),
        'all_items' => __('All products', 'your-plugin-textdomain'),
        'search_items' => __('Search products', 'your-plugin-textdomain'),
        'not_found' => __('Products not found', 'your-plugin-textdomain'),
        'not_found_in_trash' => __('Products not found in trash', 'your-plugin-textdomain')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'thumbnail')
    );

    register_post_type('product', $args);

    $labels = array(
        'name' => _x('Category', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Category', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search categories', 'textdomain'),
        'popular_items' => __('Popular categories', 'textdomain'),
        'all_items' => __('All categories', 'textdomain'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit categories', 'textdomain'),
        'update_item' => __('Update categories', 'textdomain'),
        'add_new_item' => __('Add new categories', 'textdomain'),
        'new_item_name' => __('Name of category', 'textdomain'),
        'separate_items_with_commas' => __('Separate categories with commas', 'textdomain'),
        'add_or_remove_items' => __('Add or remove category', 'textdomain'),
        'choose_from_most_used' => __('Choose from most used', 'textdomain'),
        'not_found' => __('Categories not found', 'textdomain'),
        'menu_name' => __('Categories', 'textdomain'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => false,
    );

    register_taxonomy('product_category', 'product', $args);
*/

}