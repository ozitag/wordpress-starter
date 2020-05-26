<?php

namespace App;

function getMenuByThemeLocation($theme_location, $tree = false)
{
    $menu = get_term(get_nav_menu_locations()[$theme_location], 'nav_menu');
    if (!$menu) {
        return null;
    }

    $menu_items = wp_get_nav_menu_items($menu->term_id);

    if (!$tree) {
        return $menu_items;
    }

    $root_items = array_filter($menu_items, function ($menu_item) {
        return $menu_item->menu_item_parent == 0;
    });

    $root_items = array_map(function ($menu_item) {
        return [
            'post' => $menu_item,
            'children' => []
        ];
    }, $root_items);


    $root_items_filtered = [];
    foreach ($root_items as $item) {
        $root_items_filtered[$item['post']->ID] = $item;
    }

    foreach ($menu_items as $menu_item) {
        if ($menu_item->menu_item_parent != 0 && isset($root_items_filtered[$menu_item->menu_item_parent])) {
            $root_items_filtered[$menu_item->menu_item_parent]['children'][] = $menu_item;
        }
    }

    return $root_items_filtered;
}


function renderImage($attachment_id, $size = 'full', $retina = false, $alt = '')
{
    if (!$attachment_id) return;
    if ($size === null) $size = 'full';

    $imageType = get_post_mime_type($attachment_id);
    $original = wp_get_attachment_image_url($attachment_id, $size);

    $originalImgHtml = '<img class="lazy" data-original="' . $original . '" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="' . $alt . '">';

    if ($imageType == 'image/svg+xml') {
        echo $originalImgHtml;
        return;
    }

    $output = '<picture>';

    if ($retina) {
        $image2x = is_integer($retina) ? wp_get_attachment_image_url($retina, 'full') : wp_get_attachment_image_url($attachment_id, $size . '@2x');
        $srcset = $original . ' 1x, ' . $image2x . ' 2x';
    } else {
        $image = wp_get_attachment_image_src($attachment_id, $size);
        $image_meta = wp_get_attachment_metadata($attachment_id);
        list($src, $width, $height) = $image;
        $size_array = array(absint($width), absint($height));
        $srcset = wp_calculate_image_srcset($size_array, $src, $image_meta, $attachment_id);
    }

    $output .= '<source data-srcset="' . $srcset . '" type="' . $imageType . '">';
    $output .= $originalImgHtml;
    $output .= '</picture>';

    echo $output;
}

function renderIcon($icon)
{
    echo '<svg class="icon icon-' . $icon . '">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="' . get_template_directory_uri() . '/html/dist/static/images/svg/spriteInline.svg#' . $icon . '"/>
                    </svg>';
}

function renderTemplate($template_name)
{
    get_template_part('templates/' . $template_name);
}
