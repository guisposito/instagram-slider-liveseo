<?php
// instagram-feed/script-enqueue.php

add_action('wp_head', 'slider_car');

function slider_car() {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) . 'glider/glider.min.css'; ?>">
    <script src="<?php echo plugin_dir_url(__FILE__) . 'glider/glider.min.js'; ?>"></script>
    <?php
}

add_action('wp_enqueue_scripts', 'instagram_feed_styles');

function instagram_feed_styles() {
    wp_enqueue_style('instagram-feed-custom-style', plugin_dir_url(__FILE__) . 'assets/css/custom-style.css');
}


add_action('wp_enqueue_scripts', 'enqueue_instagram_feed_styles_and_scripts');

function enqueue_instagram_feed_styles_and_scripts() {
    
    wp_enqueue_script('jquery');
    
    wp_enqueue_script('glider-script', plugin_dir_url(__FILE__) . 'glider/glider.min.js', array('jquery'), '1.0', true);

    wp_enqueue_script('slider-config', plugin_dir_url(__FILE__) . 'js/slider-config.js', array('jquery', 'glider-script'), '1.0', true);

    wp_localize_script('slider-config', 'instagram_feed_params', array('rest_url' => esc_url_raw(rest_url())));
}