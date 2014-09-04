<?php
namespace irresponsible_art\starter_kit ;
require_once( 'silence.php' ) ;


class Kit {

	public function __construct() {
		Template::set_path( PLUGIN_DIR . 'assets/templates/' );
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
	 * @return StarterKit
	 */
	public function initialize( ) {
		if( class_exists( 'irresponsible_art\starter_kit\ClassLoader' ) ){
			ClassLoader::load_plugin_classes();
		}
		do_action( 'starter_kit_init' );
	}


	/**
	 * Boiler plate wrapper for the activate_plugin method. Calls upgrade_plugin_options to
	 * ensure your plugins's options data are maintained through upgrades.
	 *
	 * @static
	 */

	
	public static function _activate_plugin() {
		if( class_exists('irresponsible_art\starter_kit\PluginOptions' ) ){
			PluginOptions::upgrade_plugin_options( self::defaults() );
		}
		self::activate_plugin();
	}
}