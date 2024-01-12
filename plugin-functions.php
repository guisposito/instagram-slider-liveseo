<?php

//Instagram posts
function get_instagram_posts() {
    $token = get_option('instagram_token');
    $api_url = 'https://graph.instagram.com/v13.0/me/media?fields=id,media_url,permalink,media_type&limit=20';
    $response = wp_safe_remote_get($api_url . '&access_token=' . $token);

    if (is_wp_error($response)) {
        wp_send_json(array('error' => 'Erro ao buscar posts do Instagram'));
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    $posts = array();
    foreach ($data->data as $post) {
        if ($post->media_type === 'IMAGE') {
            $post_data = array(
                'media_url' => $post->media_url,
                'permalink' => $post->permalink,
            );
            $posts[] = $post_data;
        }
    }

    wp_send_json($posts);
}

add_action('rest_api_init', function () {
    register_rest_route('instagram/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'get_instagram_posts',
    ));
});


?>