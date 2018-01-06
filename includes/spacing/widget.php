<?php
/**
 * Adds custom widget for Spacing.
 */
class Ttfb_Toolkit_Spacing_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'ttfb_toolkit_spacing_widget', // Base ID
      __('TTFB Spacing', 'ttfb-toolkit'), // Name
      array( 'description' => __( 'Create spacing between widgets.', 'ttfb-toolkit' ), ) // Args
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
    
    if ( !empty($instance['space']) ) {
        echo '<div class="clearfix p'. $instance['space'] .'"></div>';
    }
    
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
    if ( isset($instance['space']) ) {
      $lminimall_space = $instance['space'];
    }else {
      $lminimall_space = '2';
    }
    ?>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'space' ) ); ?>"><?php esc_html_e(  'Space:','ttfb-toolkit' ); ?></label>
        <select class='widefat' id="<?php echo $this->get_field_id('space'); ?>" name="<?php echo $this->get_field_name('space'); ?>" type="text">
            <option value='1'<?php echo ($lminimall_space=='1')?'selected':''; ?>>Space 1</option>
            <option value='2'<?php echo ($lminimall_space=='2')?'selected':''; ?>>Space 2</option> 
            <option value='3'<?php echo ($lminimall_space=='3')?'selected':''; ?>>Space 3</option> 
            <option value='4'<?php echo ($lminimall_space=='4')?'selected':''; ?>>Space 4</option> 
        </select>      
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
    $lminimall_instance = array();
    $lminimall_instance['space'] = ( ! empty( $new_instance['space'] ) ) ? strip_tags( $new_instance['space'] ) : '';

    return $lminimall_instance;
  }

} // class Ttfb_Toolkit_Spacing_Widget

// register Ttfb_Toolkit_Spacing_Widget widget
add_action( 'widgets_init', function(){
  register_widget( 'Ttfb_Toolkit_Spacing_Widget' );
});