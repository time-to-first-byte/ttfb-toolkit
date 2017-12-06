<?php
/**
 * TTFB Toolkit
 *
 * @package   TTFB Toolkit
 * @author    Eric Valois
 * @license   GPL-2.0+
 * @link      https://github.com/time-to-first-byte/ttfb-toolkit
 * @copyright 2017 TTFB
 *
 * @wordpress-plugin
 * Plugin Name:       TTFB Toolkit
 * Plugin URI:        https://github.com/time-to-first-byte/ttfb-toolkit
 * Description:       The TTFB Toolkit extends functionality to TTFB Themes, providing Font Awesome icons, alerts and more.
 * Version:           0.1
 * Author:            TTFB
 * Author URI:        eric@ttfb.io
 * License:           GPLv2+
 * Text Domain:       ttfb-toolkit
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/time-to-first-byte/ttfb-toolkit
 */

/*
* Simple Detection function
*/
function ttfb_toolkit_init(){
    return true;
}

/**
 * Create customizer TTFB Toolkit panel
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( "customize_register", "ttfb_toolkit_customizer_default_panel");
function ttfb_toolkit_customizer_default_panel( $wp_customize ) {

    /*
    * TTFB Toolkit Panel
    */
    $wp_customize->add_panel( 'ttfb_toolkit', array(
        'priority' => 400,
        'capability' => 'edit_theme_options',
        'title'      => esc_attr__( 'TTFB Toolkit', 'ttfb-toolkit' ),
        'description' => '',
    ) );
}

/**
 * TTFB Toolkit Customizer Styles
 */
add_action( 'customize_controls_print_styles', 'ttfb_toolkit_customizer_styles', 999 );
function ttfb_toolkit_customizer_styles() { ?>
	<style>
        li#accordion-panel-ttfb_toolkit > h3.accordion-section-title:before {
            content: "\f180";
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
 * Alerts
 */
require 'alerts.php';

/**
 * Font Awesome
 */
require 'font-awesome.php';

