<?php

function gametracker_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'gametracker_theme_setup');

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

    wp_nonce_field('gametracker_save_game_times', 'gametracker_game_times_nonce');
    ?>

    <p>
        <label for="main_story_hours"><strong>Main Story Hours:</strong></label><br>
        <input
            type="number"
            id="main_story_hours"
            name="main_story_hours"
            value="<?php echo esc_attr($main_story_hours); ?>"
            min="0"
            style="width: 100%;"
        >
    </p>

    <p>
        <label for="completionist_hours"><strong>Completionist Hours:</strong></label><br>
        <input
            type="number"
            id="completionist_hours"
            name="completionist_hours"
            value="<?php echo esc_attr($completionist_hours); ?>"
            min="0"
            style="width: 100%;"
        >
    </p>

    <?php
}

function gametracker_save_game_meta($post_id) {
    if (
        !isset($_POST['gametracker_game_times_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(wp_unslash($_POST['gametracker_game_times_nonce'])),
            'gametracker_save_game_times'
        )
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (wp_is_post_revision($post_id)) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['main_story_hours'])) {
        $main_story_hours = wp_unslash($_POST['main_story_hours']);
        $main_story_hours = ($main_story_hours === '') ? '' : absint($main_story_hours);

        update_post_meta(
            $post_id,
            '_main_story_hours',
            $main_story_hours
        );
    }

    if (isset($_POST['completionist_hours'])) {
        $completionist_hours = wp_unslash($_POST['completionist_hours']);
        $completionist_hours = ($completionist_hours === '') ? '' : absint($completionist_hours);

        update_post_meta(
            $post_id,
            '_completionist_hours',
            $completionist_hours
        );
    }
}

add_action('save_post_game', 'gametracker_save_game_meta');

function gametracker_get_rawg_games($page = 1, $page_size = 12, $search = '', $ordering = '', $genre = '') {
    $page = min(40, max(1, (int) $page));
    $page_size = min(40, max(1, (int) $page_size));
    $search = trim((string) $search);
    $ordering = trim((string) $ordering);
    $genre = trim((string) $genre);

    $api_key = defined('RAWG_API_KEY') ? RAWG_API_KEY : '';

    if (empty($api_key)) {
        return ['results' => []];
    }

    $transient_args = array(
        'page' => $page,
        'page_size' => $page_size,
    );

    if ($search !== '') {
        $transient_args['search'] = $search;
    }

    if ($ordering !== '') {
        $transient_args['ordering'] = $ordering;
    }

    if ($genre !== '') {
        $transient_args['genres'] = $genre;
    }

    $transient_key = 'gametracker_rawg_games_' . md5(json_encode($transient_args));

    $cached_data = get_transient($transient_key);

    if ($cached_data !== false) {
        return $cached_data;
    }

    $args = array(
        'key' => $api_key,
        'page' => $page,
        'page_size' => $page_size,
    );

    if ($search !== '') {
        $args['search'] = $search;
    }

    if ($ordering !== '') {
        $args['ordering'] = $ordering;
    }

    if ($genre !== '') {
        $args['genres'] = $genre;
    }

    $url = add_query_arg($args, 'https://api.rawg.io/api/games');

    $response = wp_remote_get($url, array(
        'timeout' => 15,
    ));

    if (is_wp_error($response)) {
        $fallback_data = get_transient('gametracker_rawg_last_success');

        if ($fallback_data !== false) {
            return $fallback_data;
        }

        return ['results' => []];
    }

    $status_code = wp_remote_retrieve_response_code($response);

    if ($status_code !== 200) {
        $fallback_data = get_transient('gametracker_rawg_last_success');

        if ($fallback_data !== false) {
            return $fallback_data;
        }

        return ['results' => []];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!is_array($data) || !isset($data['results'])) {
        $fallback_data = get_transient('gametracker_rawg_last_success');

        if ($fallback_data !== false) {
            return $fallback_data;
        }

        return ['results' => []];
    }

    if ($page === 1) {
        $time = HOUR_IN_SECONDS;
    } else {
        $time = 10 * MINUTE_IN_SECONDS;
    }

    set_transient('gametracker_rawg_last_success', $data, DAY_IN_SECONDS);
    set_transient($transient_key, $data, $time);

    return $data;
}

    