<?php
include starter_kit_PLUGIN_DIR . '/__inc/geek_caller_rejection.php' ;

/**
 *  
 */
class starter_kit_Home extends starter_kit_DropIn {

	public function init( $callable = array( ) )
	{
		if( is_callable( $callable ) && method_exists( $callable[ 0 ] , $callable[ 1 ] ) )
		{
			call_user_func_array( $callable , array( new starter_kit_Home ) ) ;
		}
	}

	public function __construct( )
	{
		add_shortcode( 'home' , $this->marshal( 'do_home_shortcode' ) ) ;
	}

	public function do_home_shortcode( $atts , $content = null , $code = '' )
	{
		return sprintf(
			'<a class="booking-link" href="%1$s"><span class="booking-inner">%2$s</span></a>' ,
			site_url( ) ,
			$content
		) ;
	}
} // End Class

// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init' , array( 'starter_kit_Home' , 'init'  )  , 1 ,  1 ) ;