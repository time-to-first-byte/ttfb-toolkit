<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create customizer clean up panel and controls
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_performance_clean");
function ttfb_toolkit_customizer_performance_clean( $wp_customize ) {
    /*
    * Lazy Load Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_performance_clean', array(
        'title'      => esc_attr__( 'Clean Up', 'ttfb-toolkit' ),
        'priority'   => 10,
        'panel'		 => 'ttfb_toolkit_performance',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls Clean Up Emojijs
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_disable_emojijs', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_disable_emojijs', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_clean',
        'label' => __( 'Disable Emojis', 'ttfb-toolkit' ),
        'description' => __( 'Removes the extra code bloat used to add support for emoji’s', 'ttfb-toolkit' ),
    ) );
    
    /*
    * Controls Clean Up Embeds
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_disable_embed', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_disable_embed', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_clean',
        'label' => __( 'Disable Embeds', 'ttfb-toolkit' ),
        'description' => __( 'Remove the wp-embed script added by WordPress.', 'ttfb-toolkit' ),
    ) );
    
    /*
    * Controls Clean Up Query String
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_disable_query_string', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_disable_query_string', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_performance_clean',
        'label' => __( 'Remove Query Stringss', 'ttfb-toolkit' ),
        'description' => __( 'Remove query strings from static resources like CSS & JS files to improve your scores in Pingdom, GTmetrix, PageSpeed and YSlow.', 'ttfb-toolkit' ),
    ) );

    /*
    * Controls Clean Up jQUery Migrate
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_disable_jquery_migrate', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_disable_jquery_migrate', array(
        'type' => 'checkbox',
        'priority' => 30,
        'section' => 'ttfb_toolkit_performance_clean',
        'label' => __( 'Remove jQuery Migrate', 'ttfb-toolkit' ),
        'description' => __( 'Most WordPress sites that use up-to-date themes and plugins don’t require jQuery Migrate in the front end.', 'ttfb-toolkit' ),
    ) );

   


}

/*
* Detect on page clean up disabled
*/
add_action('wp', 'ttfb_toolkit_on_page_cleanup_off');
function ttfb_toolkit_on_page_cleanup_off(){
    if( !is_page() && !is_single() ){ return; }

    global $post;
    if( is_object( $post ) && get_post_meta($post->ID, 'ttfb_toolkit_options_disable_clean_up', true) ){
        add_filter( 'do_ttfb_toolkit_cleanup', '__return_false' ); 
    }
}

/*
* Remove everything emoji related
*/
add_action( 'wp', 'ttfb_toolkit_disable_emojis' );
function ttfb_toolkit_disable_emojis() {
    
    if( ! apply_filters( 'do_ttfb_toolkit_cleanup', true ) ||
        ! get_option('ttfb_toolkit_perf_disable_emojijs', false) ||
        is_admin() ){
        return;
    }

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );	
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'ttfb_toolkit_disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'ttfb_toolkit_disable_emojis_remove_dns_prefetch', 10, 2 );
    
}

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function ttfb_toolkit_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param  array  $urls          URLs to print for resource hints.
 * @param  string $relation_type The relation type the URLs are printed for.
 * @return array                 Difference betwen the two arrays.
 */
function ttfb_toolkit_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2.2.1/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}

/**
 * Remove query string
 */
add_filter( 'style_loader_src', 'ttfb_toolkit_remove_wp_ver_css_js', 15, 1 ); 
add_filter( 'script_loader_src', 'ttfb_toolkit_remove_wp_ver_css_js', 15, 1 );
function ttfb_toolkit_remove_wp_ver_css_js( $src ) {

    if( ! apply_filters( 'do_ttfb_toolkit_cleanup', true ) ||
        ! get_option('ttfb_toolkit_perf_disable_query_string', false) ||
        is_admin() ){
        
        return $src;
    }else{
        $rqs = explode( '?ver', $src );
        return $rqs[0];
    }
}

/**
 * Remove wp-embed
 */
add_action( 'wp_footer', 'ttfb_toolkit_deregister_embeds' );
function ttfb_toolkit_deregister_embeds(){
    
    if( ! apply_filters( 'do_ttfb_toolkit_cleanup', true ) ||
        ! get_option('ttfb_toolkit_perf_disable_embed', false) ||
        is_admin() ){
        return;
    }
    
    wp_dequeue_script( 'wp-embed' );
    
}

/**
 * Remove jQuery Migrate
 */
add_action('wp_default_scripts', function( $scripts ) {
    
    add_action( 'wp', function() use( $scripts ) {
        if( ! apply_filters( 'do_ttfb_toolkit_cleanup', true ) ||
            ! get_option('ttfb_toolkit_perf_disable_jquery_migrate', false) ||
            is_admin() ){
            return;
        }
        
        $script = $scripts->registered['jquery'];
        
        if ( $script->deps ) { // Check whether the script has any dependencies
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
        
    }, 10 );

  }, 0);
