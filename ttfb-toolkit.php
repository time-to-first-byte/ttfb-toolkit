<?php
/*
Plugin Name:       TTFB Toolkit
Plugin URI:        https://github.com/time-to-first-byte/ttfb-toolkit
Description:       The TTFB Toolkit extends functionality to TTFB Themes, providing Font Awesome icons, alerts and more.
Version:           1.1.1
Author:            TTFB
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit();


// Toolkit version
define( 'TTFB_TOOLKIT_VERSION', '1.0' );

// Toolkit root directory
define( 'TTFB_TOOLKIT_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

// Includes directory
define( 'TTFB_TOOLKIT_INCLUDES', trailingslashit( TTFB_TOOLKIT_DIR ) . 'includes/' );

// Plugin root file
define( 'TTFB_TOOLKIT_PLUGIN_FILE', __FILE__ );

// Toolkit URI
define( 'TTFB_TOOLKIT_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * The Ttfb_Toolkit class.
 *
 * @since 1.0.0
 */
class Ttfb_Toolkit {
    
    /**
     * The constructor method for the Ttfb_Toolkit class.
     * Adds other methods to WordPress hooks.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Define textdomain
        load_plugin_textdomain( 'ttfb-toolkit', false, 'TTFB_TOOLKIT_INCLUDES' . 'languages/' );

        // Includes
        add_action( 'after_setup_theme', array( $this, 'includes' ), 11 );

        // Activation hook
        register_activation_hook( __FILE__ , array( $this, 'toolkit_activation' ) );
        
        // Front script
		add_action( 'wp_enqueue_scripts', array( $this, 'plugin_scripts' ) );

    }

    /**
     * Loads the required files for the Toolkit and specified by themes.
     *
     * @since 1.0.0
     */
    function includes() {
        /**
         * Custom HTML Control
         */
        require_once( TTFB_TOOLKIT_INCLUDES . 'hooks.php' );

        /**
         * Custom HTML Control
         */
        require_once( TTFB_TOOLKIT_INCLUDES . 'controls/html-control.php' );

        /**
         * Alerts
         */
        require_if_theme_supports( 'ttfb_toolkit_alerts', TTFB_TOOLKIT_INCLUDES . 'alerts.php' );

        /**
         * Font Awesome
         */
        require_if_theme_supports( 'ttfb_toolkit_icons', TTFB_TOOLKIT_INCLUDES . 'font-awesome.php' );

        /**
         * Performance
         */
        require_if_theme_supports( 'ttfb_toolkit_performance', TTFB_TOOLKIT_INCLUDES . 'performance/performance-init.php' );

        /**
         * Sharing
         */
        require_if_theme_supports( 'ttfb_toolkit_sharing', TTFB_TOOLKIT_INCLUDES . 'sharing/sharing.php' );

        /**
         * Author Widget
         */
        require_if_theme_supports( 'ttfb_toolkit_author_widget', TTFB_TOOLKIT_INCLUDES . 'author/widget.php' );

        /**
         * Spacing Widget
         */
        require_if_theme_supports( 'ttfb_toolkit_spacing_widget', TTFB_TOOLKIT_INCLUDES . 'spacing/widget.php' );

        /**
         * Social Widget
         */
        require_if_theme_supports( 'ttfb_toolkit_social_widget', TTFB_TOOLKIT_INCLUDES . 'social/widget.php' );

        /**
         * Performance Debug
         */
        require_if_theme_supports( 'ttfb_toolkit_debug_widget', TTFB_TOOLKIT_INCLUDES . 'debug/performance-debug.php' );
    }

    /**
	 * Actions that run on plugin activation.
	 *
	 * @since 1.0.0
	 */
	function toolkit_activation() {
        
        // Save the previous version we're upgrading from
        $current_version = get_option( 'ttfb_toolkit_version', false );
        if ( $current_version )
            update_option( 'ttfb_toolkit_previous_version', $current_version );

        // Save current version
        update_option( 'ttfb_toolkit_version', TTFB_TOOLKIT_VERSION );
    }

    /**
	 * Add plugin scripts
	 *
	 * @since 1.0.0
	 */
    function plugin_scripts() {
        // Load no matter what because the script used for hero images
        wp_enqueue_script( 'ttfb-toolkit-lazysizes', TTFB_TOOLKIT_URI . 'vendor/lazysizes/lazysizes-all.min.js', '', '', true );
    }
    
}

// Let's do this
$ttfb_toolkit = new Ttfb_Toolkit;