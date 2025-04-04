<?php


add_action( 'after_setup_theme', 'brixton_theme_setup', 15 ); 

function brixton_theme_setup() {

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

}