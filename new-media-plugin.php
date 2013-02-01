<?php
/*
Plugin Name: New Media Manager Example
Plugin URI: https://github.com/ET-CS/WP3.5-Media-Manager-Demo.git
Description: This plugin gives an example of how to customize the new media manager experience in WordPress 3.5.
Author: Thomas Griffin/ET-CS
Author URI: http://etcs.me/
Version: 1.0.0
License: GNU General Public License v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

/**
 * Main class for the plugin.
 *
 * @since 1.0.0
 *
 * @package New Media Plugin
 * @author  Thomas Griffin
 */
class New_Media_Plugin {

    /**
     * Constructor for the class.
     *
     * @since 1.0.0
     */
    public function __construct() {

		// define consts.
		define( 'NEW_NEDIA_PLUGIN_MENU_SLUG', 'media_manager_demo' );
	
        // Load the plugin textdomain.
        load_plugin_textdomain( 'nmp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        // Load our custom assets.
        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

        // Generate the custom metabox to hold our example media manager.
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		// Create settings page
		add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
	
    }

    /**
     * Loads any plugin assets we may have.
     *
     * @since 1.0.0
     *
     * @return null Return early if not on a page add/edit screen
     */
    public function assets() {

		$settings = 'settings_page_'.NEW_NEDIA_PLUGIN_MENU_SLUG;
		// Bail out early if we are not on a page add/edit screen.
        if ( ( ! ( 'post' == get_current_screen()->base && 'page' == get_current_screen()->id ) ) && ( ! ( $settings == get_current_screen()->base && $settings == get_current_screen()->id ) ) )
            return;

        // This function loads in the required media files for the media manager.
        wp_enqueue_media();

        // Register, localize and enqueue our custom JS.
        wp_register_script( 'nmp-media', plugins_url( '/js/media.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
        wp_localize_script( 'nmp-media', 'nmp_media',
            array(
                'title'     => __( 'Upload or Choose Your Custom Image File', 'nmp' ), // This will be used as the default title
                'button'    => __( 'Insert Image into Input Field', 'nmp' )            // This will be used as the default button text
            )
        );
        wp_enqueue_script( 'nmp-media' );

    }

    /**
     * Create the custom metabox.
     *
     * @since 1.0.0
     */
    public function add_meta_boxes() {

        // This metabox will only be loaded for pages.
        add_meta_box( 'new-media-plugin', __( 'New Media Plugin Settings', 'nmp' ), array( $this, 'metabox' ), 'page', 'normal', 'high' );

    }

    /**
     * Callback function to output our custom settings page.
     *
     * @since 1.0.0
     *
     * @param object $post Current post object data
     */
    public function metabox( $post ) {

        echo '<div id="new-media-settings">';
            echo '<p>' . __( 'Click on the button below to open up the media modal and watch your customizations come to life!', 'nmp' ) . '</p>';
            echo '<p><strong>' . __( 'Please note that none of this will save when you update the page. This is just for demonstration purposes only!', 'nmp' ) . '</strong></p>';
            echo '<p><a href="#" class="open-media button button-primary" title="' . esc_attr__( 'Click Here to Open the Media Manager', 'nmp' ) . '">' . __( 'Click Here to Open the Media Manager', 'nmp' ) . '</a></p>';
            echo '<p><label for="new-media-image">' . __( 'Our Image Goes Here!', 'nmp' ) . '</label> <input type="text" id="new-media-image" size="70" value="" /></p>';
        echo '</div>';

    }
	
	public function create_admin_menu() {
	
		$page_title = 'Media Manager Demo';
		$menu_title = $page_title;
		$capability = 'manage_options';
		$menu_slug = NEW_NEDIA_PLUGIN_MENU_SLUG;
		$function = array( $this, 'create_setting_page' );
		add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		
	}

	function create_setting_page() {
	
		echo '<div id="new-media-settings">';
        echo '<p>' . __( 'Click on the button below to open up the media modal and watch your customizations come to life!', 'nmp' ) . '</p>';
        echo '<p><strong>' . __( 'Please note that none of this will save when you update the page. This is just for demonstration purposes only!', 'nmp' ) . '</strong></p>';
        echo '<p><a href="#" class="open-media button button-primary" title="' . esc_attr__( 'Click Here to Open the Media Manager', 'nmp' ) . '">' . __( 'Click Here to Open the Media Manager', 'nmp' ) . '</a></p>';
        echo '<p><label for="new-media-image">' . __( 'Our Image Goes Here!', 'nmp' ) . '</label> <input type="text" id="new-media-image" size="70" value="" /></p>';
        echo '</div>';
		
	}
	
}

// Instantiate the class.
$new_media_plugin = new New_Media_Plugin();