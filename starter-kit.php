<?php
/*
 *	Plugin Name: 	WordPress Starter-Kit
 *	Description:    Plugin starter-kit for rapid plugin development.
 *	Author:         Jer / aut0poietic
 *	Author URI:     http://irresponsibleart.com
 *	Version: 		0.9.0
 *	Text Domain: 	starter_kit
 *	Domain Path: 	languages/
 */

namespace irresponsible_art\starter_kit ;
require_once( 'features/silence.php') ;

define( 'VERSION' , '0.9.0' );
define( 'PLUGIN_FILE' , __FILE__ );
define( 'PLUGIN_DIR' , plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL' , plugin_dir_url( __FILE__ ) );

require_once( 'features/feature.php' );
require_once( 'features/template.php' );
require_once( 'features/options.php' );
require_once( 'features/class-loader.php' );

/**
 * The central plugin class and bootstrap for the application.
 *
 * While this class is primarily boilerplate code and can be used without alteration,
 * there are a few things you need to edit to get the most out of this kit:
 *  * Add any initialization code that must run *during* the plugins_loaded action in the constructor.
 *  * Edit the return value of the defaults function so that the array contains all your default plugin values.
 *  * Add any plugin activation code to the activate_plugin method.
 *      - If you don't have any activation code, be sure to comment-out register_activation_hook
 *  * Add any plugin deactivation code to the deactivate_plugin method.
 *      - If you don't have any activation code, be sure to comment-out register_deactivation_hook
 * The kit's main class shouldn't need much of your code -- keep your logic in drop-ins so it's ultra portable.
 */
class StarterKit {

	/**
	 * Constructor: Main entry point for your plugin. Runs during the plugins_loaded action.
	 */
	public function __construct() {
		Template::set_path( PLUGIN_DIR . 'assets/templates/' );
		/*
		 Your global initialization code goes here.
		*/
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

	/**
	 * Initializes the plug-in as a singleton.
	 *
	 * This method is the entry-point for the plugin, instantiating the plugin class as well as:
	 *   * Initializing the text domain for the plugin's translations
	 *   * Initializing the template engine
	 *   * Loading all functionality classes
	 *
	 * @static
	 * @hook      plugins_loaded
	 * @do_action starter_kit_init
	 * @return starter_kit
	 */
	private static $__instance;

	public static function init() {
		if ( !self::$__instance ) {
			load_plugin_textdomain( 'starter_kit', FALSE, PLUGIN_DIR . 'languages' );
			self::$__instance = new StarterKit();
			ClassLoader::load_plugin_classes();
			do_action( 'starter_kit_init' );
		}
		return self::$__instance;
	}


	/**
	 * Boiler plate wrapper for the activate_plugin method. Calls upgrade_plugin_options to
	 * ensure your plugins's options data are maintained through upgrades.
	 *
	 * @static
	 */
	public static function _activate_plugin() {
		PluginOptions::upgrade_plugin_options( self::defaults() );
		self::activate_plugin();
	}
} // End Class

//...and away we go!
add_action( 'plugins_loaded', array( 'irresponsible_art\starter_kit\StarterKit', 'init' ) );
register_activation_hook( __FILE__ , array( 'irresponsible_art\starter_kit\StarterKit' , '_activate_plugin' ) ) ;
register_deactivation_hook( __FILE__ , array( 'irresponsible_art\starter_kit\StarterKit' , 'deactivate_plugin' ) ) ;