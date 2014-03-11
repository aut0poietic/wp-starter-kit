<?php
class xyzPlugin_Branding extends starter_kit_DropIn {

	public function init( $callable = array( ) ){
		if( is_callable( $callable ) && method_exists( $callable[ 0 ] , $callable[ 1 ] ) ){
			call_user_func_array( $callable , array( new self ) ) ;
		}
	}

	public function __construct( ){
		$this->add_action( 'login_head' , 'rebrand_logo' ) ;
	}

	public function rebrand_logo() {
		echo '<style type="text/css">
    	h1 a { background-image: url(http://yourwebsite.com/wp-content/uploads/yourimage.jpg) !important; }
    	</style>';
	}
} // End Class

// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init' , array( 'xyzPlugin_Branding' , 'init'  ) ) ;