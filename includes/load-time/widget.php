<?php
/**
 * Adds custom widget for Spacing.
 */
class Ttfb_Toolkit_Load_Time_Widget extends WP_Widget {

    /**
    * Register widget with WordPress.
    */
    function __construct() {
        parent::__construct(
            'ttfb_toolkit_load_time_widget', // Base ID
            __('TTFB Page Speed', 'ttfb-toolkit'), // Name
            array( 'description' => __( 'Display the current page load time.', 'ttfb-toolkit' ), ) // Args
        );

        // Front script
		add_action( 'wp_footer', array( $this, 'plugin_scripts' ) );
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

        echo '<div class="ttfb-loaded"></div>';
    
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
        }else {
            $lttfb_toolkit_title = __( 'Current Page Speed', 'ttfb-toolkit' );
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

    /**
    * Inject the small script
    */
    public function plugin_scripts() {
    ?>
    <script>
        window.onload = function(){
            setTimeout(function(){
            window.performance = window.performance || window.mozPerformance || window.msPerformance || window.webkitPerformance || {};
            var t = performance.timing || {};
            if (!t) {
                return;
            }
            var start = t.navigationStart,
                end = t.loadEventEnd
                loadTime = (end - start) / 1000;
            var div = document.getElementsByClassName('ttfb-loaded');
            if( div ){
                div[0].innerHTML += '<span class="loaded"><?php esc_html_e("This page loaded in","ttfb-toolkit"); ?> <strong>' + loadTime + ' <?php esc_html_e("seconds","ttfb-toolkit"); ?></strong>.</span>';
            }
            }, 0); 
        }
    </script>
    <?php
    }

} // class Ttfb_Toolkit_Load_Time_Widget

// register Ttfb_Toolkit_Load_Time_Widget widget
add_action( 'widgets_init', function(){
    register_widget( 'Ttfb_Toolkit_Load_Time_Widget' );
});