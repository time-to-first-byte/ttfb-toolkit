<?php
/**
 * Adds custom widget for Social Share.
 */
class Ttfb_Toolkit_Sharing_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'ttfb_toolkit_sharing_widget', // Base ID
      __('TTFB Sharing', 'ttfb-toolkit'), // Name
      array( 'description' => __( 'Display social share links.', 'ttfb-toolkit' ), ) // Args
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
    if ( !empty($instance['title']) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
    }
    
    echo ttfb_toolkit_sharing_get_markup();
    
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
    if ( isset($instance['title']) ) {
      $lminimall_title = $instance['title'];
    }
    else {
      $lminimall_title = __( 'New title', 'ttfb-toolkit' );
    }
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e(  'Title:','ttfb-toolkit' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $lminimall_title ); ?>">
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
    $lminimall_instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $lminimall_instance;
  }

} // class Ttfb_Toolkit_Sharing_Widget

// register Ttfb_Toolkit_Sharing_Widget widget
add_action( 'widgets_init', function(){
  register_widget( 'Ttfb_Toolkit_Sharing_Widget' );
});