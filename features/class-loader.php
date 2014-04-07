<?php
namespace irresponsible_art\starter_kit;
require_once( 'silence.php' );

/**
 * ClassLoader Class
 *
 * This class uses functionality originally found within the Jetpack plugin, and uses
 * similar methods to include classes based on their location.
 * Classes are loaded from one of three folders:
 *   * features/core   - Core functionality that must be loaded. Always loaded first
 *   * features/admin  - Classes that should be loaded for the WordPress Admin/Dashboard only.
 *   * features/client - Classes that are only used during rendering of the client only.
 */
class ClassLoader {
	/**
	 * Loads plugin functionality classes appropriate for the current view-state.
	 */
	public function load_plugin_classes() {
		$load_list = array();
		$load_list = array_merge( $load_list, self::glob_php( PLUGIN_DIR . 'features/core' ) );

		if ( is_admin() ) {
			$load_list = array_merge( $load_list, self::glob_php( PLUGIN_DIR . 'features/admin' ) );
		}
		else {
			$load_list = array_merge( $load_list, self::glob_php( PLUGIN_DIR . 'features/client' ) );
		}
		foreach ( $load_list as $file ) {
			include $file;
		}
	}

	/**
	 * Returns an array of all PHP files in the specified directory path.
	 *
	 * Shamelessly borrowed from the Automattic's Jetpack plug-in
	 * and re-purposed for my nefarious schemes.
	 *
	 * @static
	 * @param string $absolute_path The absolute path of the directory to search.
	 * @return array Array of absolute paths to the PHP files.
	 */
	private static function glob_php( $absolute_path ) {
		$absolute_path = untrailingslashit( $absolute_path );
		$files         = array();
		if ( !$dir = @opendir( $absolute_path ) ) {
			return $files;
		}

		while ( FALSE !== $file = readdir( $dir ) ) {
			if ( '.' == substr( $file, 0, 1 ) || '.php' != substr( $file, -4 ) ) {
				continue;
			}

			$file = "$absolute_path/$file";

			if ( !is_file( $file ) ) {
				continue;
			}

			$files[ ] = $file;
		}

		closedir( $dir );

		return $files;
	}
}

