<?php
/**
 * TTFB Toolkit before page content hook
 */
add_action( 'minimall_before_page_content', 'ttfb_toolkit_before_page_content_hook', 10 );
function ttfb_toolkit_before_page_content_hook() { 
    do_action('ttfb_toolkit_before_page_content');
}

/**
 * TTFB Toolkit before post content hook
 */
add_action( 'minimall_before_post_content', 'ttfb_toolkit_before_post_content_hook', 10 );
function ttfb_toolkit_before_post_content_hook() { 
    do_action('ttfb_toolkit_before_post_content');
}

/**
 * TTFB Toolkit after page content hook
 */
add_action( 'minimall_after_page_content', 'ttfb_toolkit_after_page_content_hook', 10 );
function ttfb_toolkit_after_page_content_hook() { 
    do_action('ttfb_toolkit_after_page_content');
}

/**
 * TTFB Toolkit after post content hook
 */
add_action( 'minimall_after_post_content', 'ttfb_toolkit_after_post_content_hook', 10 );
function ttfb_toolkit_after_post_content_hook() { 
    do_action('ttfb_toolkit_after_post_content');
}