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
        'panel'		 => 'ttfb_toolkit_panel',
        'capability' => 'edit_theme_options',
    ) );

    /*
    * Sharing networks 
    */
    $wp_customize->add_setting( 'ttfb_toolkit_sharing[disabled][facebook]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[disabled][facebook]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Disable Facebook share', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[disabled][twitter]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[disabled][twitter]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Disable Twitter share', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[disabled][google]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[disabled][google]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Disable Google+ share', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[disabled][linkedin]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[disabled][linkedin]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Disable Linkedin share', 'minimall' ),
    ) );

    $wp_customize->add_setting( 'ttfb_toolkit_sharing[disabled][pinterest]', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->add_control( 'ttfb_toolkit_sharing[disabled][pinterest]', array(
        'type' => 'checkbox',
        'priority' => 20,
        'section' => 'ttfb_toolkit_sharing',
        'label'       => __( 'Disable Pinterrest share', 'minimall' ),
    ) );

}

