<?php

namespace App;

class Application extends \Core\Application
{
    protected function ajaxRequests(): array
    {
        return [
            //    'subscribe' => SubscribeAction::class,
        ];
    }

    protected function customPostTypes(): array
    {
        /*   $vacancyPostType = new PostType('vacancy', [
               'labels' => [
                   'name' => _x('Products', 'post type general name', 'website-admin'),
                   'singular_name' => _x('Product', 'post type singular name', 'website-admin'),
                   'menu_name' => _x('Products', 'admin menu', 'website-admin'),
                   'name_admin_bar' => _x('Product', 'add new on admin bar', 'website-admin'),
                   'add_new' => _x('Add new', 'book', 'website-admin'),
                   'add_new_item' => __('Add new product', 'website-admin'),
                   'new_item' => __('New product', 'website-admin'),
                   'edit_item' => __('Edit product', 'website-admin'),
                   'view_item' => __('View product', 'website-admin'),
                   'all_items' => __('All products', 'website-admin'),
                   'search_items' => __('Search products', 'website-admin'),
                   'not_found' => __('Products not found', 'website-admin'),
                   'not_found_in_trash' => __('Products not found in trash', 'website-admin')
               ],
               'public' => true,
               'show_ui' => true,
               'show_in_menu' => true,
               'query_var' => true,
               'capability_type' => 'post',
               'has_archive' => false,
               'hierarchical' => false,
               'menu_position' => null,
               'supports' => ['title', 'thumbnail', 'excerpt', 'editor']
           ]);

           $vacancyPostType->addTaxonomy(new Taxonomy('vacancy_category', [
               'hierarchical' => true,
               'labels' => [
                   'name' => _x('Category', 'taxonomy general name', 'website-admin'),
                   'singular_name' => _x('Category', 'taxonomy singular name', 'website-admin'),
                   'search_items' => __('Search categories', 'website-admin'),
                   'popular_items' => __('Popular categories', 'website-admin'),
                   'all_items' => __('All categories', 'website-admin'),
                   'parent_item' => null,
                   'parent_item_colon' => null,
                   'edit_item' => __('Edit categories', 'website-admin'),
                   'update_item' => __('Update categories', 'website-admin'),
                   'add_new_item' => __('Add new categories', 'website-admin'),
                   'new_item_name' => __('Name of category', 'website-admin'),
                   'separate_items_with_commas' => __('Separate categories with commas', 'website-admin'),
                   'add_or_remove_items' => __('Add or remove category', 'website-admin'),
                   'choose_from_most_used' => __('Choose from most used', 'website-admin'),
                   'not_found' => __('Categories not found', 'website-admin'),
                   'menu_name' => __('Categories', 'website-admin'),
               ],
               'show_ui' => true,
               'show_admin_column' => true,
               'query_var' => false,
               'rewrite' => array(
                   'slug' => 'careers',
                   'with_front' => true
               ),
           ]));

           return [$vacancyPostType];*/

        return [];
    }

    protected function supportPostTypesInSearch(): array
    {
        return [];
    }

    protected function supportPostTypesInRssFeed(): array
    {
        return [];
    }

    protected function enabledComments(): bool
    {
        return false;
    }

    protected function enabledPosts(): bool
    {
        return false;
    }

    protected function thumbnails(): array
    {
        return [
            //    'background' => new Thumbnail(1900),
        ];
    }

    protected function menus(): array
    {
        return [
            // 'header' => 'Header Menu',
        ];
    }

    protected function getCurrentCriticalCssFile(): ?string
    {
        /*if (is_404()) {
            return '404';
        }*/

        return null;
    }
}
