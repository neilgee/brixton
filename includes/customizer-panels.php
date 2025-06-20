<?php
/**
 * Adding all Customizer Stuff Here.
 * @since 1.0.0
 * @package Brixston
 */


add_action( 'customize_register', 'bt_register_theme_customizer', 20 );
/**
 * Register for the Customizer
 * @since 1.0.0
 */
function bt_register_theme_customizer( $wp_customize ) {

	// Add Login Styles
	$wp_customize->add_section( 'bt_login_styles' , array(
		'title'      => __( 'Login Styles','brixston' ),
		'priority'   => 120,
		) 
	);

	 // Define color settings
    $color_settings = array(
        'bt_login_accent_color'        => array( 'label' => __( 'Login accent color', 'brixston' ), 'default' => '#007cba' ),
        'bt_login_accent_hover_color'  => array( 'label' => __( 'Login accent hover color', 'brixston' ), 'default' => '#0071a1' ),
        'bt_login_link_color'          => array( 'label' => __( 'Login link color', 'brixston' ), 'default' => '#555d66' ),
        'bt_login_link_hover_color'    => array( 'label' => __( 'Login link hover color', 'brixston' ), 'default' => '#00a0d2' ),
        'bt_login_background_color'    => array( 'label' => __( 'Login background color', 'brixston' ), 'default' => '#f1f1f1' ),
        'bt_login_form_color'          => array( 'label' => __( 'Login form background color', 'brixston' ), 'default' => '#ffffff' ),
        'bt_login_form_text'           => array( 'label' => __( 'Login form text color', 'brixston' ), 'default' => '#444444' ),
    );

    // Loop through and add settings & controls


    $bt_palette = bt_get_brand_palette(); // Fetch from your global helper of Bricks color palette in functions.php


    foreach ( $color_settings as $setting_id => $setting ) {
        $wp_customize->add_setting( $setting_id, array( 'default' => $setting['default'] ) );

        $wp_customize->add_control( new WP_Customize_Color_Control(
            $wp_customize,
            $setting_id,
            array(
                'label'    => $setting['label'],
                'section'  => 'bt_login_styles',
                'settings' => $setting_id,
                'choices'  => array(
                    'palettes' => $bt_palette,
                ),
            )
        ));
        
    }

    // Get default WP custom logo
    $custom_logo = get_theme_mod( 'custom_logo' );
    $custom_logo_url = $custom_logo ? wp_get_attachment_url( $custom_logo ) : '';

    // Logo Setting & Control
    $wp_customize->add_setting( 'bt_login_logo', array( 'default' => $custom_logo_url ) );

    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'bt_login_logo',
        array(
            'label'    => __( 'Add alternative login logo here', 'brixston' ),
            'section'  => 'bt_login_styles',
            'settings' => 'bt_login_logo',
        )
    ));

    // Checkbox Setting: Make WP Dashboard font same as frontend
    $wp_customize->add_setting( 'bt_admin_font', array( 'default' => 0 ) );

    $wp_customize->add_control( 'bt_admin_font', array(
        'label'    => __( 'Make WP Dashboard font same as frontend', 'brixston' ),
        'section'  => 'bt_login_styles',
        'type'     => 'checkbox',
        'priority' => 10,
    ));
}
