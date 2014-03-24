<?php
/**
 * Template Class
 *
 * The Template class provides painfully simple php template processing
 * for any process that needs to output HTML.
 *
 * This class should only be instantiated by the main plug-in class and by convention
 * can accessed using starter_kit::template( ).
 *
 */
class starter_kit_Template {

	/**
	 * @var string Path to template directory.
	 */
	private $template_path ;

	/**
	 * @var array Temporary variable storage.
	 */
	private $vars ;

	/**
	 * Constructor.
	 * @param string $path Path to the directory containing the template files.
	 */
	public function __construct( $path = NULL )
	{
		$this->set_path( $path );
		$this->vars = array();
	}

	/**
	 * Sets the default path for all template files.
	 * @param $path string Path to the directory containing the template files.
	 */
	public function set_path( $path )
	{
		$this->template_path = $path ;
	}

	/**
	 * Clears the internal variable storage.
	 */
	public function clear( )
	{
		$this->vars = array( ) ;
	}

	/**
	 * Sets a single variable for use in the template file.
	 * @param $name string Name of the variable as it is used in the template.
	 * @param $value mixed Value o the variable.
	 */
	public function set( $name , $value )
	{
		$this->vars[ $name ] = $value ;
	}

	/**
	 * Sets multiple variables for use in the template file.
	 * @param array $pairs A set of name => value pairs to be applied to the template.
	 * @param bool $append If set to true, this method will add the provided $pairs existing variables;
	 * false replaces all existing variables. The default is true.
	 */
	public function set_vars( $pairs , $append = true )
	{
		if( is_array( $pairs ) )
		{
			if( $append && is_array( $this->vars ) )
			{
				$this->vars = array_merge( $this->vars , $pairs ) ;
			}
			else
			{
				$this->vars = $pairs ;
			}
		}
	}

	/**
	 * Applies all variables in temporary storage to the supplied template file.
	 * The second, optional parameter allows you to specify a complete path to the template file.
	 * @param $file string Name of the file.
	 * @param bool $use_default_path If false, the $file parameter must be a fully-qualified path ( not a url ).
	 * @return string The rendered template file contents.
	 */
	public function apply( $file , $use_default_path = true )
	{
		extract( $this->vars ) ;

		ob_start( ) ;
		if( $use_default_path == TRUE )
		{
			include( $this->template_path . $file ) ;
		}
		else
		{
			include( $file ) ;
		}
		$contents = ob_get_contents( ) ;
		ob_end_clean( ) ;

		$this->clear( ) ;
		return $contents ;
	}
} // END CLASS
