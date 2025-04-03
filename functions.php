<?php 
/**
 * Register/enqueue custom scripts and styles
 */
add_action( 'wp_enqueue_scripts', function() {
	// Enqueue your files on the canvas & frontend, not the builder panel. Otherwise custom CSS might affect builder)
	if ( ! bricks_is_builder_main() ) {
		wp_enqueue_style( 'bricks-child', get_stylesheet_uri(), ['bricks-frontend'], filemtime( get_stylesheet_directory() . '/style.css' ) );
	}
} );

/**
 * Register custom elements
 */
add_action( 'init', function() {
  $element_files = [
    __DIR__ . '/elements/title.php',
  ];

  foreach ( $element_files as $file ) {
    \Bricks\Elements::register_element( $file );
  }
}, 11 );

/**
 * Add text strings to builder
 */
add_filter( 'bricks/builder/i18n', function( $i18n ) {
  // For element category 'custom'
  $i18n['custom'] = esc_html__( 'Custom', 'bricks' );

  return $i18n;
} );

// Client File - for WP Login and backend dashboard admin clean up.
  include_once( get_stylesheet_directory() . '/includes/dashboard.php' );

// Add Customizer Options and CSS output.
	require_once( get_stylesheet_directory() . '/includes/customizer-panels.php' );
	require_once( get_stylesheet_directory() . '/includes/inline-css-style-login.php' );
// Gravity Forms
	if ( class_exists( 'GFCommon' ) ) {
		include_once( get_stylesheet_directory() . '/includes/gravity.php' );
	}
// ACF
	if ( class_exists( 'acf' ) ) {
		include_once( get_stylesheet_directory() . '/includes/acf.php' );
	}
// Set Up Global JS
//wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', true );
