<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Enable only if Jetpack is activated
if( !class_exists('Jetpack') ){ return false; }

/**
 * Testimonials Shorcode init
 */
add_action( 'init', 'ttfb_testimonials_shortcode');
function ttfb_testimonials_shortcode(){
    add_shortcode('ttfb-testimonials', 'ttfb_testimonials_shortcodes_callback');
}

/**
 * Alert Shorcode Callback
 */
function ttfb_testimonials_shortcodes_callback($atts){
    extract(shortcode_atts(array(
        'class' => "",
        'ids' => array(),
        'items' => "6",
        'max_length' => "150",
        'read_more_link' => "",
    ), $atts));

    $args = array(
        'post_type'   => 'jetpack-testimonial',
        'posts_per_page' => $items
    );

    if( !empty( $ids ) ){
        $args['include'] = $ids;
    }


    $the_query = new WP_Query(  $args ); 

    $slider = "";

    if( $the_query->have_posts() ){
        $slider = '<div class="testimonials alignwide mt3 mb3 '. $class .'" data-flickity=\'{ "wrapAround": true, "setGallerySize": true, "arrowShape": "m46.875 98.16875-45.959375-45.959375c-1.221875-1.221875-1.221875-3.196875 0-4.41875l45.959375-45.959375 4.41875 4.41875-43.75 43.75 43.75 43.75z" }\'>';

            while ( $the_query->have_posts() ) : $the_query->the_post();
                $read_more = false;

                $testimony = '<article class="testimonial max-width-2 py2  col-11 mr2 flex items-center items-stretch">';
                $testimony .= "<div class='inner cardbox py2 px2 lg-px3 first-mt0 last-mb0'>";
                        $testimony .= "<div class='content italic font-size-110'>";
                            $testimony_content = strip_tags( get_the_content() );
                            if( strlen( $testimony_content ) >= $max_length ){
                                $read_more = true;
                                $testimony .= '<p>' . rtrim(substr($testimony_content, 0, $max_length)) . '...</p>';
                            }else{
                                $testimony .= '<p>' . substr($testimony_content, 0, $max_length) . '</p>';
                            }
                             
                        $testimony .= "</div>";
                        $testimony .= '<div class="">' . get_the_title() . '</div>';

                        if( $read_more && !empty( $read_more_link ) ){
                            $testimony .= '<div class="muted-8"><a class="inline-block bg-darken-1 rounded px1 font-size-70 text-color hover-opacity" href="'. get_the_permalink() .'">' . esc_html( $read_more_link ) . '</a></div>';
                        }

                    $testimony .= "</div>";
                $testimony .= '</article>';
                $slider .= $testimony;
            endwhile;
            
            wp_reset_postdata();
        
        $slider .= '</div>';
    }
    

    return $slider;
}

/**
 * Enqueue styles.
 */
add_action( 'wp_enqueue_scripts', 'ttfb_testimonials_scripts' );
function ttfb_testimonials_scripts() {
    global $post;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'ttfb-testimonials') ) {
        wp_enqueue_style( 'ttfb-testimonials-stylesheet', plugin_dir_url( __FILE__ ) . 'testimonials.min.css' );
        wp_enqueue_script( 'ttfb-testimonials-script', plugin_dir_url( __FILE__ ) . 'testimonials.min.js' );
    }
}