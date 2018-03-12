<?php
/**
 * Create customizer TTFB Toolkit Panel
 *
 * @param WP_Customize_Manager 
 */
add_action( "customize_register", "ttfb_toolkit_customizer_panel");
function ttfb_toolkit_customizer_panel( $wp_customize ) {
    $wp_customize->add_panel( 'ttfb_toolkit_panel', array(
        'title'      => esc_attr__( 'TTFB Toolkit', 'ttfb-toolkit' ),
        'priority'   => 450,
        'panel'		 => 'ttfb_toolkit',
        'capability' => 'edit_theme_options',
    ) );
}

/**
 * TTFB Toolkit Panel Customizer Styles
 */
add_action( 'customize_controls_print_styles', 'ttfb_toolkit_panel_styles', 999 );
function ttfb_toolkit_panel_styles() { ?>
	<style>
        li#accordion-panel-ttfb_toolkit_panel > h3.accordion-section-title:before {
            content: "\f180";
            font-family: dashicons;
            padding: 0 3px 0 0;
            vertical-align: middle;
            font-size: 22px;
            line-height: 1;
        }
	</style>
	<?php
}