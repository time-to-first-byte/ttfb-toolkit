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

/**
 * Main function. Runs everything.
 */
function ttfb_toolkit_lazyload_lazyload_images() {

    // If this is the admin page, do nothing.
    if ( is_admin() ) {
        return;
    }

    // If the Jetpack Lazy-Images module is active, do nothing.
	if ( ! apply_filters( 'lazyload_is_enabled', true ) ) {
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

	add_action( 'wp_head', 'ttfb_toolkit_lazyload_setup_filters', PHP_INT_MAX );
	add_action( 'wp_enqueue_scripts', 'ttfb_toolkit_lazyload_enqueue_assets' );

	// Do not lazy load avatar in admin bar.
	add_action( 'admin_bar_menu', 'ttfb_toolkit_lazyload_remove_filters', 0 );
    
    // include picturefill for old browsers
    add_action("wp_head","ttfb_toolkit_lazyload_picturefill");

}
add_action( 'wp', 'ttfb_toolkit_lazyload_lazyload_images' );

/**
 * Setup filters to enable lazy-loading of images.
 */
function ttfb_toolkit_lazyload_setup_filters() {
    // images
	add_filter( 'get_avatar'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX  );
    add_filter( 'the_content'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
    add_filter( 'widget_text'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
    add_filter( 'get_image_tag'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
    add_filter( 'post_thumbnail_html'	, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );

    // iframe
    add_filter( 'the_content', 'ttfb_toolkit_lazyload_iframes', PHP_INT_MAX );
    add_filter( 'widget_text', 'ttfb_toolkit_lazyload_iframes', PHP_INT_MAX );
}

/**
 * Remove filters for images that should not be lazy-loaded.
 */
function ttfb_toolkit_lazyload_remove_filters() {
	// images
	remove_filter( 'get_avatar'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX  );
    remove_filter( 'the_content'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
    remove_filter( 'widget_text'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
    remove_filter( 'get_image_tag'			, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );
    remove_filter( 'post_thumbnail_html'	, 'ttfb_toolkit_lazy_load_image', PHP_INT_MAX );

    // iframe
    remove_filter( 'the_content', 'ttfb_toolkit_lazyload_iframes', PHP_INT_MAX );
    remove_filter( 'widget_text', 'ttfb_toolkit_lazyload_iframes', PHP_INT_MAX );
}

/**
 * Lazy load module
 *
 * @package perfthemes
 * @since 1.0
 */
function ttfb_toolkit_lazy_load_image( $content ){

    // If lazy load is not active, do nothing.
    if ( ! get_option('ttfb_toolkit_perf_lazyload_img', false) ) {
        return $content;
    }

    // if lazy load is disabled on the page, do nothing.
    if (  ! apply_filters( 'do_ttfb_toolkit_lazyload_image', true ) ) {
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

    /*
    * Regular <img> tags
    */
    $imgs = $document->getElementsByTagName('img');
    foreach ($imgs as $img) {

        $existing_class = $img->getAttribute('class');

        if( !$img->hasAttribute('data-src') && 
            strpos($existing_class, 'no-lazy') != true 
        ){
            // add data-sizes
            $img->setAttribute('data-size', "auto");
    
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
            $img->setAttribute('class', "lazyload $existing_class");

            // Boucer Loader only for entry-content images
            /*if( strpos($existing_class, 'wp-image-') !== false ){
                $loader = $document->createElement('div');
                $firstSibling = $img->parentNode->firstChild;
                if( $loader !== $firstSibling ) {
                    //$img->parentNode->insertBefore( $loader, $firstSibling );
                    $img->parentNode->insertBefore($loader, $img->nextSibling);

                    $loader->setAttribute('class', "bouncing-loader");
                    $loaderchild1 = $document->createElement('div');
                    $loaderchild2 = $document->createElement('div');
                    $loaderchild3 = $document->createElement('div');
                    $loader->appendChild($loaderchild1);
                    $loader->appendChild($loaderchild2);
                    $loader->appendChild($loaderchild3);
                }
            }*/
            
            
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
function ttfb_toolkit_lazyload_iframes( $content ) {

    // If lazy load is not active, do nothing.
    if ( ! get_option('ttfb_toolkit_perf_lazyload_iframe', false) ) {
        return $content;
    }

    // if lazy load is disabled on the page, do nothing.
    if (  ! apply_filters( 'do_ttfb_toolkit_lazyload_iframe', true ) ) {
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

    /*
    * Regular <iframe> tags
    */
    $iframes = $document->getElementsByTagName('iframe');
    foreach ($iframes as $iframe) {
        
        if( !$iframe->hasAttribute('data-src') ){
            // add data-sizes
            $iframe->setAttribute('data-size', "auto");
    
            
            if($iframe->hasAttribute('src')){
                // src
                $existing_src = $iframe->getAttribute('src');
                $iframe->setAttribute('src', "data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=");
    
                $iframe->setAttribute('data-src', $existing_src);

                // Set Lazyload Class
                $existing_class = $iframe->getAttribute('class');
                $iframe->setAttribute('class', "lazyload $existing_class");

                // noscript
                $noscript = $document->createElement('noscript');
                $firstSibling = $iframe->parentNode->firstChild;
                if( $noscript !== $firstSibling ) {
                    $iframe->parentNode->insertBefore($noscript, $iframe->nextSibling);

  
                    $frame = $document->createElement('iframe');
                    $frame->setAttribute('data-src', "");
                    $frame->setAttribute('src', $existing_src);
                    $noscript->appendChild($frame);
                }

            }
    
            
    
        }

    }

    $html_fragment = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $document->saveHTML()));
    
    return $html_fragment;
}



function ttfb_toolkit_lazyload_picturefill(){
?>
<script>
/* lasysizes picturefill */ 
    function ttfb_toolkit_loadJS(u){var r=document.getElementsByTagName("script")[ 0 ],s=document.createElement("script");s.src=u;r.parentNode.insertBefore(s,r);}
    if (!window.HTMLPictureElement || document.msElementsFromPoint) {
        ttfb_toolkit_loadJS('<?php echo TTFB_TOOLKIT_URI . "vendor/lazysizes/plugins/respimg/ls.respimg.min.js"; ?>');
    }
</script>
<?php
}

/**
 * Enqueue and defer lazyload script.
 */
function ttfb_toolkit_lazyload_enqueue_assets() {
	wp_enqueue_script( 'ttfb-toolkit-lazysizes', TTFB_TOOLKIT_URI . 'vendor/lazysizes/lazysizes-all.min.js', '', '', false );
	wp_script_add_data( 'ttfb-toolkit-lazysizes', 'defer', true );
}

