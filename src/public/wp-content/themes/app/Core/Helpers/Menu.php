<?php

namespace Core\Helpers;

class Menu
{
    public static function getByThemeLocation(string $theme_location, bool $tree = false)
    {
        $menuLocations = get_nav_menu_locations();
        if (!isset($menuLocations[$theme_location])) {
            return null;
        }

        $menu = get_term($menuLocations[$theme_location], 'nav_menu');
        if (!$menu) {
            return null;
        }

        $menu_items = wp_get_nav_menu_items($menu->term_id);

        if (!$tree) {
            return array_values($menu_items);
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
}
