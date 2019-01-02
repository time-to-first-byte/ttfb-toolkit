<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create customizer Optimization panels and controls
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_performance_optimizations");
function ttfb_toolkit_customizer_performance_optimizations( $wp_customize ) {

    /*
    * JS Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_performance_js', array(
        'title'      => esc_attr__( 'JavaScript Optimization', 'ttfb-toolkit' ),
        'priority'   => 10,
        'panel'		 => 'ttfb_toolkit_performance',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls for js optimizations
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_js', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_js', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_js',
        'label' => __( 'Activate JavaScript Optimization', 'ttfb-toolkit' ),
        'description' => __( 'By enabling this option, you will improve the loading time of your website by adding a "defer" attribute to JS files without depedency.', 'ttfb-toolkit' ),
    ) );

    /*
    * CSS Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_performance_css', array(
        'title'      => esc_attr__( 'CSS Optimization', 'ttfb-toolkit' ),
        'priority'   => 20,
        'panel'		 => 'ttfb_toolkit_performance',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls for css optimizations
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_css', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_css', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_css',
        'label' => __( 'Activate CSS Optimization', 'ttfb-toolkit' ),
        'description' => __( 'By enabling this option, you will improve the loading time of your website by loading stylesheets asynchronously. ', 'ttfb-toolkit' ),
    ) );




    
    // Critical CSS Controls
    $wp_customize->add_setting( 'ttfb_toolkit_perf_css_critical', array(
        'default' => 'none',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_perf_css_critical', array(
        'type' => 'select',
        'priority' => 20,
        'section' => 'ttfb_toolkit_performance_css',
        'label' => __( 'Critical CSS', 'ttfb' ),
        'description' => __('Default to http/2 server push. <a href="https://www.smashingmagazine.com/2017/04/guide-http2-server-push/" target="_blank">Read more about server push</a>.'),
        'choices'  => array(
            'push-stylesheet'  => 'HTTP/2 Server Push - the the theme stylesheet',
            'push-critical'  => 'HTTP/2 Server Push - critical css',
            'inline' => 'Inline Critical CSS',
            'none' => 'None'
        ),
        //'active_callback' => 'ttfb_toolkit_active_css_optimizations',
    ) );

}

function ttfb_toolkit_active_css_optimizations( $control ) {
    if ( $control->manager->get_setting('ttfb_toolkit_perf_css')->value() == '1' ) {
        return true;
    } else {
        return false;
    }
}



/*
* Defer scripts when it's possible
*/
add_action( 'wp_enqueue_scripts', 'ttfb_toolkit_defer_scripts' );
function ttfb_toolkit_defer_scripts() {
    // If this is the admin page, do nothing.
    if ( is_admin() ) {
        return;
    }

    // If the JavaScript Optimization option is not activated, do nothing
	if ( ! get_option("ttfb_toolkit_perf_js", false) ) {
		return;
    }
    
    // if this is a rest output, do nothing.
    if ( ttfb_toolkit_is_rest() ) {
        return;
    }

    // Don't lazyload for feeds, previews.
	if ( is_feed() || is_preview() ) {
		return;
    }
    
    $enqueued_scripts = ttfb_get_enqueued_scripts();
    $to_defer = array();

    if( !empty( $enqueued_scripts ) ){
        foreach ($enqueued_scripts as $key => $script) {
            
            // If no dependencies
            if( empty( $script->deps ) ){
                wp_script_add_data( $script->handle, 'defer', true );
            }
        }
    }
    
}

/*
* Defer stylsheets with loadcss.js
*/
add_action('wp_print_styles', function() {
    if ( ! doing_action( 'wp_head' ) ) { // ensure we are on head
      return;
    }

    // If the CSS Optimization option is not activated, do nothing
	if ( ! get_option("ttfb_toolkit_perf_css", false) ) {
		return;
    }
    
    // if this is a rest output, do nothing.
    if ( ttfb_toolkit_is_rest() ) {
        return;
    }

    // Don't lazyload for feeds, previews.
	if ( is_feed() || is_preview() ) {
		return;
    }

    // Variables
    global $wp_scripts, $wp_styles;
    $exluded_styles = array("admin-bar", "critical");
    $queued_styles  = $wp_styles->queue;

    // If server push activated, exclude the main stylesheet
    if( get_option("ttfb_toolkit_perf_css_critical", false) === "push-stylesheet" ){
        $exluded_styles[] = MAIN_STYLESHEET;
    }
    
    foreach ($wp_styles->queue as $key => $element) {
        if ( !in_array( $element, $exluded_styles ) ) {
            unset( $wp_styles->queue[$key] );
        }
    }
    
    add_action( 'wp_head', function() use( $queued_styles, $exluded_styles ) {
      
        global $wp_styles;

        if( !empty( $queued_styles ) ){
        
            foreach( $queued_styles as $key => $stylesheet ):
               
                if ( 
                    !in_array( $stylesheet, $exluded_styles ) &&
                    !empty( $wp_styles->registered[$stylesheet] )
                ): ?> 
                    <link rel="preload" href="<?php echo esc_url( $wp_styles->registered[$stylesheet]->src ); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
                    <noscript><link rel="stylesheet" href="<?php echo esc_url( $wp_styles->registered[$stylesheet]->src ); ?>"></noscript>
                <?php endif; ?> 
            <?php endforeach; ?>
            <script>
                /*! loadCSS. [c]2017 Filament Group, Inc. MIT License */
                !function(t){"use strict";t.loadCSS||(t.loadCSS=function(){});var e=loadCSS.relpreload={};if(e.support=function(){var e;try{e=t.document.createElement("link").relList.supports("preload")}catch(t){e=!1}return function(){return e}}(),e.bindMediaToggle=function(t){var e=t.media||"all";function a(){t.addEventListener?t.removeEventListener("load",a):t.attachEvent&&t.detachEvent("onload",a),t.setAttribute("onload",null),t.media=e}t.addEventListener?t.addEventListener("load",a):t.attachEvent&&t.attachEvent("onload",a),setTimeout(function(){t.rel="stylesheet",t.media="only x"}),setTimeout(a,3e3)},e.poly=function(){if(!e.support())for(var a=t.document.getElementsByTagName("link"),n=0;n<a.length;n++){var o=a[n];"preload"!==o.rel||"style"!==o.getAttribute("as")||o.getAttribute("data-loadcss")||(o.setAttribute("data-loadcss",!0),e.bindMediaToggle(o))}},!e.support()){e.poly();var a=t.setInterval(e.poly,500);t.addEventListener?t.addEventListener("load",function(){e.poly(),t.clearInterval(a)}):t.attachEvent&&t.attachEvent("onload",function(){e.poly(),t.clearInterval(a)})}"undefined"!=typeof exports?exports.loadCSS=loadCSS:t.loadCSS=loadCSS}("undefined"!=typeof global?global:this);
            </script>
            <script></script><!-- Fix IE and Edge bug with loadcss -->
        <?php
        }

    }, 10 );

  }, 0);