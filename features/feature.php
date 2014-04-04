<?php
namespace irresponsible_art\starter_kit;
require_once( 'silence.php' );

/*
	 * Base Starter Kit Feature Class
	 *
	 * Base is the parent class for all class-based functionality you create in the plug-in.
	 * The class defines a few helpful functions for making WordPress a bit more class-friendly.
	 */
class Feature {

	/**
	 * Instantiates the current class and returns an instance.
	 *
	 * @return Current Feature subclass or NULL in PHP < 5.3.
	 * @note If you are using PHP < 5.3 your class will need to implement it's own static init method
	 *       as get_called_class is not supported.
	 * @static
	 */
	public static function init() {
		if ( function_exists( 'get_called_class' ) ) {
			$current_class = get_called_class();
			return new $current_class();
		}
		return NULL;
	}

	/**
	 * Returns a template instance, ready for use.
	 *
	 * @static
	 * @return Template
	 */
	public function get_template() {
		return new Template();
	}

	/**
	 * Retrieves and option value
	 *
	 * @param $name string Name of your option
	 * @param $default mixed Default value returned if the option has not been set.
	 * @return mixed EIther the option value or the default.
	 */
	public function get_option( $name, $default = NULL ) {
		return PluginOptions::get_option( $name, $default );
	}

	/**
	 * Sets a namespace-ed option value.
	 *
	 * @param $name  The name of the option.
	 * @param $value The value you want to store
	 * @return boolean True if option value has changed, false if not or if update failed.
	 */
	public function set_option( $name, $value ) {
		return PluginOptions::update_option( $name, $value );
	}

	/**
	 * Takes a method name and creates a php callable array object for use with most
	 * WordPress action or filters.
	 *
	 * @param $method_name string Name of a method within the child class.
	 * @return callable Array that is compatible with call_user_func*.
	 */
	public function marshal( $method_name ) {
		return array( &$this, $method_name );
	}

	/**
	 * Adds an action-hook to the WordPress application mapping to a method of this class.
	 *
	 * @param string $action        ID of the action to subscribe.
	 * @param string $method_name   Name of a method within the child class.
	 * @param int    $priority      Order called; Inherited from WordPress add_action
	 * @param int    $accepted_args Number of arguments expected; Inherited from WordPress add_action
	 */
	public function add_action( $action, $method_name, $priority = 10, $accepted_args = 2 ) {
		add_action( $action, $this->marshal( $method_name ), $priority, $accepted_args );
	}

	/**
	 * Adds an filter-hook to the WordPress application mapping to a method of this class.
	 *
	 * @param string $filter        ID of the filter to subscribe.
	 * @param string $method_name   Name of a method within the child class.
	 * @param int    $priority      Order called; Inherited from WordPress add_action
	 * @param int    $accepted_args Number of arguments expected; Inherited from WordPress add_action
	 */
	public function add_filter( $filter, $method_name, $priority = 10, $accepted_args = 2 ) {
		add_filter( $filter, $this->marshal( $method_name ), $priority, $accepted_args );
	}

	/**
	 * Makes the provided method name an AJAX-callable method.
	 *
	 * When using this method, developers should create a public class function with
	 * the name specified in the $action parameter. When calling from AJAX, the developer
	 * set an 'action' parameter in their GET/POST set to the name specified in $action.
	 *
	 * @param string $action The base-name of the action
	 */
	public function add_admin_ajax( $action ) {
		$this->add_action( 'wp_ajax_' . $action, $action );
	}

	/**
	 * Performs the same actions as add_admin_ajax,
	 * only the ajax will be available to both non-users ( client ) and users ( admin ).
	 *
	 * @param string $action The base-name of the action
	 */
	public function add_client_ajax( $action ) {
		$this->add_admin_ajax( $action );
		$this->add_action( 'wp_ajax_nopriv_' . $action, $action );
	}
} // End Class