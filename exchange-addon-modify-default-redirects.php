<?php
/*
 * Plugin Name: iThemes Exchange - Modify Default Redirects
 * Version: 1.0.2
 * Description: Allows the store owner to change the default locations Exchange redirects customers to after actions like a successful login.
 * Plugin URI: http://ithemes.com/purchase/modify-default-redirects-ithemes-exchange-add-on/
 * Author: iThemes
 * Author URI: http://ithemes.com
 * iThemes Package: exchange-addon-modify-default-redirects
 
 * Installation:
 * 1. Download and unzip the latest release zip file.
 * 2. If you use the WordPress plugin uploader to install this plugin skip to step 4.
 * 3. Upload the entire plugin directory to your `/wp-content/plugins/` directory.
 * 4. Activate the plugin through the 'Plugins' menu in WordPress Administration.
 *
*/

/**
 * This registers our plugin as a membership addon
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_register_modify_default_redirects_addon() {
	$options = array(
		'name'              => __( 'Modify Default Redirects', 'LION' ),
		'description'       => __( 'Allows the store owner to change the default locations Exchange redirects customers to after actions like a successful login.', 'LION' ),
		'author'            => 'iThemes',
		'author_url'        => 'http://ithemes.com/purchase/modify-default-redirects-ithemes-exchange-add-on/',
		'icon'              => ITUtility::get_url_from_file( dirname( __FILE__ ) . '/lib/assets/modify-default-redirects50px.png' ),
		'file'              => dirname( __FILE__ ) . '/init.php',
		'category'          => 'product-feature',
		'basename'          => plugin_basename( __FILE__ ),
		'settings-callback' => 'it_exchange_modify_default_redirects_settings_callback',
	);
	it_exchange_register_addon( 'modify-default-redirects', $options );
}
add_action( 'it_exchange_register_addons', 'it_exchange_register_modify_default_redirects_addon' );

/**
 * Loads the translation data for WordPress
 *
 * @uses load_plugin_textdomain()
 * @since 1.0.0
 * @return void
*/
function it_exchange_modify_default_redirects_set_textdomain() {
	load_plugin_textdomain( 'LION', false, dirname( plugin_basename( __FILE__  ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'it_exchange_modify_default_redirects_set_textdomain' );

/**
 * Registers Plugin with iThemes updater class
 *
 * @since 1.0.0
 *
 * @param object $updater ithemes updater object
 * @return void
*/
function ithemes_exchange_addon_modify_default_redirects_updater_register( $updater ) { 
	    $updater->register( 'exchange-addon-modify-default-redirects', __FILE__ );
}
//add_action( 'ithemes_updater_register', 'ithemes_exchange_addon_modify_default_redirects_updater_register' );
//require( dirname( __FILE__ ) . '/lib/updater/load.php' );
