<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create customizer ScrollTop panel and controls
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_scroll");
function ttfb_toolkit_customizer_scroll( $wp_customize ) {
    /*
    * Debug Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_scrolltop', array(
        'title'      => esc_attr__( 'ScrollTop', 'ttfb-toolkit' ),
        'priority'   => 100,
        'panel'		 => 'ttfb_toolkit_panel',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls Performance Debug
    */
    $wp_customize->add_setting( 'ttfb_toolkit_scrolltop', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_scrolltop', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_scrolltop',
        'label' => __( 'Activate ScrollTop plugin', 'ttfb-toolkit' ),
        'description' => __( 'Enable a performance-oriented back-to-top button.' , 'ttfb-toolkit' ),
    ) );
}

/**
 * Enqueue scripts 
 */
add_action( 'wp_enqueue_scripts', 'ttfb_toolkit_scrolltop_enqueue_script' );
function ttfb_toolkit_scrolltop_enqueue_script() {
    if( get_option('ttfb_toolkit_scrolltop', false) ){
        // Script
        wp_enqueue_script( 'ttfb-toolkit-scrollto-script', TTFB_TOOLKIT_URI . 'includes/scrolltop/scrolltop.min.js', '', '1.0', true );

        // Stylesheeet
        wp_enqueue_style( 'ttfb-toolkit-scrollto-style', TTFB_TOOLKIT_URI . 'includes/scrolltop/scrolltop.min.css' );
    }
}

/**
 * Inject Scroll to top button
 */
add_action( 'wp_footer', 'ttfb_toolkit_scrolltop_markup' );
function ttfb_toolkit_scrolltop_markup() {
    if( get_option('ttfb_toolkit_scrolltop', false) ){
        echo '<a id="scrolltop" href="#"><svg viewBox="0 0 256 256" version="1.1" fill="currentColor"><path fill="currentColor" d="M88.4020203,153.455844 L128,113.857864 L167.59798,153.455844 L173.254834,147.79899 L128,102.544156 L125.171573,105.372583 L82.745166,147.79899 L88.4020203,153.455844 Z"></path></svg></a>';
        
    }
}