<?php
/**
 * Create customizer TTFB Toolkit panel
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( "customize_register", "ttfb_toolkit_customizer_alerts");
function ttfb_toolkit_customizer_alerts( $wp_customize ) {

    /*
    * Alerts Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_alerts', array(
        'title'      => esc_attr__( 'Alerts', 'ttfb-toolkit' ),
        'priority'   => 200,
        'panel'		 => 'ttfb_options',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Alerts Controls
    */
    $wp_customize->add_setting( 'ttfb_toolkit_alerts_active', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'ttfb_toolkit_alerts_active', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_alerts',
        'label' => __( 'Activate alert module', 'ttfb-toolkit' ),
    ) );
}

/**
 * Alert Shorcode init
 */
add_action( 'init', 'ttfb_toolkit_alert_shortcode');
function ttfb_toolkit_alert_shortcode(){
    if( get_option('ttfb_toolkit_alerts_active',false) ){
        add_shortcode('ttfb-alert', 'ttfb_toolkit_alert_shortcodes_callback');
    }
}

/**
 * Alert Shorcode Callback
 */
function ttfb_toolkit_alert_shortcodes_callback($atts){
    extract(shortcode_atts(array(
        'class' => "",
        'type' => "",
        'title' => "",
        'content' => "",
    ), $atts));

    if( $type == 'info' ){
        $icon = '<i class="fas fa-lightbulb fa-2x fa-fw animated infinite pulseOpacity icon"></i>';
        $class = 'alert_info';
    }elseif( $type == 'warning' ){
        $icon = '<i class="fas fa-exclamation-triangle fa-2x fa-fw animated infinite pulseOpacity icon"></i>';
        $class = 'alert_warning';
    }elseif( $type == 'danger' ){
        $icon = '<i class="fas fa-exclamation-triangle fa-2x fa-fw animated infinite pulseOpacity icon"></i>';
        $class = 'alert_danger';
    }elseif( $type == 'sucess' ){
        $icon = '<i class="fas fa-check-circle fa-2x fa-fw animated infinite pulseOpacity icon"></i>';
        $class = 'alert_sucess';
    }else{
        $icon = '';
        $class = '';
    }

    $alert = '<div class="alert_shortcode '. $class .'">';

        if( !empty( $icon ) ){
            $alert .= '<div class="icon_box">'.$icon.'</div>';
        }

        $alert .= '<div class="content_box">';
            if( !empty( $title ) ){
                $alert .= '<strong>'.$title.'</strong>';
            }

            if( !empty( $content ) ){
                $alert .= '<p>'.$content.'</p>';
            }
        $alert .= '</div>';

    $alert .= '</div>';

    return $alert;
}

/**
 * Enqueue styles.
 */
add_action( 'wp_enqueue_scripts', 'ttfb_toolkit_alerts_style' );
function ttfb_toolkit_alerts_style() {
    if( get_option('ttfb_toolkit_alerts_active',false) ){
        wp_enqueue_style( 'ttfb-toolkit-alerts', plugin_dir_url( __FILE__ ) . '../assets/css/alerts.min.css' );
    }
}