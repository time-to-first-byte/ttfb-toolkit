<?php
/**
 * Append custom share button to after content
 */
add_filter('the_content','ttfb_toolkit_sharing_append_top', 10);
function ttfb_toolkit_sharing_append_top( $content ){
    
    $share_options = get_option('ttfb_toolkit_sharing',false);
    
    if( $share_options['append'] == 'top' || $share_options['append'] == 'both' ){

        $social = '<section class="mt2 mb2">';

        if( is_singular('post') && $share_options['append_to'] != 'pages' ){
            $social .= ttfb_toolkit_sharing_get_markup();
        }elseif( ( get_post_type() == 'page' && !is_page_template() ) && $share_options['append_to'] != 'posts' ){
            $social .= ttfb_toolkit_sharing_get_markup();
        }else{
            $social .= '';
        }

        $social .= '</section>';

        $content = $social . $content;
    }

    return $content;
}

/**
 * Append custom share button after content
 */
add_action('ttfb_toolkit_after_page_content','ttfb_toolkit_sharing_append_bottom', 40);
add_action('ttfb_toolkit_after_post_content','ttfb_toolkit_sharing_append_bottom', 40);
function ttfb_toolkit_sharing_append_bottom( ){

    $share_options = get_option('ttfb_toolkit_sharing',false);

    if( $share_options['append'] == 'bottom' || $share_options['append'] == 'both' ){
        
        $social = '';
        $title = '';
        
        $social .= '<section class="mt3 mb3">';

        if( !empty( $share_options['label'] ) ){
            $title .= '<h5 class="mb2 mt0 hide-prin">' . esc_html( $share_options['label'] ) . '</h5>';
        }

        if( is_singular('post') && $share_options['append_to'] != 'pages' ){
            $social .= $title . ttfb_toolkit_sharing_get_markup();
        }elseif( ( get_post_type() == 'page' && !is_page_template() ) && $share_options['append_to'] != 'posts' ){
            $social .= $title . ttfb_toolkit_sharing_get_markup();
        }else{
            $social .= '';
        }

        $social .= '</section>';

        echo $social;
    }
}

/**
 * Custom share buttons markup
 */
function ttfb_toolkit_sharing_get_markup(){

    $share_options = get_option('ttfb_toolkit_sharing',false);
    
    $content = '';
    
    $content .= '<div class="social-share-btns hide-print max-width-3 ml-auto mr-auto m0">';

    if( !empty( $share_options['platform']['facebook'] ) ){
        $content .= '<a target="_blank" rel="noopener noreferrer nofollow" href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '&t=' . urlencode( get_the_title() ) . '" class="mb1 mr1 inline-flex items-center share-btn share-btn-facebook"><svg class="mr1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve" width="16" height="16"><g class="" fill="#ffffff"><path fill="#ffffff" d="M6.02293,16L6,9H3V6h3V4c0-2.6992,1.67151-4,4.07938-4c1.15339,0,2.14468,0.08587,2.43356,0.12425v2.82082 l-1.66998,0.00076c-1.30953,0-1.56309,0.62227-1.56309,1.53541V6H13l-1,3H9.27986v7H6.02293z"></path></g></svg> ' . esc_html__("Share","minimall") . '</a>';
    }
    
    if( !empty( $share_options['platform']['twitter'] ) ){
        $content .= '<a target="_blank" rel="noopener noreferrer nofollow" href="http://twitter.com/home?status=' . urlencode( get_the_title() ) . '+' . get_permalink() . '" class="mb1 mr1 inline-flex items-center  share-btn share-btn-twitter"><svg class="mr1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve" width="16" height="16"><g class="" fill="#ffffff"><path fill="#ffffff" d="M16,3c-0.6,0.3-1.2,0.4-1.9,0.5c0.7-0.4,1.2-1,1.4-1.8c-0.6,0.4-1.3,0.6-2.1,0.8c-0.6-0.6-1.5-1-2.4-1 C9.3,1.5,7.8,3,7.8,4.8c0,0.3,0,0.5,0.1,0.7C5.2,5.4,2.7,4.1,1.1,2.1c-0.3,0.5-0.4,1-0.4,1.7c0,1.1,0.6,2.1,1.5,2.7 c-0.5,0-1-0.2-1.5-0.4c0,0,0,0,0,0c0,1.6,1.1,2.9,2.6,3.2C3,9.4,2.7,9.4,2.4,9.4c-0.2,0-0.4,0-0.6-0.1c0.4,1.3,1.6,2.3,3.1,2.3 c-1.1,0.9-2.5,1.4-4.1,1.4c-0.3,0-0.5,0-0.8,0c1.5,0.9,3.2,1.5,5,1.5c6,0,9.3-5,9.3-9.3c0-0.1,0-0.3,0-0.4C15,4.3,15.6,3.7,16,3z"></path></g></svg> ' . esc_html__("Tweet","minimall") . '</a>';
    }

    if( !empty( $share_options['platform']['google'] ) ){
        $content .= '<a target="_blank" rel="noopener noreferrer nofollow" href="https://plus.google.com/share?url=' . get_permalink() . '" class="mb1 mr1 inline-flex items-center  share-btn share-btn-google-plus"><svg class="mr1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve" width="16" height="16"><g class="" fill="#ffffff"><path fill="#ffffff" d="M8,7v2.4h4.1c-0.2,1-1.2,3-4,3c-2.4,0-4.3-2-4.3-4.4s2-4.4,4.3-4.4 c1.4,0,2.3,0.6,2.8,1.1l1.9-1.8C11.6,1.7,10,1,8.1,1c-3.9,0-7,3.1-7,7s3.1,7,7,7c4,0,6.7-2.8,6.7-6.8c0-0.5,0-0.8-0.1-1.2H8L8,7z"></path></g></svg> ' . esc_html__("Share","minimall") . '</a>';
    }

    if( !empty( $share_options['platform']['linkedin'] ) ){
        $content .= '<a target="_blank" rel="noopener noreferrer nofollow" href="https://www.linkedin.com/shareArticle?mini=true&url=' . get_permalink() . '&title=' . urlencode( get_the_title() ) . '" class="mb1 mr1 inline-flex items-center  share-btn share-btn-linkedin"><svg class="mr1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve" width="16" height="16"><g class="" fill="#ffffff"><path fill="#ffffff" d="M15.3,0H0.7C0.3,0,0,0.3,0,0.7v14.7C0,15.7,0.3,16,0.7,16h14.7c0.4,0,0.7-0.3,0.7-0.7V0.7 C16,0.3,15.7,0,15.3,0z M4.7,13.6H2.4V6h2.4V13.6z M3.6,5C2.8,5,2.2,4.3,2.2,3.6c0-0.8,0.6-1.4,1.4-1.4c0.8,0,1.4,0.6,1.4,1.4 C4.9,4.3,4.3,5,3.6,5z M13.6,13.6h-2.4V9.9c0-0.9,0-2-1.2-2c-1.2,0-1.4,1-1.4,2v3.8H6.2V6h2.3v1h0c0.3-0.6,1.1-1.2,2.2-1.2 c2.4,0,2.8,1.6,2.8,3.6V13.6z"></path></g></svg> ' . esc_html__("Share","minimall") . '</a>';
    }

    if( !empty( $share_options['platform']['pinterest'] ) ){
        $pinterest_link = "javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());";
        $content .= '<a target="_blank" rel="noopener noreferrer nofollow" href="'. $pinterest_link .'" class="mb1 mr1 inline-flex items-center  share-btn share-btn-pinterest"><svg class="mr1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve" width="16" height="16"><g class="" fill="#ffffff"><path fill="#ffffff" d="M8,0C3.6,0,0,3.6,0,8c0,3.4,2.1,6.3,5.1,7.4c-0.1-0.6-0.1-1.6,0-2.3c0.1-0.6,0.9-4,0.9-4S5.8,8.7,5.8,8 C5.8,6.9,6.5,6,7.3,6c0.7,0,1,0.5,1,1.1c0,0.7-0.4,1.7-0.7,2.7c-0.2,0.8,0.4,1.4,1.2,1.4c1.4,0,2.5-1.5,2.5-3.7 c0-1.9-1.4-3.3-3.3-3.3c-2.3,0-3.6,1.7-3.6,3.5c0,0.7,0.3,1.4,0.6,1.8C5,9.7,5,9.8,5,9.9c-0.1,0.3-0.2,0.8-0.2,0.9 c0,0.1-0.1,0.2-0.3,0.1c-1-0.5-1.6-1.9-1.6-3.1C2.9,5.3,4.7,3,8.2,3c2.8,0,4.9,2,4.9,4.6c0,2.8-1.7,5-4.2,5c-0.8,0-1.6-0.4-1.8-0.9 c0,0-0.4,1.5-0.5,1.9c-0.2,0.7-0.7,1.6-1,2.1C6.4,15.9,7.2,16,8,16c4.4,0,8-3.6,8-8C16,3.6,12.4,0,8,0z"></path></g></svg> ' . esc_html__("Pin","minimall") . '</a>';
    }

    $content .= '</div>';

    return $content;
}