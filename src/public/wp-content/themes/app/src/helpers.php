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


function my_process_image_url($url)
{
    $result = $url;

    if (getenv('WP_IMAGES_HOME')) {
        return str_replace(getenv('WP_HOME'), getenv('WP_IMAGES_HOME'), $result);
    }

    return $result;
}

function renderImage($attachment_id, $size = 'full', $retina = false, $alt = '')
{
    if (!$attachment_id) return;
    if ($size === null) $size = 'full';

    $imageType = get_post_mime_type($attachment_id);
    $original = my_process_image_url(wp_get_attachment_image_url($attachment_id, $size));

    $originalImgHtml = '<img class="lazy" data-original="' . $original . '" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="' . $alt . '">';

    if ($imageType == 'image/svg+xml') {
        echo $originalImgHtml;
        return;
    }

    $output = '<picture>';

    if ($retina) {
        $image2x = is_integer($retina) ? my_process_image_url(wp_get_attachment_image_url($retina, 'full')) : my_process_image_url(wp_get_attachment_image_url($attachment_id, $size . '@2x'));
        $srcset = $original . ' 1x, ' . $image2x . ' 2x';
    } else {
        $image = wp_get_attachment_image_src($attachment_id, $size);
        $image_meta = wp_get_attachment_metadata($attachment_id);
        list($src, $width, $height) = $image;
        $size_array = array(absint($width), absint($height));
        $srcset = my_process_image_url(wp_calculate_image_srcset($size_array, $src, $image_meta, $attachment_id));
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
                             xlink:href="' . get_template_directory_uri() . '/html/dist/assets/images/spriteInline.svg#' . $icon . '"/>
                    </svg>';
}

function renderHtmlImage($image, $ext = 'png')
{
    $dirPath = get_template_directory() . '/html/dist/assets/images';

    $imagePath = $dirPath . '/' . $image . '.' . $ext;
    if (!is_file($imagePath)) {
        return;
    }

    $image2xPath = $dirPath . '/' . $image . '@2x.' . $ext;
    $has2x = is_file($image2xPath);

    $imageWebpPath = $dirPath . '/' . $image . '.webp';
    $hasWebp = is_file($imageWebpPath);

    $imageUri = get_template_directory_uri() . '/html/dist/assets/images/' . $image;

    echo '<picture>';

    if ($hasWebp) {
        echo '<source data-srcset="' . $imageUri . '.webp' . ($has2x ? ', ' . $imageUri . '@2x.webp 2x' : '') . '" type="image/webp">';
    }

    $mimeType = $ext == 'png' ? 'image/png' : 'image/jpeg';
    echo '<source data-srcset="' . $imageUri . '.' . $ext . ($has2x ? ', ' . $imageUri . '@2x.'.$ext.' 2x' : '') . '" type="' . $mimeType . '">';

    echo '<img class="lazy" data-sizes="auto" data-original="' . $imageUri . '.' . $ext . '"
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt>';

    echo '</picture>';
}

function renderSvgImageAsInline($attachment_id)
{
    if (!$attachment_id) return;

    $imageType = get_post_mime_type($attachment_id);
    if ($imageType != 'image/svg+xml') {
        renderImage($attachment_id);
        return;
    }

    $attachment = wp_get_attachment_metadata($attachment_id);

    $filePath = null;
    if (isset($attachment['sizes'])) {
        $filePath = get_attached_file($attachment_id);
    } else {
        $filePath = wp_upload_dir()['basedir'] . '/' . $attachment['file'];
    }

    if (!$filePath || !is_file($filePath)) {
        return;
    }

    $f = fopen($filePath, 'r+');
    $raw = fread($f, filesize($filePath));
    fclose($f);

    echo $raw;
}

function renderTemplate($template_name)
{
    get_template_part('templates/' . $template_name);
}

/**
 * @param $template
 * @return \WP_Post
 */
function getPageByTemplate($template)
{
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => mb_substr($template, -4) === '.php' ? $template : $template . '.php',
        'hierarchical' => 0
    ));

    return count($pages) ? $pages[0] : null;
}

function render($template, $params = [], $return = false)
{
    foreach ($params as $param => $value) {
        set_query_var($param, $value);
    }

    if ($return) {
        ob_start();
    }

    get_template_part('templates/' . $template);

    if ($return) {
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }
}


/**
 * @return int
 */
function getHomePageId()
{
    return (int)get_option('page_on_front');
}
