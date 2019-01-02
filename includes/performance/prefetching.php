<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create customizer Prefetching panel and controls
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_prefetch");
function ttfb_toolkit_customizer_prefetch( $wp_customize ) {
    /*
    * prefetch Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_performance_prefetch', array(
        'title'      => esc_attr__( 'Prefetching', 'ttfb-toolkit' ),
        'priority'   => 110,
        'panel'		 => 'ttfb_toolkit_performance',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls prefetch 
    */
    $wp_customize->add_setting( 'ttfb_toolkit_prefetch', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_prefetch', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_prefetch',
        'label' => __( 'Activate Quicklink module', 'ttfb-toolkit' ),
        'description' => __( 'Faster subsequent page-loads by prefetching in-viewport links during idle time. <a href="https://github.com/GoogleChromeLabs/quicklink" target="_blank">Read more about quicklink.js</a>' , 'ttfb-toolkit' ),
    ) );
}

/**
 * Enqueue scripts 
 */
add_action( 'wp_enqueue_scripts', 'ttfb_toolkit_prefetch_enqueue_script' );
function ttfb_toolkit_prefetch_enqueue_script() {
    if( get_option('ttfb_toolkit_prefetch', false) ){
        // add quicklink script
        wp_enqueue_script( 'quicklink', TTFB_TOOLKIT_URI . 'vendor/quicklink/quicklink.js', '', '1.0', true );
        
        // initi quicklink
        $main_domaine = wp_parse_url( get_bloginfo("wpurl") );
        wp_add_inline_script( 'quicklink', 'window.addEventListener("load", () =>{ 
            quicklink( { 
                origins: ["'. $main_domaine['host'] .'"],
                ignores: [
                    uri => uri.includes("#"),
                    /\/wp-login\/?/,
                    /\/wp-admin\/?/,
                    (uri, elem) => elem.hasAttribute("noprefetch"),
                    (uri, elem) => elem.classList.contains("noprefetch"),
                ]
            }); 
        });' );

    }
}