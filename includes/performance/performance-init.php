<?php
/**
 * Create customizer Performance panel
 */
/**
 * Create customizer Performance Panel
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_performance");
function ttfb_toolkit_customizer_performance( $wp_customize ) {
    $wp_customize->add_panel( 'ttfb_toolkit_performance', array(
        'title'      => esc_attr__( 'Performance', 'ttfb-toolkit' ),
        'priority'   => 300,
        'panel'		 => 'ttfb_toolkit',
        'capability' => 'edit_theme_options',
    ) );
}

/**
 * Lazy Load for image and iframe
 */
require 'lazyload.php';

/**
 * WordPress cleanup
 */
require 'clean.php';

/**
 * Preload / Push module
 */
require 'preload.php';

/**
 * Options Metabox
 */
require 'metabox-options.php';










