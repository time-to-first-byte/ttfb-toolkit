<?php
function riad_enqueue_blocks() {
    // Script
    wp_enqueue_script(
		'riad-block',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
    );
    
    // Styles.
	wp_enqueue_style(
		'gb-block-03-block-editable-editor', // Handle.
		plugins_url( 'editor.css', __FILE__ ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // filemtime — Gets file modification time.
	);
}
add_action( 'enqueue_block_editor_assets', 'riad_enqueue_blocks' );

add_action( 'enqueue_block_assets', 'ttfb_toolkit_gutenberg_pillar_post_enqueue_styles' );
function ttfb_toolkit_gutenberg_pillar_post_enqueue_styles() {
	wp_enqueue_style(
		'pillar-post-block-style',
		plugins_url( 'block.css', __FILE__ ),
		array( 'wp-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.css' )
	);
}
