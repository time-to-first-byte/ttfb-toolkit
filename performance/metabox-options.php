<?php
/*
* Get meta helper
*/
function ttfb_toolkit_options_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

/*
* Init meta box
*/
function ttfb_toolkit_options_add_meta_box() {
	add_meta_box(
		'ttfb_toolkit_options-performance-options',
		__( 'Performance Options', 'ttfb_toolkit_options' ),
		'ttfb_toolkit_options_html',
		'post',
		'side',
		'default'
	);
	add_meta_box(
		'ttfb_toolkit_options-performance-options',
		__( 'Performance Options', 'ttfb_toolkit_options' ),
		'ttfb_toolkit_options_html',
		'page',
		'side',
		'default'
    );
    add_meta_box(
		'ttfb_toolkit_options-performance-options',
		__( 'Performance Options', 'ttfb_toolkit_options' ),
		'ttfb_toolkit_options_html',
		'knowledgebase',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'ttfb_toolkit_options_add_meta_box' );

function ttfb_toolkit_options_html( $post) {
    wp_nonce_field( '_ttfb_toolkit_options_nonce', 'ttfb_toolkit_options_nonce' ); 
?>
	<p>
		<input <?php if( !get_option('ttfb_toolkit_perf_lazyload_img',false) ){ echo 'disabled'; } ?> type="checkbox" name="ttfb_toolkit_options_disable_image_lazy_load" id="ttfb_toolkit_options_disable_image_lazy_load" value="disable-image-lazy-load" <?php echo ( ttfb_toolkit_options_get_meta( 'ttfb_toolkit_options_disable_image_lazy_load' ) === 'disable-image-lazy-load' ) ? 'checked' : ''; ?>>
        <label for="ttfb_toolkit_options_disable_image_lazy_load"><?php _e( 'Disable Image Lazy Load', 'ttfb_toolkit_options' ); ?></label>	
    </p>	
    <p>
		<input <?php if( !get_option('ttfb_toolkit_perf_lazyload_iframe',false) ){ echo 'disabled'; } ?> type="checkbox" name="ttfb_toolkit_options_disable_iframe_lazy_load" id="ttfb_toolkit_options_disable_iframe_lazy_load" value="disable-iframe-lazy-load" <?php echo ( ttfb_toolkit_options_get_meta( 'ttfb_toolkit_options_disable_iframe_lazy_load' ) === 'disable-iframe-lazy-load' ) ? 'checked' : ''; ?>>
        <label for="ttfb_toolkit_options_disable_iframe_lazy_load"><?php _e( 'Disable Iframe lazy Load', 'ttfb_toolkit_options' ); ?></label>	
    </p>
    <p>
		<input <?php if( !get_option('ttfb_toolkit_perf_disable_emojijs',false) && !get_option('ttfb_toolkit_perf_disable_embed',false) && !get_option('ttfb_toolkit_perf_disable_query_string',false) ){ echo 'disabled'; } ?> type="checkbox" name="ttfb_toolkit_options_disable_clean_up" id="ttfb_toolkit_options_disable_clean_up" value="disable-clean-up" <?php echo ( ttfb_toolkit_options_get_meta( 'ttfb_toolkit_options_disable_clean_up' ) === 'disable-clean-up' ) ? 'checked' : ''; ?>>
        <label for="ttfb_toolkit_options_disable_clean_up"><?php _e( 'Disable Clean Up', 'ttfb_toolkit_options' ); ?></label>	
    </p>
<?php
}

function ttfb_toolkit_options_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['ttfb_toolkit_options_nonce'] ) || ! wp_verify_nonce( $_POST['ttfb_toolkit_options_nonce'], '_ttfb_toolkit_options_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['ttfb_toolkit_options_disable_image_lazy_load'] ) )
		update_post_meta( $post_id, 'ttfb_toolkit_options_disable_image_lazy_load', esc_attr( $_POST['ttfb_toolkit_options_disable_image_lazy_load'] ) );
	else
		update_post_meta( $post_id, 'ttfb_toolkit_options_disable_image_lazy_load', null );
	if ( isset( $_POST['ttfb_toolkit_options_disable_iframe_lazy_load'] ) )
		update_post_meta( $post_id, 'ttfb_toolkit_options_disable_iframe_lazy_load', esc_attr( $_POST['ttfb_toolkit_options_disable_iframe_lazy_load'] ) );
	else
		update_post_meta( $post_id, 'ttfb_toolkit_options_disable_iframe_lazy_load', null );
	if ( isset( $_POST['ttfb_toolkit_options_disable_clean_up'] ) )
		update_post_meta( $post_id, 'ttfb_toolkit_options_disable_clean_up', esc_attr( $_POST['ttfb_toolkit_options_disable_clean_up'] ) );
	else
		update_post_meta( $post_id, 'ttfb_toolkit_options_disable_clean_up', null );
}
add_action( 'save_post', 'ttfb_toolkit_options_save' );