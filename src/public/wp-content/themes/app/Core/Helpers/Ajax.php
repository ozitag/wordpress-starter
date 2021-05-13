<?php

namespace Core\Helpers;

class Ajax
{
    public static function getActionUrl(string $action, array $queryParams = []): string
    {
        return get_admin_url() . 'admin-ajax.php?action=' . $action . (empty($queryParams) ? '' : '&' . http_build_query($queryParams));
    }
}