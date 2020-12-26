<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta name="author" content="OZiTAG, ozitag.com">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php is_front_page() ? bloginfo('name') : wp_title(''); ?></title>

    <?php \Core\Helpers\Template::render('favicon'); ?>
    <?php \Core\Helpers\Template::render('fonts'); ?>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="preloader js-preloader"></div>
<div class="page__inner">
