<?php
/*
 *	Plugin Name: 	WordPress Starter-Kit
 *	Description:    Plugin starter-kit for rapid plugin development.
 *	Author:         Jer / aut0poietic
 *	Author URI:     http://irresponsibleart.com
 *	Version: 		0.9.1
 *	Text Domain: 	starter_kit
 *	Domain Path: 	languages/
 */

namespace irresponsible_art\starter_kit;
require_once( 'features/silence.php' );

define( 'irresponsible_art\starter_kit\VERSION', '0.9.1' );
define( 'irresponsible_art\starter_kit\PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'irresponsible_art\starter_kit\PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/*
 * The following includes add features to the plugin
 */
require_once( 'features/feature.php' );
require_once( 'features/template.php' );
require_once( 'features/options.php' );
require_once( 'features/class-loader.php' );
require_once( 'features/kit.php' );

/**
 * The central plugin class and bootstrap for the application.
 *
 * While this class is primarily boilerplate code and can be used without alteration,
 * there are a few things you need to edit to get the most out of this kit:
 *  * Add any initialization code that must run *during* the plugins_loaded action in the constructor.
 *  * Edit the return value of the defaults function so that the array contains all your default plugin values.
 *  * Add any plugin activation code to the activate_plugin method.
 *  * Add any plugin deactivation code to the deactivate_plugin method.
 *      - If you don't have any activation code, be sure to comment-out register_deactivation_hook
 */
class StarterKit extends Kit {

	private static $__instance;

	public static function init() {
		if ( !self::$__instance ) {
			load_plugin_textdomain( 'starter_kit', FALSE, PLUGIN_DIR . 'languages' );
			self::$__instance = new StarterKit();
			parent::initialize();
		}
		return self::$__instance;
	}

	/**
	 * Constructor: Main entry point for your plugin. Runs during the plugins_loaded action.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Provides the default settings for the plugin.
	 *
	 * The defaults method is only ever run on plugin activation and is used to populate the default options
	 * for the plugin. When you update the options for your plugin in this method when adding functionality,
	 * the kit will ensure that the user's options are up to date.
	 *
	 * @static
	 * @return array The default preferences and settings for the plugin.
	 */
	private static function defaults() {
		return array(

		);
	}

	/**
	 * Plugin activation hook
	 *
	 * Add any activation code you need to do here, like building tables and such.
	 * You won't need to worry about your options so long as you updated them using the defaults method.
	 *
	 * @static
	 * @hook register_activation_hook
	 */
	public static function activate_plugin() {

	}

	/**
	 * Plugin deactivation hook
	 *
	 * Need to clean up your plugin when it's deactivated?  Do that here.
	 * Remember, this isn't when your plugin is uninstalled, just deactivated
	 * ( so it happens when the plugin is updated too ).
	 *
	 * @static
	 * @hook register_deactivation_hook
	 */
	public static function deactivate_plugin() {

	}

} // End Class

//...and away we go!
add_action( 'plugins_loaded', array( 'irresponsible_art\starter_kit\StarterKit', 'init' ) );
register_activation_hook( __FILE__, array( 'irresponsible_art\starter_kit\StarterKit', '_activate_plugin' ) );
register_deactivation_hook( __FILE__, array( 'irresponsible_art\starter_kit\StarterKit', 'deactivate_plugin' ) );