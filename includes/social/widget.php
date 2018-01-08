<?php
/**
 * Adds custom widget for Social Share.
 */
class Ttfb_Toolkit_Social_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'ttfb_toolkit_social_widget', // Base ID
      __('TTFB Social Profile', 'ttfb-toolkit'), // Name
      array( 'description' => __( 'Display social profile links.', 'ttfb-toolkit' ), ) // Args
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    ?>
    
    <section class="ttfb_toolkit_social_widget">
        <?php if ( !empty($instance['title']) ): ?>
            <?php echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title']; ?>
        <?php endif; ?>

        <div class="networks flex flex-wrap">
            <?php
                $link_class = 'social-network';
            ?>
            <?php if( !empty( $instance['network_1_icon'] ) && !empty( $instance['network_1_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_1_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_1_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_2_icon'] ) && !empty( $instance['network_2_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_2_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_2_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_3_icon'] ) && !empty( $instance['network_3_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_3_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_3_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_4_icon'] ) && !empty( $instance['network_4_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_4_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_4_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_5_icon'] ) && !empty( $instance['network_5_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_5_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_5_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_6_icon'] ) && !empty( $instance['network_6_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_6_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_6_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_7_icon'] ) && !empty( $instance['network_7_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_7_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_7_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_8_icon'] ) && !empty( $instance['network_8_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_8_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_8_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_9_icon'] ) && !empty( $instance['network_9_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_9_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_9_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>

            <?php if( !empty( $instance['network_10_icon'] ) && !empty( $instance['network_10_link'] ) ): ?>
                <a target="_blank" rel="noopener noreferrer nofollow" href="<?php echo esc_url( $instance['network_10_link'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>"><?php echo wp_kses( $instance['network_10_icon'], array( 'i' => array('class' => array()) ) ) ?></a>
            <?php endif; ?>
        </div>
    </section>
    
    <?php
    echo $args['after_widget'];
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {

    $defaults = array(
		'title'    => '',
		'network_1_icon'     => '',
        'network_1_link' => '',
        'network_2_icon'     => '',
        'network_2_link' => '',
        'network_3_icon'     => '',
        'network_3_link' => '',
        'network_4_icon'     => '',
        'network_4_link' => '',
        'network_5_icon'     => '',
        'network_5_link' => '',
        'network_6_icon'     => '',
        'network_6_link' => '',
        'network_7_icon'     => '',
        'network_7_link' => '',
        'network_8_icon'     => '',
        'network_8_link' => '',
        'network_9_icon'     => '',
        'network_9_link' => '',
        'network_10_icon'     => '',
		'network_10_link' => '',
	);
	
	// Parse current settings with defaults
    extract( wp_parse_args( ( array ) $instance, $defaults ) );
    
    if ( isset($instance['title']) ) {
      $title = $instance['title'];
    }
    else {
      $title = __( 'Follow us', 'ttfb-toolkit' );
    }
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e(  'Title:','ttfb-toolkit' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>

        <?php // Network 1 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_1_icon' ) ); ?>"><?php _e( 'Network 1', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_1_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_1_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_1_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_1_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_1_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_1_link ); ?>" />
        </p>

        <?php // Network 2 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_2_icon' ) ); ?>"><?php _e( 'Network 2', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_2_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_2_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_2_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_2_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_2_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_2_link ); ?>" />
        </p>

        <?php // Network 3 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_3_icon' ) ); ?>"><?php _e( 'Network 3', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_3_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_3_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_3_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_3_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_3_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_3_link ); ?>" />
        </p>

        <?php // Network 4 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_4_icon' ) ); ?>"><?php _e( 'Network 4', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_4_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_4_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_4_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_4_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_4_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_4_link ); ?>" />
        </p>

        <?php // Network 5 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_5_icon' ) ); ?>"><?php _e( 'Network 5', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_5_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_5_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_5_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_5_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_5_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_5_link ); ?>" />
        </p>

        <?php // Network 6 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_6_icon' ) ); ?>"><?php _e( 'Network 6', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_6_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_6_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_6_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_6_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_6_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_6_link ); ?>" />
        </p>

        <?php // Network 7 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_7_icon' ) ); ?>"><?php _e( 'Network 7', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_7_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_7_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_7_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_7_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_7_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_7_link ); ?>" />
        </p>

        <?php // Network 8 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_8_icon' ) ); ?>"><?php _e( 'Network 8', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_8_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_8_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_8_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_8_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_8_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_8_link ); ?>" />
        </p>

        <?php // Network 9 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_9_icon' ) ); ?>"><?php _e( 'Network 9', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_9_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_9_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_9_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_9_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_9_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_9_link ); ?>" />
        </p>

        <?php // Network 10 ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'network_10_icon' ) ); ?>"><?php _e( 'Network 10', 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_10_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_10_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class=""&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( $network_10_icon ); ?></textarea>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'network_10_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'network_10_link' ) ); ?>" type="url" placeholder="<?php echo esc_attr('https://'); ?>" value="<?php echo esc_attr( $network_10_link ); ?>" />
        </p>
    <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    // Network 1
    $instance['network_1_icon'] = ( ! empty( $new_instance['network_1_icon'] ) ) ? wp_kses_post( $new_instance['network_1_icon'] ) : '';
    $instance['network_1_link'] = ( ! empty( $new_instance['network_1_link'] ) ) ? strip_tags( $new_instance['network_1_link'] ) : '';

    // Network 2
    $instance['network_2_icon'] = ( ! empty( $new_instance['network_2_icon'] ) ) ? wp_kses_post( $new_instance['network_2_icon'] ) : '';
    $instance['network_2_link'] = ( ! empty( $new_instance['network_2_link'] ) ) ? strip_tags( $new_instance['network_2_link'] ) : '';

    // Network 3
    $instance['network_3_icon'] = ( ! empty( $new_instance['network_3_icon'] ) ) ? wp_kses_post( $new_instance['network_3_icon'] ) : '';
    $instance['network_3_link'] = ( ! empty( $new_instance['network_3_link'] ) ) ? strip_tags( $new_instance['network_3_link'] ) : '';

    // Network 4
    $instance['network_4_icon'] = ( ! empty( $new_instance['network_4_icon'] ) ) ? wp_kses_post( $new_instance['network_4_icon'] ) : '';
    $instance['network_4_link'] = ( ! empty( $new_instance['network_4_link'] ) ) ? strip_tags( $new_instance['network_4_link'] ) : '';

    // Network 5
    $instance['network_5_icon'] = ( ! empty( $new_instance['network_5_icon'] ) ) ? wp_kses_post( $new_instance['network_5_icon'] ) : '';
    $instance['network_5_link'] = ( ! empty( $new_instance['network_5_link'] ) ) ? strip_tags( $new_instance['network_5_link'] ) : '';

    // Network 6
    $instance['network_6_icon'] = ( ! empty( $new_instance['network_6_icon'] ) ) ? wp_kses_post( $new_instance['network_6_icon'] ) : '';
    $instance['network_6_link'] = ( ! empty( $new_instance['network_6_link'] ) ) ? strip_tags( $new_instance['network_6_link'] ) : '';

    // Network 7
    $instance['network_7_icon'] = ( ! empty( $new_instance['network_7_icon'] ) ) ? wp_kses_post( $new_instance['network_7_icon'] ) : '';
    $instance['network_7_link'] = ( ! empty( $new_instance['network_7_link'] ) ) ? strip_tags( $new_instance['network_7_link'] ) : '';

    // Network 8
    $instance['network_8_icon'] = ( ! empty( $new_instance['network_8_icon'] ) ) ? wp_kses_post( $new_instance['network_8_icon'] ) : '';
    $instance['network_8_link'] = ( ! empty( $new_instance['network_8_link'] ) ) ? strip_tags( $new_instance['network_8_link'] ) : '';

    // Network 9
    $instance['network_9_icon'] = ( ! empty( $new_instance['network_9_icon'] ) ) ? wp_kses_post( $new_instance['network_9_icon'] ) : '';
    $instance['network_9_link'] = ( ! empty( $new_instance['network_9_link'] ) ) ? strip_tags( $new_instance['network_9_link'] ) : '';

    // Network 10
    $instance['network_10_icon'] = ( ! empty( $new_instance['network_10_icon'] ) ) ? wp_kses_post( $new_instance['network_10_icon'] ) : '';
    $instance['network_10_link'] = ( ! empty( $new_instance['network_10_link'] ) ) ? strip_tags( $new_instance['network_10_link'] ) : '';

    return $instance;
  }

} // class Ttfb_Toolkit_Social_Widget

// register Ttfb_Toolkit_Social_Widget widget
add_action( 'widgets_init', function(){
  register_widget( 'Ttfb_Toolkit_Social_Widget' );
});