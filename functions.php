<?php

function gametracker_enqueue_assets() {
    wp_enqueue_style(
        'gametracker-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0'
    );

    wp_enqueue_script(
        'gametracker-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'gametracker_enqueue_assets');
