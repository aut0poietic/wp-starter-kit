<?php
namespace irresponsible_art\starter_kit;

class LoginBranding extends Feature {

	public function __construct() {
		$this->add_filter( 'login_message', 'plugin_login_message' );
		$this->add_action( 'login_enqueue_scripts', 'enqueue_login_scripts' );
	}

	public function plugin_login_message( $message ) {
		// Because this is a stupid example, we don't want to break any
		// *real* messaging that may be happening when this runs.
		if ( empty( $message ) ) {
			$template = $this->get_template();
			$template->set( 'plugin_name', $this->get_option( 'plugin_name', 'Starter Kit' ) );
			$message = $template->apply( 'login-message.php' );
		}
		return $message;
	}

	public function enqueue_login_scripts() {
		wp_enqueue_style( 'starter_kit_rebrand', PLUGIN_URL . 'assets/css/rebrand.css'  );
		wp_enqueue_script( 'starter_kit_rebrand', PLUGIN_URL . 'assets/js/rebrand.min.js', array('jquery') );
	}

} // End Class

// Subscribe to the drop-in to the initialization event
add_action( 'starter_kit_init', array( 'irresponsible_art\starter_kit\LoginBranding', 'init' ) );