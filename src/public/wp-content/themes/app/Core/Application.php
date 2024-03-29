<?php

namespace Core;

use Core\Ajax\AjaxProcessor;
use Core\Structures\Thumbnail;

abstract class Application
{
    abstract protected function ajaxRequests(): array;

    abstract protected function menus(): array;

    abstract protected function thumbnails(): array;

    abstract protected function getCurrentCriticalCssFile(): ?string;

    abstract protected function enabledComments(): bool;

    abstract protected function enabledPosts(): bool;

    abstract protected function supportPostTypesInSearch(): array;

    abstract protected function supportPostTypesInRssFeed(): array;

    abstract protected function customPostTypes(): array;

    static ?Application $app = null;

    static function app(): Application
    {
        if (!static::$app) {
            static::$app = new static();
        }

        return static::$app;
    }

    public function init()
    {
        add_action('wp_head', function () {
            if (defined('WP_ENV') && WP_ENV !== 'local') {
                $cssFile = $this->getCurrentCriticalCssFile();

                if (!empty($cssFile)) {
                    $fileName = dirname(__DIR__) . '/../html/dist/html/critical/' . $cssFile . '.css';

                    if (is_file($fileName)) {
                        $f = @fopen($fileName, 'r+');
                        $fileRaw = null;
                        if ($f) {
                            $fileRaw = fread($f, filesize($fileName));
                            fclose($f);
                        }

                        if (!empty($fileRaw)) {
                            echo '<style>' . $fileRaw . '</style>';
                            echo "\n" . '<link rel="preload" href="' . get_template_directory_uri() . '/html/dist/css/main.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">
<noscript><link rel="stylesheet" href="' . get_template_directory_uri() . '/html/dist/css/main.css"></noscript>
<script>!function(n){"use strict";n.loadCSS||(n.loadCSS=function(){});var t,o=loadCSS.relpreload={};o.support=function(){var e;try{e=n.document.createElement("link").relList.supports("preload")}catch(t){e=!1}return function(){return e}}(),o.bindMediaToggle=function(t){var e=t.media||"all";function a(){t.addEventListener?t.removeEventListener("load",a):t.attachEvent&&t.detachEvent("onload",a),t.setAttribute("onload",null),t.media=e}t.addEventListener?t.addEventListener("load",a):t.attachEvent&&t.attachEvent("onload",a),setTimeout(function(){t.rel="stylesheet",t.media="only x"}),setTimeout(a,3e3)},o.poly=function(){if(!o.support())for(var t=n.document.getElementsByTagName("link"),e=0;e<t.length;e++){var a=t[e];"preload"!==a.rel||"style"!==a.getAttribute("as")||a.getAttribute("data-loadcss")||(a.setAttribute("data-loadcss",!0),o.bindMediaToggle(a))}},o.support()||(o.poly(),t=n.setInterval(o.poly,500),n.addEventListener?n.addEventListener("load",function(){o.poly(),n.clearInterval(t)}):n.attachEvent&&n.attachEvent("onload",function(){o.poly(),n.clearInterval(t)})),"undefined"!=typeof exports?exports.loadCSS=loadCSS:n.loadCSS=loadCSS}("undefined"!=typeof global?global:this);</script>';
                            return;
                        }
                    }
                }
            }

            echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/html/dist/css/main.css">';
        });

        foreach ($this->ajaxRequests() as $actionName => $actionClass) {
            AjaxProcessor::registerAction($actionName, $actionClass);
        }

        add_action('init', function () {
            $postTypes = $this->customPostTypes();

            foreach ($postTypes as $postType) {
                $postType->register();
            }
        });

        add_action('init', function () {
            /** @var Thumbnail[] $thumbnails */
            $thumbnails = $this->thumbnails();
            if (!empty($thumbnails)) {
                add_theme_support('post-thumbnails');

                foreach ($thumbnails as $name => $thumbnail) {
                    $thumbnail->register($name);
                }
            }
        });

        add_action('after_setup_theme', function () {
            $menus = $this->menus();

            if (!empty($menus)) {
                foreach ($menus as $menuLocation => $menuDescription) {
                    register_nav_menu($menuLocation, $menuDescription);
                }
            }
        });

        add_action('admin_menu', function () {
            if ($this->enabledComments() == false) {
                remove_menu_page('edit-comments.php');
            }

            if ($this->enabledPosts() == false) {
                remove_menu_page('edit.php');
            }
        });

        if ($this->enabledComments() == false) {
            add_action('init', function () {
                remove_post_type_support('post', 'comments');
                remove_post_type_support('page', 'comments');
            });

            add_action('wp_before_admin_bar_render', function () {
                global $wp_admin_bar;
                $wp_admin_bar->remove_menu('comments');
            });
        }

        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');

        add_filter('script_loader_src', function ($src) {
            $parts = explode('?ver', $src);
            return $parts[0];
        }, 15, 1);

        add_filter('script_loader_src', function ($src) {
            $parts = explode('?ver', $src);
            return $parts[0];
        }, 15, 1);

        add_filter('pre_get_posts', function (\WP_Query $query) {
            if ($query->is_search) {
                $query->set('post_type', $this->supportPostTypesInSearch());
            }

            return $query;
        });

        add_filter('request', function ($qv) {
            if (isset($qv['feed']) && !isset($qv['post_type'])) {
                $qv['post_type'] = array('post');
            }
            return $qv;
        });

        add_filter('wpseo_metabox_prio', function () {
            return 'low';
        });

        add_filter('wp_mail_content_type', function () {
            return 'text/html';
        });

        add_filter('wp_image_editors', function () {
            return ['WP_Image_Editor_GD'];
        });

        // Remove Gutenberg Block Library CSS from loading on the frontend
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-block-style');
        }, 100);
        
        // Replace margin with padding to support Select2
        if (is_user_logged_in()) {
            add_action('wp_head', function () {
                $type_attr = current_theme_supports('html5', 'style') ? '' : ' type="text/css"';
                ?>
                <style<?php echo $type_attr; ?> media="screen">
                    html {
                        margin-top: 0 !important;
                        padding-top: 32px !important;
                    }

                    * html body {
                        margin-top: 0 !important;
                        padding-top: 32px !important;
                    }

                    @media screen and ( max-width: 782px ) {
                        html {
                            margin-top: 0 !important;
                            padding-top: 46px !important;
                        }

                        * html body {
                            margin-top: 0 !important;
                            padding-top: 46px !important;
                        }
                    }
                </style> <?php
            }, 100);
        }

        add_filter('protected_title_format', function () {
            return __('%s');
        });

        if (isset($_GET['wpml_lang'])) {
            do_action('wpml_switch_language', $_GET['wpml_lang']);
        }
    }
}
