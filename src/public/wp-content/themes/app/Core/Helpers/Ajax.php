<?php

namespace Core\Helpers;

class Ajax
{
    public static function getActionUrl(string $action, array $queryParams = []): string
    {
        $url = get_admin_url() . 'admin-ajax.php?action=' . $action . (empty($queryParams) ? '' : '&' . http_build_query($queryParams));

        $my_current_lang = apply_filters('wpml_current_language', NULL);
        if ($my_current_lang) {
            $url = add_query_arg('wpml_lang', $my_current_lang, $url);
        }

        return $url;
    }
}