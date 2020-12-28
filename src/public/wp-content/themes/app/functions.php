<?php

if (!defined('WP_ENV') || WP_ENV != 'local') {
    $acfFile = __DIR__ . '/App/ACF/acf.php';
    if (is_file($acfFile)) {
        require_once $acfFile;
    }
}

spl_autoload_register(function ($className) {
    $className = str_replace("\\", '/', $className);

    if (substr($className, 0, 4) !== 'App/' && substr($className, 0, 5) !== 'Core/') {
        return false;
    }

    $fileName = __DIR__ . '/' . $className . '.php';

    if (!is_file($fileName)) {
        return false;
    }

    require_once $fileName;

    return true;
});

\App\Application::app()->init();
