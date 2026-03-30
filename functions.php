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

function gametracker_register_game_post_type() {
    register_post_type('game', array(
        'labels' => array(
            'name' => 'Games',
            'singular_name' => 'Game'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-controller',
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}

add_action('init', 'gametracker_register_game_post_type');

function gametracker_add_game_meta_boxes() {
    add_meta_box(
        'gametracker_game_times',
        'Game Times',
        'gametracker_game_times_callback',
        'game',
        'normal',
        'default'
    );
}

add_action('add_meta_boxes', 'gametracker_add_game_meta_boxes');

function gametracker_game_times_callback($post) {
    $main_story_hours = get_post_meta($post->ID, '_main_story_hours', true);
    $completionist_hours = get_post_meta($post->ID, '_completionist_hours', true);
    ?>

    <p>
        <label for="main_story_hours"><strong>Main Story Hours:</strong></label><br>
        <input type="number" id="main_story_hours" name="main_story_hours" value="<?php echo esc_attr($main_story_hours); ?>" style="width: 100%;">
    </p>

    <p>
        <label for="completionist_hours"><strong>Completionist Hours:</strong></label><br>
        <input type="number" id="completionist_hours" name="completionist_hours" value="<?php echo esc_attr($completionist_hours); ?>" style="width: 100%;">
    </p>

    <?php
}

function gametracker_save_game_meta($post_id) {
    if (array_key_exists('main_story_hours', $_POST)) {
        update_post_meta(
            $post_id,
            '_main_story_hours',
            sanitize_text_field($_POST['main_story_hours'])
        );
    }

    if (array_key_exists('completionist_hours', $_POST)) {
        update_post_meta(
            $post_id,
            '_completionist_hours',
            sanitize_text_field($_POST['completionist_hours'])
        );
    }
}

add_action('save_post_game', 'gametracker_save_game_meta');
