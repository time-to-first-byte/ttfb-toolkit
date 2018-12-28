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
 * Performance Panel Customizer Styles
 */
add_action( 'customize_controls_print_styles', 'ttfb_toolkit_performance_panel_styles', 999 );
function ttfb_toolkit_performance_panel_styles() { ?>
	<style>
        li#accordion-panel-ttfb_toolkit_performance > h3.accordion-section-title:before {
            content: "\f226";
            font-family: dashicons;
            padding: 0 3px 0 0;
            vertical-align: middle;
            font-size: 22px;
            line-height: 1;
        }
	</style>
	<?php
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

/**
 * Files Optimisations
 */
require_if_theme_supports("ttfb_toolkit_optimizations", TTFB_TOOLKIT_INCLUDES . 'performance/optimizations.php');










