<?php
/**
 * TTFB Toolkit before page content hook
 */
add_action( 'minimall_before_page_content', 'ttfb_toolkit_before_page_content_hook', 10 );
function ttfb_toolkit_before_page_content_hook() { 
    do_action('ttfb_toolkit_before_page_content');
}

/**
 * TTFB Toolkit before post content hook
 */
add_action( 'minimall_before_post_content', 'ttfb_toolkit_before_post_content_hook', 10 );
function ttfb_toolkit_before_post_content_hook() { 
    do_action('ttfb_toolkit_before_post_content');
}

/**
 * TTFB Toolkit after page content hook
 */
add_action( 'minimall_after_page_content', 'ttfb_toolkit_after_page_content_hook', 10 );
function ttfb_toolkit_after_page_content_hook() { 
    do_action('ttfb_toolkit_after_page_content');
}

/**
 * TTFB Toolkit after post content hook
 */
add_action( 'minimall_after_post_content', 'ttfb_toolkit_after_post_content_hook', 10 );
function ttfb_toolkit_after_post_content_hook() { 
    do_action('ttfb_toolkit_after_post_content');
}

/**
 * Adds async/defer attributes to enqueued / registered scripts.
 *
 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return array
 */
function ttfb_toolkit_filter_script_loader_tag( $tag, $handle ) {

	foreach ( array( 'async', 'defer' ) as $attr ) {
		if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
			continue;
		}

		// Prevent adding attribute when already added in #12009.
		if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
			$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
		}

		// Only allow async or defer, not both.
		break;
	}

	return $tag;
}

add_filter( 'script_loader_tag', 'ttfb_toolkit_filter_script_loader_tag', 10, 2 );

/*
* AMP Detection
*/
add_action( 'wp', 'ttfb_toolkit_lazyload_disable_on_amp' );
function ttfb_toolkit_lazyload_disable_on_amp() {
	if ( defined( 'AMP_QUERY_VAR' ) && function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
		add_filter( 'do_ttfb_toolkit_lazyload', '__return_false' );
	}
}

/*
* Rest API Detection
*/
function ttfb_toolkit_is_rest() {
    return ( defined( 'REST_REQUEST' ) && REST_REQUEST );
}

/*
* Detect on page lazyload disabled for image
*/
add_action('wp', 'ttfb_toolkit_on_page_lazyload_image_disabled');
function ttfb_toolkit_on_page_lazyload_image_disabled(){
    if( !is_page() && !is_single() ){ return; }

    global $post;
    if( is_object( $post ) && get_post_meta($post->ID, 'ttfb_toolkit_options_disable_image_lazy_load', true) ){
        add_filter( 'do_ttfb_toolkit_lazyload_image', '__return_false' ); 
    }
}

/*
* Detect on page lazyload disabled for iframe
*/
add_action('wp', 'ttfb_toolkit_on_page_lazyload_iframe_disabled');
function ttfb_toolkit_on_page_lazyload_iframe_disabled(){
    if( !is_page() && !is_single() ){ return; }

    global $post;
    if( is_object( $post ) && get_post_meta($post->ID, 'ttfb_toolkit_options_disable_iframe_lazy_load', true) ){
        add_filter( 'do_ttfb_toolkit_lazyload_iframe', '__return_false' ); 
    }
}

/**
* Gets scripts registered and enqueued.
*
* @return array(_WP_Dependency) A list of enqueued dependencies
*/
function ttfb_get_enqueued_scripts() {
    global $wp_scripts;
    $enqueued_scripts = array();
    foreach ( $wp_scripts->queue as $handle ) {
        $enqueued_scripts[] = $wp_scripts->registered[ $handle ];
    }
    return $enqueued_scripts;
}

/**
* Gets a script dependency for a handle
*
* @param string $handle The handle
* @return _WP_Dependency associated with input handle
*/
function ttfb_get_dep_for_handle( $handle ) {
    global $wp_scripts;
    return $wp_scripts->registered[ $handle ];
}

/**
* Gets the source URL given a script handle.
*
* @param string $handle The handle
* @return URL associated with handle, or empty string
*/
function ttfb_get_src_for_handle( $handle ) {
    $dep = ttfb_get_dep_for_handle( $handle );
    $suffix = ( $dep->src && $dep->ver )
        ? "?ver={$dep->ver}"
        : '';
    return "{$dep->src}{$suffix}";
}

/**
* Gets all dependencies for a given handle.
*
* @param string $handle The handle
*/
function ttfb_get_deps_for_handle( $handle ) {
    $dep = ttfb_get_dep_for_handle( $handle );
    return $dep->deps;
}