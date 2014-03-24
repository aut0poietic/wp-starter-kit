<?php
/*
 * Base Starter Kit Feature Class
 *
 * Base is the parent class for all class-based functionality ( called drop-ins ) you create in the plug-in.
 * The class defines a few helpful functions for making WordPress a bit more class-friendly.
 */
class starter_kit_DropIn
{
	/**
	 * Features registry storage.
	 *
	 * @var array
	 */
	private static $__drop_ins ;

	/**
	 * Registers a loaded class with this parent class. This method is passed as a callable
	 * as the first ( and only ) parameter in the <kbd>starter_kit_init</kbd> action.
	 *
	 * @static
	 * @param $instance Object A class name that was loaded by starter_kit_init
	 */
	public static function register_class( $instance )
	{
		if( ! is_array( self::$__drop_ins ) )
		{
			self::$__drop_ins = array( ) ;
		}
		self::$__drop_ins[ get_class( $instance ) ] = $instance ;
	}

	/**
	 * Takes a method name and creates a php callable array object for use with most
	 * WordPress action or filters.
	 *
	 * @param $method_name string Name of a method within the child class.
	 * @return callable Array that is compatible with call_user_func*.
	 */
	public function marshal( $method_name )
	{
		return array( &$this , $method_name ) ;
	}

	/**
	 * Adds an action-hook to the WordPress application mapping to a method of this class.
	 *
	 * @param string $action ID of the action to subscribe.
	 * @param string $method_name Name of a method within the child class.
	 * @param int $priority Order called; Inherited from WordPress add_action
	 * @param int $accepted_args Number of arguments expected; Inherited from WordPress add_action
	 */
	public function add_action( $action , $method_name , $priority = 10 , $accepted_args = 2 )
	{
		add_action( $action , $this->marshal( $method_name ) , $priority , $accepted_args ) ;
	}

	/**
	 * Adds an filter-hook to the WordPress application mapping to a method of this class.
	 *
	 * @param string $filter ID of the filter to subscribe.
	 * @param string $method_name Name of a method within the child class.
	 * @param int $priority Order called; Inherited from WordPress add_action
	 * @param int $accepted_args Number of arguments expected; Inherited from WordPress add_action
	 */
	public function add_filter( $filter , $method_name , $priority = 10 , $accepted_args = 2 )
	{
		add_filter( $filter , $this->marshal( $method_name ) , $priority , $accepted_args ) ;
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
	public function add_admin_ajax( $action )
	{
		$this->add_action( 'wp_ajax_' . $action , $action ) ;
	}
	/**
	 * Performs the same actions as add_admin_ajax,
	 * only the ajax will be available to both non-users ( client ) and users ( admin ).
	 *
	 * @param string $action The base-name of the action
	 */
	public function add_client_ajax( $action )
	{
		$this->add_admin_ajax( $action ) ;
		$this->add_action( 'wp_ajax_nopriv_' . $action , $action ) ;
	}
} // End Class