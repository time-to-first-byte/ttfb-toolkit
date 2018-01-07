<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create customizer Performance Debug panel and controls
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_performance_debug");
function ttfb_toolkit_customizer_performance_debug( $wp_customize ) {
    /*
    * Debug Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_performance_debug', array(
        'title'      => esc_attr__( 'Debug', 'ttfb-toolkit' ),
        'priority'   => 100,
        'panel'		 => 'ttfb_toolkit_performance',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls Performance Debug
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_debug', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_debug', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_debug',
        'label' => __( 'Activate Performance Timing API', 'ttfb-toolkit' ),
        'description' => __( 'Navigation Timing API measurement in DevTools. It helps debug performance issues. Activate in a development environment only.' , 'ttfb-toolkit' ),
    ) );
}

/**
 * Enqueue scripts 
 */
add_action( 'wp_enqueue_scripts', 'ttfb_toolkit_perf_debug_enqueue_script' );
function ttfb_toolkit_perf_debug_enqueue_script() {
    if( get_option('ttfb_toolkit_perf_debug', false) ){
        wp_enqueue_script( 'ttfb-toolkit-timing', TTFB_TOOLKIT_URI . 'assets/js/timing.min.js', '', '1.0', false );
        wp_add_inline_script( 'ttfb-toolkit-timing', '
            window.onload = function () {
                window.setTimeout(function () {

                    var networklatency = timing.getTimes().responseEnd - timing.getTimes().fetchStart;
                    var loadtimeOnload = timing.getTimes().loadEventEnd - timing.getTimes().responseEnd;
                    var Fullyloadedtime = timing.getTimes().loadEventEnd - timing.getTimes().navigationStart;
                    //var ttfb = timing.getTimes().responseEnd - timing.getTimes().requestStart;
                    
                    // First Paint
                    //console.log( "First Paint: " + timing.getTimes().firstPaint );

                    // First Contentful Paint 
                    //console.log( "First Contentful Paint : "   );

                    // Load Time
                    console.log( "Fully loaded time : " + Fullyloadedtime + "ms" );
                    console.log( "Load Time (onload): " + loadtimeOnload + "ms" );

                    // Network Latency
                    //console.log( "Network Latency: " + networklatency );


                    
                    //console.table( timing.getTimes() );
                    //timing.printSimpleTable();

                    
                }, 0);
            }
        ' );


        wp_enqueue_script( 'ttfb-toolkit-speedindex', TTFB_TOOLKIT_URI . 'assets/js/speedindex.min.js', '', '1.0', false );
        wp_add_inline_script( 'ttfb-toolkit-speedindex', '
            // Speed Index
            var speedIndexResult = RUMSpeedIndex();
            console.log( "Speed Index (lower is better): " + Math.round(speedIndexResult) );
    ' );
    }
}