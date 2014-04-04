<?php
namespace irresponsible_art\starter_kit;
require_once( 'silence.php') ;

/**
 * Starter-Kit Options handling
 */
class PluginOptions {

	/**
	 * @var The namespace for all options.
	 */
	public static $option_key = "starter_kit";

	/**
	 * Updates the plug-in's options data to the current version.
	 *
	 * This method checks the currently installed WordPress options and ensures that
	 * the keys in the default options exist and that any unused options stored in the
	 * starter_kit key are deleted.
	 *
	 * @static
	 * @param array array of options or null
	 * @return bool Returns TRUE if the options were saved, FALSE otherwise.
	 * @used-by _activate_plugin
	 */
	public static function upgrade_plugin_options( $defaults = NULL ) {
		$options = get_option( self::$option_key );
		// If this is a new installation, install the defaults.
		if ( $options === FALSE ) {
			$options = $defaults;
		}
		else {
			$options = shortcode_atts( $defaults, $options );
		}
		return update_option( self::$option_key, $options );
	}

	/**
	 * Provides global access to the plug-in's options.
	 * Options are stored as a single array in the database and
	 * this function provides access to the individual keys.
	 *
	 * @static
	 * @param $name string  The key name of the option to retrieve
	 * @param $default mixed Default value returned if the key doesn't exist.
	 * @return mixed
	 */
	public static function get_option( $name , $default ) {
		$options = get_option( self::$option_key );
		if ( is_array( $options ) && array_key_exists( $name, $options ) ) {
			return $options[ $name ];
		}
		return $default;
	}

	/**
	 * Updates the value of a plugin option. Will add the value to the options if it doesn't exist.
	 *
	 * @static
	 * @param $name  string The key name of the option to set
	 * @param $value mixed The new value
	 * @return bool
	 */
	public static function update_option( $name, $value ) {
		$options          = get_option( self::$option_key );
		$options[ $name ] = $value;

		return update_option( self::$option_key, $options );
	}
} // END CLASS