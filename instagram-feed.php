<?php
/*
Plugin Name: Instagram LiveSEO 
Description: Plugin para exibir posts do Instagram em um carrossel.
Version: 1.0
Author: LiveSEO
Author URI: https://liveseo.com.br
*/

require_once plugin_dir_path(__FILE__) . 'plugin-functions.php';
require_once plugin_dir_path(__FILE__) . 'script-enqueue.php';

add_action('admin_menu', 'instagram_feed_settings_menu');

function instagram_feed_settings_menu() {
    add_menu_page(
        'Instagram Feed - LiveSEO',
        'Instagram Feed',
        'manage_options',
        'instagram-feed-settings',
        'instagram_feed_settings_page',
        plugins_url('/assets/img/logo-liveseo.svg', __FILE__)
    );
}

function instagram_feed_settings_page() {
    ?>
    <div class="wrap">
        <h2>Configurações do Instagram Feed</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('instagram-feed-settings-group');
            do_settings_sections('instagram-feed-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'instagram_feed_settings_init');

function instagram_feed_settings_init() {
    register_setting(
        'instagram-feed-settings-group',
        'instagram_token'
    );

    register_setting(
        'instagram-feed-settings-group',
        'instagram_feed_title',
        array(
            'type' => 'string',
            'default' => 'Instagram Feed', // 
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    register_setting(
        'instagram-feed-settings-group',
        'instagram_feed_text',
        array(
            'type' => 'string',
            'default' => 'Texto Padrão', 
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    add_settings_section(
        'instagram_feed_settings_section',
        'Configurações do Token do Instagram',
        'instagram_feed_settings_section_callback',
        'instagram-feed-settings'
    );

    add_settings_field(
        'instagram_token',
        'Token do Instagram',
        'instagram_token_callback',
        'instagram-feed-settings',
        'instagram_feed_settings_section'
    );

    add_settings_section(
        'instagram_feed_title_section',
        'Configurações do Título do Feed do Instagram',
        'instagram_feed_title_section_callback',
        'instagram-feed-settings'
    );

    add_settings_field(
        'instagram_feed_title',
        'Título do Feed',
        'instagram_feed_title_callback',
        'instagram-feed-settings',
        'instagram_feed_title_section'
    );

    add_settings_section(
        'instagram_feed_text_section',
        'Configurações do Texto do Feed do Instagram',
        'instagram_feed_text_section_callback',
        'instagram-feed-settings'
    );

    add_settings_field(
        'instagram_feed_text',
        'Texto do Feed',
        'instagram_feed_text_callback',
        'instagram-feed-settings',
        'instagram_feed_text_section'
    );
}

function instagram_feed_settings_section_callback() {
    echo 'Insira o token do Instagram abaixo:';
}

function instagram_feed_title_section_callback() {
    echo 'Insira do título do Feed do Instagram:';
}

function instagram_feed_text_section_callback() {
    echo 'Insira do texto do Feed do Instagram:';
}

function instagram_token_callback() {
    $token = esc_attr(get_option('instagram_token'));
    echo "<input type='text' name='instagram_token' value='$token' />";
}

function instagram_feed_title_callback() {
    $title = esc_attr(get_option('instagram_feed_title', 'Instagram Feed'));
    echo "<input type='text' name='instagram_feed_title' value='$title' />";
}

function instagram_feed_text_callback() {
    $text = esc_attr(get_option('instagram_feed_text', 'Texto Padrão'));
    echo "<input type='text' name='instagram_feed_text' style='width:50%' value='$text' />";
}

function instagram_feed_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'title' => get_option('instagram_feed_title', 'Instagram Feed'),
            'text' => get_option('instagram_feed_text', 'Texto Padrão'),
        ),
        $atts,
        'instagram_feed'
    );

    ob_start();
    ?>
    <div class="glider-contain">
        <div class="instagram-content">
            <p class="instagram-title"><?php echo esc_html($atts['title']); ?></p>
            <?php
                if(!empty($atts['text'])){
            ?>
            <p class="instagram-text"><?php echo esc_html($atts['text']); ?></p>
            <?php
                } else {
                    echo '';
                }
            ?>
        </div>
        <div class="glider-instagram"></div>
        <button class="glider-prev">&#8249;</button>
        <button class="glider-next">&#8250;</button>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}

add_shortcode('instagram_feed', 'instagram_feed_shortcode');

/*Uninstall options */

register_uninstall_hook(__FILE__, 'my_plugin_uninstall');

function my_plugin_uninstall() {
    delete_option('instagram_feed_title');
    delete_option('instagram_feed_text');
}

?>
