<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create customizer preload panel and controls
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_performance_preload");
function ttfb_toolkit_customizer_performance_preload( $wp_customize ) {
    /*
    * Lazy Load Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_performance_preload', array(
        'title'      => esc_attr__( 'Preload', 'ttfb-toolkit' ),
        'priority'   => 50,
        'panel'		 => 'ttfb_toolkit_performance',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls lazy load images
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_preload', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_preload', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_preload',
        'label' => __( 'Activate Link Preload', 'ttfb-toolkit' ),
        'description' => __( 'By enabling this option, you will improve the load time on modern browsers.', 'ttfb-toolkit' ),
    ) );
}

/**
 * Add preload section
 * 
 */

/*
* Preload
*/
add_action('minimall_head_open','ttfb_toolkit_do_preload',5);
function ttfb_toolkit_do_preload(){
    if( get_option('ttfb_toolkit_perf_preload',false) ){
        do_action('ttfb_toolkit_preload');
    }
}

/*
* Preload jQuery if detected
*/
//add_action('ttfb_toolkit_preload','minimall_add_jquery_preload',10);
function ttfb_toolkit_add_jquery_preload(){
    if( get_option('ttfb_toolkit_perf_preload',false) &&
    wp_script_is( 'jquery', 'enqueued' ) ){
        //echo '<link rel="preload" as="script" href="' . esc_url( $images['lg'] ) . '">' . PHP_EOL;
    }
}