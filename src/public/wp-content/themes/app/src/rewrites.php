<?php

add_action('init', 'do_rewrite');
function do_rewrite()
{
   /* add_rewrite_rule('^category/(.+?)/photo$', 'index.php?category_name=$matches[1]&filter=photo', 'top');
    add_rewrite_rule('^category/(.+?)/video$', 'index.php?category_name=$matches[1]&filter=video', 'top');

    add_rewrite_rule('^preview/upcoming', 'index.php?pagename=preview&filter=upcoming', 'top');
    add_rewrite_rule('^preview/past', 'index.php?pagename=preview&filter=past', 'top');

    add_filter('query_vars', function ($vars) {
        $vars[] = 'filter';
        return $vars;
    });*/
}
