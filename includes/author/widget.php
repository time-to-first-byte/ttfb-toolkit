<?php
/**
 * Adds custom widget.
 */
class Ttfb_Toolkit_Author_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'ttfb_toolkit_author_widget', // Base ID
      __('TTFB Author box', 'ttfb-toolkit'), // Name
      array( 'description' => __( 'Author box widget for TTFB', 'ttfb-toolkit' ), ) // Args
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

    if( !is_page() && !is_single() ){
        return;
    }

    echo $args['before_widget'];
    if ( !empty($instance['title']) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
    }
    

    global $post;

    $display_name = get_the_author_meta( 'display_name', $post->post_author );

    if ( empty( $display_name ) ){
      $display_name = get_the_author_meta( 'nickname', $post->post_author );
    }
  
    ?>
    <div class="flex items-center">
        <div class="mr2 widget-author-avatar" style="min-width: 75px">
            <?php echo get_avatar( get_the_author_meta('user_email') , 75 ); ?>
        </div>

        <p class="m0">
            <strong class="caps widget-author-name"><?php echo esc_html__("About","ttfb-toolkit"); ?> <?php echo $display_name; ?></strong><br>
            <?php echo nl2br( get_the_author_meta( 'user_description', $post->post_author ) ); ?>
        </p>
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
    if ( isset($instance['title']) ) {
      $lttfb_toolkit_title = $instance['title'];
    }
    else {
      $lttfb_toolkit_title = __( 'New title', 'ttfb-toolkit' );
    }
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e(  'Title:','ttfb-toolkit' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $lttfb_toolkit_title ); ?>">
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
    $lttfb_toolkit_instance = array();
    $lttfb_toolkit_instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $lttfb_toolkit_instance;
  }

} // class Ttfb_Toolkit_Author_Widget

// register Ttfb_Toolkit_Author_Widget widget
add_action( 'widgets_init', function(){
  register_widget( 'Ttfb_Toolkit_Author_Widget' );
});