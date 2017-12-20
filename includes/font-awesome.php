<?php
 /**
 * Create customizer TTFB Toolkit panel
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( "customize_register", "ttfb_toolkit_customizer_font_awesome");
function ttfb_toolkit_customizer_font_awesome( $wp_customize ) {
    /*
    * Font Awesome Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_fa', array(
        'title'      => esc_attr__( 'Font Awesome Icons', 'ttfb-toolkit' ),
        'priority'   => 210,
        'panel'		 => 'ttfb_options',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Font Awesome Controls
    */
    $wp_customize->add_setting( 'ttfb_toolkit_fa_active', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_fa_active', array(
        'type' => 'checkbox',
        'priority' => 9,
        'section' => 'ttfb_toolkit_fa',
        'label' => __( 'Activate Font Awesome 5', 'ttfb-toolkit' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_fa_shims', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_fa_shims', array(
        'type' => 'checkbox',
        'priority' => 10,
        'section' => 'ttfb_toolkit_fa',
        'label' => __( 'Activate Font Awesome V4 Shims ', 'ttfb-toolkit' ),
        'description' => __( 'This option add compatibility with Font Awesome V4. Activate only if required.', 'ttfb-toolkit' ),
        'active_callback' => 'ttfb_toolkit_active_font_awesome',
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_fa_brands', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_fa_brands', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_fa',
        'label' => __( 'Activate Brands Library', 'ttfb-toolkit' ),
        'description' => __( 'This option add more than 318 icons. Activate only if required.', 'ttfb-toolkit' ),
        'active_callback' => 'ttfb_toolkit_active_font_awesome',
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_fa_librairy', array(
        'default' => 'solid',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_fa_librairy', array(
        'type' => 'select',
        'priority' => 30,
        'section' => 'ttfb_toolkit_fa',
        'label' => __( 'Font Awesome Library', 'faster-font-awesome' ),
        'description' => __('Complete icons list available on the <a href="https://fontawesome.com/icons/" target="_blank">Font Awesome</a> website.'),
        'choices'  => array(
			'solid'  => 'Solid',
            'regular' => 'Regular',
            //'light' => 'Light',
            'all' => 'All Libraries',
        ),
        'active_callback' => 'ttfb_toolkit_active_font_awesome',
    ) );

}

function ttfb_toolkit_active_font_awesome( $control ) {
    if ( $control->manager->get_setting('ttfb_toolkit_fa_active')->value() == '1' ) {
        return true;
    } else {
        return false;
    }
}

/*
* Create admin sub menu setting
*/
add_action('admin_menu', 'ttfb_toolkit_font_awesome_submenu_page');
function ttfb_toolkit_font_awesome_submenu_page() {
    add_submenu_page(
        'options-general.php',
        __('TTFB Toolkit','ttfb-toolkit'),
        __('TTFB Toolkit','ttfb-toolkit'),
        'manage_options',
        '/customize.php?autofocus[section]=ttfb_toolkit' );
}

/**
 * Enqueue Font Awesome Icons.
 */
add_action( 'wp_enqueue_scripts', 'ttfb_toolkit_font_awesome_font_awesome_scripts' );
function ttfb_toolkit_font_awesome_font_awesome_scripts() {

    $fa_active = get_option('ttfb_toolkit_fa_active', false);

    if( $fa_active ){
        $brands = get_option('ttfb_toolkit_fa_brands', false);
        $shims = get_option('ttfb_toolkit_fa_shims', false);
        $librairy = get_option('ttfb_toolkit_fa_librairy', 'solid');

        if( $brands == 1 && $librairy != 'all' ){
            wp_enqueue_script( 'fontawesome-brands', plugin_dir_url( __FILE__ ) . '../vendor/fontawesome/fa-brands.min.js', array(), '1.0.0', true );
        }
    
        if( $librairy == 'solid' ){
            wp_enqueue_script( 'fontawesome-solid', plugin_dir_url( __FILE__ ) . '../vendor/fontawesome/fa-solid.min.js', array(), '1.0.0', true );
        }elseif( $librairy == 'regular' ){
            wp_enqueue_script( 'fontawesome-regular', plugin_dir_url( __FILE__ ) . '../vendor/fontawesome/fa-regular.min.js', array(), '1.0.0', true );
        }elseif( $librairy == 'all' ){
            wp_enqueue_script( 'fontawesome-all', plugin_dir_url( __FILE__ ) . '../vendor/fontawesome/fontawesome-all.min.js', array(), '1.0.0', true );
        }
    
        if( $shims == 1 ){
            wp_enqueue_script( 'fontawesome-v4-shim', plugin_dir_url( __FILE__ ) . '../vendor/fontawesome/v4-shims.min.js', array(), '1.0.0', true );
        }
        
        if( $librairy != 'all' ){
            wp_enqueue_script( 'fontawesome-core', plugin_dir_url( __FILE__ ) . '../vendor/fontawesome/fontawesome.min.js', array(), '1.0.0', true );
        }
    }

}

/**
 * Icons Shorcode init
 */
add_action( 'init', 'ttfb_toolkit_font_awesome_icons_shortcodes');
function ttfb_toolkit_font_awesome_icons_shortcodes(){
    add_shortcode('ttfb-icon', 'ttfb_toolkit_font_awesome_icons_shortcodes_callback');
}

/**
 * Icons Shorcode Callback
 */
function ttfb_toolkit_font_awesome_icons_shortcodes_callback($atts){
    extract(shortcode_atts(array(
        'class' => "",
    ), $atts));
    
    $icon_class = $class;

    $return_string = '<i class="'.$icon_class.'"></i>';

    return $return_string;
}