<?php

add_filter('theme_root_uri', 'my_theme_root_uri');
function my_theme_root_uri($theme_root_uri)
{
    return env('WP_THEME_URI') ? env('WP_THEME_URI') : $theme_root_uri;
}

add_action('admin_menu', 'my_remove_admin_menus');
function my_remove_admin_menus()
{
    remove_menu_page('edit-comments.php');
    remove_menu_page('upload.php');
}

add_action('init', 'remove_comment_support', 100);
function remove_comment_support()
{
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}

function mytheme_admin_bar_render()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}

add_action('wp_before_admin_bar_render', 'mytheme_admin_bar_render');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

function _remove_script_version($src)
{
    $parts = explode('?ver', $src);
    return $parts[0];
}

add_filter('script_loader_src', '_remove_script_version', 15, 1);
add_filter('style_loader_src', '_remove_script_version', 15, 1);


add_filter('wpcf7_form_autocomplete', 'my_wpcf7_form_autocomplete');
function my_wpcf7_form_autocomplete()
{
    return 'off';
}

function my_search(WP_Query $query)
{
    if ($query->is_search) {
        $query->set('post_type', ['post']);
    }

    return $query;
}

add_filter('pre_get_posts', 'my_search');

function myfeed_request($qv)
{
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('post');
    return $qv;
}

add_filter('request', 'myfeed_request');

function yoasttobottom()
{
    return 'low';
}

add_filter('wpseo_metabox_prio', 'yoasttobottom');

add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
