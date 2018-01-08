<?php
/**
 * Adds custom widget for Social Share.
 */
class Ttfb_Toolkit_Address_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'ttfb_toolkit_address_widget', // Base ID
      __('TTFB Address', 'ttfb-toolkit'), // Name
      array( 'description' => __( 'A fancier way to display your address.', 'ttfb-toolkit' ), ) // Args
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
    
    <div class="ttfb_toolkit_address_widget">
        <?php if ( !empty($instance['title']) ): ?>
            <?php echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title']; ?>
        <?php endif; ?>

        <div class="address_rows line-height-2">
            <?php for ($cpt = 1; $cpt <= 6; $cpt++): ?>
                <?php if( !empty( $instance['address_'. $cpt .'_content'] ) ): ?>
                    <div class="flex col-12 mb1">
                        <?php if( !empty( $instance['address_'. $cpt .'_icon'] ) ): ?>
                            <div class="icon center"><?php echo wp_kses( $instance['address_'. $cpt .'_icon'], array( 'i' => array('class' => array()) ) ) ?></div>
                        <?php endif; ?>
                        <div class="content flex-auto"><?php echo wp_kses_post( nl2br( $instance['address_'. $cpt .'_content'] ) ); ?></div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    
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
		'address_1_icon'     => '',
        'address_1_content' => '',
        'address_2_icon'     => '',
        'address_2_content' => '',
        'address_3_icon'     => '',
        'address_3_content' => '',
        'address_4_icon'     => '',
        'address_4_content' => '',
        'address_5_icon'     => '',
        'address_5_content' => '',
        'address_6_icon'     => '',
        'address_6_content' => '',
	);
	
	// Parse current settings with defaults
    extract( wp_parse_args( ( array ) $instance, $defaults ) );
    
    if ( isset($instance['title']) ) {
      $title = $instance['title'];
    }
    else {
      $title = __( 'Contact us', 'ttfb-toolkit' );
    }
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e(  'Title:','ttfb-toolkit' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>

    <?php for ($cpt = 1; $cpt <= 6; $cpt++): ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'address_'. $cpt .'_icon' ) ); ?>"><?php _e( 'Line '. $cpt, 'ttfb-toolkit' ); ?>:</label>
            <textarea style="margin-bottom: 0.5rem; height: 25px;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address_'. $cpt .'_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address_'. $cpt .'_icon' ) ); ?>" placeholder="<?php echo esc_attr('&lt;i class="fas fa-map-marker"&gt;&lt;/i&gt;'); ?>"><?php echo wp_kses_post( ${'address_'.$cpt.'_icon'} ); ?></textarea>
            <textarea style="height: 50px;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address_'. $cpt .'_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address_'. $cpt .'_content' ) ); ?>" ><?php echo wp_kses_post( ${'address_'.$cpt.'_content'} ); ?></textarea>
        </p>
    <?php endfor; ?>

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

    for ($cpt = 1; $cpt <= 6; $cpt++){
        $instance['address_'. $cpt .'_icon'] = ( ! empty( $new_instance['address_'. $cpt .'_icon'] ) ) ? wp_kses_post( $new_instance['address_'. $cpt .'_icon'] ) : '';
        $instance['address_'. $cpt .'_content'] = ( ! empty( $new_instance['address_'. $cpt .'_content'] ) ) ? wp_kses_post( $new_instance['address_'. $cpt .'_content'] ) : '';
    }

    return $instance;
  }

} // class Ttfb_Toolkit_Address_Widget

// register Ttfb_Toolkit_Address_Widget widget
add_action( 'widgets_init', function(){
  register_widget( 'Ttfb_Toolkit_Address_Widget' );
});