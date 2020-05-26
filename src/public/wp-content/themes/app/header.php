<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="OZiTAG, ozitag.com">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

    <link rel="shortcut icon" href="<?= get_template_directory_uri() ?>/html/dist/static/images/meta/favicon.png"
          type="image/png">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800&display=swap">
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/html/dist/css/main.css?v=374">
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/custom.css">
</head>
<body <?php body_class(); ?>>
<div class="preloader js-preloader"></div>
<div class="page__inner">
