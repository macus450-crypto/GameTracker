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

function gametracker_get_rawg_games($page = 1, $page_size = 12) {
    $page = max(1, (int) $page);
    $page_size = max(1, (int) $page_size);

    $api_key = defined('RAWG_API_KEY') ? RAWG_API_KEY : '';

    if (empty($api_key)) {
        return false;
    }

    $transient_key = 'gametracker_rawg_games_' . $page . '_' . $page_size;
    $cached_data = get_transient($transient_key);

    if ($cached_data !== false) {
        return $cached_data;
    }

    $url = add_query_arg(array(
        'key'       => $api_key,
        'page'      => $page,
        'page_size' => $page_size,
    ), 'https://api.rawg.io/api/games');

    $response = wp_remote_get($url, array(
        'timeout' => 15,
    ));

    if (is_wp_error($response)) {
        return false;
    }

    $status_code = wp_remote_retrieve_response_code($response);

    if ($status_code !== 200) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!is_array($data) || !isset($data['results'])) {
        return false;
    }

    set_transient($transient_key, $data, HOUR_IN_SECONDS);

    return $data;
}
    