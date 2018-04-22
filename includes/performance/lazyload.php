<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create customizer Lazy load panel and controls
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_performance_lazyload");
function ttfb_toolkit_customizer_performance_lazyload( $wp_customize ) {
    /*
    * Lazy Load Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_performance_lazy_load', array(
        'title'      => esc_attr__( 'Lazy Load', 'ttfb-toolkit' ),
        'priority'   => 10,
        'panel'		 => 'ttfb_toolkit_performance',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Controls lazy load images
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_lazyload_img', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_lazyload_img', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_performance_lazy_load',
        'label' => __( 'Activate Image Lazy Load', 'ttfb-toolkit' ),
        'description' => __( 'By enabling this option, you will improve the loading time of your website.', 'ttfb-toolkit' ),
    ) );

    /*
    * Controls lazy load iframe
    */
    $wp_customize->add_setting( 'ttfb_toolkit_perf_lazyload_iframe', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_perf_lazyload_iframe', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_performance_lazy_load',
        'label' => __( 'Activate Iframe Lazy Load', 'ttfb-toolkit' ),
        'description' => __( 'By enabling this option, you will improve the loading time of your website.', 'ttfb-toolkit' ),
    ) );
}

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
 * Lazy load module
 *
 * @package perfthemes
 * @since 1.0
 */
add_filter( 'get_avatar'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
add_filter( 'the_content'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
add_filter( 'widget_text'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
add_filter( 'get_image_tag'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
add_filter( 'post_thumbnail_html'	, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
function ttfb_toolkit_lazy_load_image( $content ){

    if ( ! get_option('ttfb_toolkit_perf_lazyload_img', false) || 
            ! apply_filters( 'do_ttfb_toolkit_lazyload_image', true ) ||
            is_admin() ||
            ttfb_toolkit_is_rest() ) {
        return $content;
    }
    
	global $post;

    
    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $document = new DOMDocument();

    libxml_use_internal_errors(true);
    if( !empty($content) ){
        $document->loadHTML(utf8_decode($content));
    }else{
        return;
    }


    $imgs = $document->getElementsByTagName('img');
    foreach ($imgs as $img) {

        if( !$img->hasAttribute('data-src') ){
            // add data-sizes
            $img->setAttribute('data-size', "auto");
        
            // remove sizes
            //$img->removeAttribute('sizes');
    
            // src
            if($img->hasAttribute('src')){
                $existing_src = $img->getAttribute('src');
                $img->setAttribute('src', "data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=");
    
                $img->setAttribute('data-src', $existing_src);
            }
            
            // Aspect ratio for better smoohtness
            if( $img->hasAttribute('width') && $img->hasAttribute('height')){
                $width = $img->getAttribute('width');
                $height = $img->getAttribute('height');
                $aspectratio = $width . '/' . $height;
                $img->setAttribute('data-aspectratio', $aspectratio);
            }
    
            // srcset
            if($img->hasAttribute('srcset')){
                $existing_srcset = $img->getAttribute('srcset');
                $img->removeAttribute('srcset');
                $img->setAttribute('data-srcset', "$existing_srcset");
            }
    
            // Set Lazyload Class
            $existing_class = $img->getAttribute('class');
            $img->setAttribute('class', "lazyload $existing_class");
    
    
            // noscript
            $noscript = $document->createElement('noscript');
            $img->parentNode->insertBefore($noscript);
    
            $image = $document->createElement('image');
            $imageAttribute = $document->createAttribute('src');
            $imageAttribute->value = $existing_src;
            $image->appendChild($imageAttribute);
    
            $noscript->appendChild($image);
        }

    }

    $html_fragment = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $document->saveHTML()));
    
    return $html_fragment;
}

/**
 * Replace iframes by LazyLoad
 */
add_filter( 'the_content', 'ttfb_toolkit_lazyload_iframes', PHP_INT_MAX );
add_filter( 'widget_text', 'ttfb_toolkit_lazyload_iframes', PHP_INT_MAX );
function ttfb_toolkit_lazyload_iframes( $html ) {

    if ( ! get_option('ttfb_toolkit_perf_lazyload_iframe', false) || 
        ! apply_filters( 'do_ttfb_toolkit_lazyload_iframe', true ) ||
        is_search() ||
        is_admin() ||
        ttfb_toolkit_is_rest() ) {
    return $html;
    }

    $matches = array();
    preg_match_all( '/<iframe\s+.*?>/', $html, $matches );

    foreach ( $matches[0] as $k=>$iframe ) {

        
        if ( strpos( $iframe, 'gform_ajax_frame' ) || // Don't mess with the Gravity Forms ajax iframe
        strpos( $iframe, 'data-src' ) ) { // Don't mess with already lazy iframe
            continue;
        }

        $placeholder = 'data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=';

        $iframe = preg_replace( '/<iframe(.*?)src=/is', '<iframe$1src="' . $placeholder . '" class="lazyload" data-src=', $iframe );

        $html = str_replace( $matches[0][ $k ], $iframe, $html );

    }
	

    return $html;
}


add_action("wp_head","ttfb_toolkit_lazyload_picturefill");
function ttfb_toolkit_lazyload_picturefill(){
?>
<script>
    // Lazyload picturefill
    function ttfb_toolkit_loadJS(u){var r=document.getElementsByTagName("script")[ 0 ],s=document.createElement("script");s.src=u;r.parentNode.insertBefore(s,r);}
    if (!window.HTMLPictureElement || document.msElementsFromPoint) {
        ttfb_toolkit_loadJS('<?php echo TTFB_TOOLKIT_URI . "vendor/lazysizes/plugins/respimg/ls.respimg.min.js"; ?>');
    }
</script>
<?php
}