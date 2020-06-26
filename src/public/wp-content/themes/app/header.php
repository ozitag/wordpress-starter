<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="OZiTAG, ozitag.com">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

    <meta name="msapplication-TileColor" content="#cdfc91">
    <meta name="msapplication-config"
          content="<?= get_template_directory_uri() ?>/html/dist/static/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <link rel="apple-touch-icon" sizes="180x180"
          href="<?= get_template_directory_uri() ?>/html/dist/static/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?= get_template_directory_uri() ?>/html/dist/static/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?= get_template_directory_uri() ?>/html/dist/static/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= get_template_directory_uri() ?>/html/dist/static/images/favicon/site.webmanifest"
          crossorigin="use-credentials">
    <link rel="mask-icon"
          href="<?= get_template_directory_uri() ?>/html/dist/static/images/favicon/safari-pinned-tab.svg"
          color="#6607df">

    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/html/dist/css/main.css?v=374">
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/custom.css">

    <? wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="preloader js-preloader"></div>
<div class="page__inner">
