<?php 
/**
 * Register/enqueue custom scripts and styles
 */
add_action( 'wp_enqueue_scripts', function() {
	// Enqueue your files on the canvas & frontend, not the builder panel. Otherwise custom CSS might affect builder)
	if ( ! bricks_is_builder_main() ) {
		wp_enqueue_style( 'bricks-child', get_stylesheet_uri(), ['bricks-frontend'], filemtime( get_stylesheet_directory() . '/style.css' ) );
    // Set Up Global JS
    //wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', true );
	}

});

add_filter( 'bricks/builder/color_palette', function( $colors ) {

// Override entire default color palette
  $colors = [
    ['hex' => '#ffffff'],
    ['hex' => '#000000'],
    ['hex' => '#999999'],
    ['hex' => '#22566b'],
    ['hex' => '#9ec7d7'],
    ['hex' => '#3c7085'],
    ['hex' => '#ff8700'],
    ['hex' => '#e3536c'],
    ['hex' => '#6FA3B8'],
    ['hex' => '#FFD230'],
  ];

  return $colors;
} );

add_action( 'after_setup_theme', 'bt_theme_setup', 15 );
/**
 * Bricks theme set up
 *
 * @since 1.0.0
 */
function bt_theme_setup() {

	/**
	 * Clean up WP Head
	 * @since 1.0.0
	 */
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
  remove_action( 'wp_head', 'rest_output_link_wp_head', 10 ); // Remove REST API link
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' ); // Remove oEmbed discovery links
  remove_action( 'wp_head', 'wp_locale' ); // Remove locale meta tag


    // Gravity Forms
	if ( class_exists( 'GFCommon' ) ) {
		include_once( get_stylesheet_directory() . '/includes/gravity.php' );
	}

  // ACF
	if ( class_exists( 'acf' ) ) {
		include_once( get_stylesheet_directory() . '/includes/acf.php' );
	}

// Client File - for WP Login and backend dashboard admin clean up.
  include_once( get_stylesheet_directory() . '/includes/dashboard.php' );

// Add Customizer Options and CSS output.
	require_once( get_stylesheet_directory() . '/includes/customizer-panels.php' );
	require_once( get_stylesheet_directory() . '/includes/inline-css-style-login.php' );


	add_filter( 'intermediate_image_sizes_advanced', 'bt_remove_default_images' );
	/**
	 * Remove default image sizes
	 * @since 1.0.0
	 */
	function bt_remove_default_images( $sizes ) {
		// unset( $sizes['small']); // 150px
		// unset( $sizes['medium']); // 300px
		// unset( $sizes['large']); // 1024px
		unset( $sizes['medium_large']); // 768px
		return $sizes;
	}

/**
 * Custom Image Sizes
 * Image sizes - add in required image sizes here. Not working for theme if inside after_setup_theme function
 * @since 1.0.0
 */
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'blog-feature', 800, 533, true );
	add_image_size( 'medium', 300, 300, true ); // Overwrite default and hard cropping
}
	
	
	add_action( 'add_attachment', 'bt_image_meta_upon_image_upload' );
  /**
   * Automatically set the image Title, Alt-Text, Caption & Description upon upload
   * @since 1.0.0
   */
  function bt_image_meta_upon_image_upload( $post_ID ) {
      // Check if uploaded file is an image
      if ( ! wp_attachment_is_image( $post_ID ) ) {
          return;
      }

      $post = get_post( $post_ID );

      // Ensure the post exists
      if ( ! $post || empty( $post->post_title ) ) {
          return;
      }

      // Sanitize and format the title
      $image_title = sanitize_title( trim( $post->post_title ) );
      $image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ', $image_title );
      $image_title = ucwords( strtolower( $image_title ) );

      // Update Alt text
      update_post_meta( $post_ID, '_wp_attachment_image_alt', $image_title );

      // Update image post meta
      wp_update_post([
          'ID'         => $post_ID,
          'post_title' => $image_title,
      ]);
  }


}  // Closing After Set Up Hook

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