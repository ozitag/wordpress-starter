<?php

add_action('wp_ajax_test', 'my_ajax_test');
add_action('wp_ajax_nopriv_test', 'my_ajax_test');

function my_ajax_test()
{

}