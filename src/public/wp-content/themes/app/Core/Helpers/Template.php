<?php

namespace Core\Helpers;

class Template
{
    public static function render(string $template, array $params = [], bool $return = false): ?string
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
            return (string)$var;
        }

        return null;
    }
}