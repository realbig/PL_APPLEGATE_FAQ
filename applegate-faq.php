<?php
/**
 * Plugin Name: Applegate FAQ
 * Description: Creates the "FAQ" custom post type.
 * Author: Joel Worsham
 * Author URI: http://realbigmarketing.com
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Define plugin constants
define( 'AGFAQ_VERSION', '1.0.0' );
define( 'AGFAQ_DIR', plugin_dir_path( __FILE__ ) );
define( 'AGFAQ_URL', plugins_url( '', __FILE__ ) );

/**
 * Class AGFAQ
 *
 * Initiates the plugin.
 *
 * @since   0.1.0
 *
 * @package AGFAQ
 */
class AGFAQ {

	public $faq;

	private function __clone() { }

	private function __wakeup() { }

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @since     0.1.0
	 *
	 * @staticvar Singleton $instance The *Singleton* instances of this class.
	 *
	 * @return AGFAQ The *Singleton* instance.
	 */
	public static function getInstance() {

		static $instance = null;

		if ( null === $instance ) {
			$instance = new static();
		}

		return $instance;
	}

	/**
	 * Initializes the plugin.
	 *
	 * @since 0.1.0
	 */
	protected function __construct() {

		$this->add_base_actions();
		$this->require_necessities();
	}

	/**
	 * Requires necessary base files.
	 *
	 * @since 0.1.0
	 */
	public function require_necessities() {

		require_once __DIR__ . '/core/class-agfaq-faq-cpt.php';
		$this->faq = new AGFAQ_FAQ_CPT();
	}

	/**
	 * Adds global, base functionality actions.
	 *
	 * @since 0.1.0
	 */
	private function add_base_actions() {

		add_action( 'init', array( $this, '_register_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_enqueue_assets' ) );
	}

	/**
	 * Registers the plugin's assets.
	 *
	 * @since 0.1.0
	 */
	function _register_assets() {
	}

	function _enqueue_assets() {
	}
}

require_once __DIR__ . '/core/agfaq-functions.php';
AGFAQ();