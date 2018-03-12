<?php
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'TTFB_Toolkit_Custom_Content' ) ) :
    class TTFB_Toolkit_Custom_Content extends WP_Customize_Control {
    
        // Whitelist content parameter
        public $content = '';
    
        /**
         * Render the control's content.
         *
         * Allows the content to be overriden without having to rewrite the wrapper.
         *
         * @since   1.0.0
         * @return  void
         */
        public function render_content() {
            if ( isset( $this->label ) ) {
                echo '<span class="customize-control-title">' . $this->label . '</span>';
            }
            if ( isset( $this->content ) ) {
                echo $this->content;
            }
            if ( isset( $this->description ) ) {
                echo '<span class="description customize-control-description">' . $this->description . '</span>';
            }
        }
    }
endif;

/*
$wp_customize->add_setting( 'example-control', array() );

$wp_customize->add_control( new Prefix_Custom_Content( $wp_customize, 'example-control', array(
	'section' => 'title_tagline',
	'priority' => 20,
	'label' => __( 'Example Control', 'govpress' ),
	'content' => __( 'Content to output. Use <a href="#">HTML</a> if you like.', 'textdomain' ) . '</p>',
	'description' => __( 'Optional: Example Description.', 'textdomain' ),
) ) );
*/