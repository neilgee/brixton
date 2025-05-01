<?php

add_action('login_enqueue_scripts', 'bt_css_inline_login', 1009);
/**
 * Inline Style for login CSS
 *
 * @since 1.0.0
 */
function bt_css_inline_login() {
    $handle = 'login';
    
    // Fetch theme modifications
    $theme_mods = [
        'hero_bg_image'          => get_theme_mod('hero_bg'),
        'login_color'            => get_theme_mod('bt_login_accent_color'),
        'login_hover_color'      => get_theme_mod('bt_login_accent_hover_color'),
        'login_background_color' => get_theme_mod('bt_login_background_color'),
        'login_link_color'       => get_theme_mod('bt_login_link_color'),
        'login_link_hover_color' => get_theme_mod('bt_login_link_hover_color'),
        'login_form_color'       => get_theme_mod('bt_login_form_color'),
        'login_form_text_color'  => get_theme_mod('bt_login_form_text'),
        'login_logo'             => get_theme_mod('bt_login_logo')
    ];
    
    // Fetch WP custom logo
    $custom_logo_id = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
    $custom_logo_url = (!empty($custom_logo_id)) ? $custom_logo_id[0] : '';
    
    $login_logo = isset($theme_mods['login_logo']) ? $theme_mods['login_logo'] : $custom_logo_url;
    $font_login = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
    
    $css = sprintf(' 
        .login h1 a,
        .login .wp-login-logo a {
            background-image: url(%s);
            width: 300px !important;
            height: 100px !important;
            background-size: contain;
            background-position: center;
        }
        body {
            background: %s;
            font-family: %s;
        }
        .wp-core-ui .button-primary {
            background: %s;
            border-color: %s;
        }
        .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary:focus {
            background: %s;
            border-color: %s;
            opacity: .8;
        }
        .login form {
            color: %s;
            background: %s;
        }
        a {
            color: %s;
        }
        a:hover {
            color: %s;
            opacity: .8;
        }
    ', 
        esc_url($login_logo), 
        esc_attr($theme_mods['login_background_color']),
        esc_attr($font_login),
        esc_attr($theme_mods['login_color']),
        esc_attr($theme_mods['login_color']),
        esc_attr($theme_mods['login_hover_color']),
        esc_attr($theme_mods['login_hover_color']),
        esc_attr($theme_mods['login_form_text_color']),
        esc_attr($theme_mods['login_form_color']),
        esc_attr($theme_mods['login_link_color']),
        esc_attr($theme_mods['login_link_hover_color'])
    );
    
    if (!empty($css)) {
        wp_add_inline_style($handle, $css);
    }
}


add_action('admin_enqueue_scripts', 'bt_css_inline_admin_styles', 1009);
/**
 * Inline Style for admin CSS (common + top bar)
 *
 * @since 1.7.1
 */
function bt_css_inline_admin_styles() {
    $admin_font = get_theme_mod('bt_admin_font');
    
    if ($admin_font == 1) {
        $handle = 'admin-bar';
        $font_family = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
        
        $css = sprintf(' 
            body, #wpadminbar * {
                font-family: %s !important;
            }
        ', esc_attr($font_family));
        
        wp_add_inline_style($handle, $css);
    }
}

add_action('customize_controls_enqueue_scripts', 'bt_customize_color_palette');
function bt_customize_color_palette() {
    wp_enqueue_script(
        'bt-customizer-palette',
        get_stylesheet_directory_uri() . '/js/customizer-palette.js', 
        ['jquery', 'wp-color-picker', 'customize-controls'], // wp-color-picker must be enqueued
        false,
        true
    );
}