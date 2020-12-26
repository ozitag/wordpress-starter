<?php

namespace Core\Helpers;

class Ajax
{
    public static function getActionUrl(string $action): string
    {
        return get_admin_url() . 'admin-ajax.php?action=' . $action;
    }
}