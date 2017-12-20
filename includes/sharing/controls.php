<?php
/**
 * Create customizer TTFB Toolkit panel
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
add_action( "customize_register", "ttfb_toolkit_customizer_sharing");
function ttfb_toolkit_customizer_sharing( $wp_customize ) {
    /*
    * Sharing Section
    */
    $wp_customize->add_section( 'ttfb_toolkit_sharing', array(
        'title'      => esc_attr__( 'Sharing', 'ttfb-toolkit' ),
        'priority'   => 210,
        'panel'		 => 'ttfb_options',
        'capability' => 'edit_theme_options',
    ) );
    
    /*
    * Sharing label 
    */
    $wp_customize->add_setting( 'ttfb_toolkit_sharing[label]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[label]', array(
        'type' => 'text',
        'priority' => 10,
        'section' => 'ttfb_toolkit_sharing',
        'label' => __( 'Sharing label', 'ttfb-toolkit' ),
    ) );

    /*
    * Sharing networks 
    */
    $wp_customize->add_setting( 'ttfb_toolkit_sharing[platform][facebook]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[platform][facebook]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Facebook', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[platform][twitter]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[platform][twitter]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Twitter', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[platform][google]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[platform][google]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Google', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[platform][linkedin]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[platform][linkedin]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Linkedin', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[platform][pinterest]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[platform][pinterest]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Pinterrest', 'minimall' ),
    ) );

    /*
    * Sharing append 
    */
    $wp_customize->add_setting( 'ttfb_toolkit_sharing[append]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[append]', array(
        'type' => 'select',
        'priority' => 50,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Automatically append', 'minimall' ),
        'description' => __( 'Automatically append social share module to content. A widget is also available.', 'minimall' ),
        'choices'     => array(
            'none' => esc_attr__( 'None', 'minimall' ),
            'top' => esc_attr__( 'At the top', 'minimall' ),
            'bottom' => esc_attr__( 'At the bottom', 'minimall' ),
            'both' => esc_attr__( 'Both', 'minimall' ),
        ),
    ) );

    /*
    * Sharing append location
    */
    $wp_customize->add_setting( 'ttfb_toolkit_sharing[append_to]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[append_to]', array(
        'type' => 'select',
        'priority' => 60,
        'section' => 'ttfb_toolkit_sharing',
        'label' => __( 'Append to', 'ttfb-toolkit' ),
        'choices'     => array(
            'all' => esc_attr__( 'Pages and Posts', 'minimall' ),
            'posts' => esc_attr__( 'Posts only', 'minimall' ),
            'pages' => esc_attr__( 'Pages only', 'minimall' ),
        ),
        'active_callback' => 'ttfb_toolkit_sharing_auto_append',
    ) );

}

function ttfb_toolkit_sharing_auto_append( $control ) {
    if ( $control->manager->get_setting('ttfb_toolkit_sharing[append]')->value() != 'none' ) {
        return true;
    } else {
        return false;
    }
}