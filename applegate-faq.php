<?php
/**
 * Plugin Name: Applegate FAQ
 * Description: Creates the "FAQ" custom post type.
 * Author: Joel Worsham
 * Author URI: http://realbigmarketing.com
 * Version: 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Define plugin constants
define( 'APPLEGATE_FAQ_VERSION', '1.0.2' );
define( 'APPLEGATE_FAQ_DIR', plugin_dir_path( __FILE__ ) );
define( 'APPLEGATE_FAQ_URL', plugins_url( '', __FILE__ ) );

/**
 * Class APPLEGATE_FAQ
 *
 * Initiates the plugin.
 *
 * @since   0.1.0
 *
 * @package ApplegateFAQ
 */
class APPLEGATE_FAQ {

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
	 * @return APPLEGATE_FAQ The *Singleton* instance.
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

		require_once __DIR__ . '/core/class-applegate-faq-cpt.php';
		$this->faq = new APPLEGATE_FAQ_CPT();
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
APPLEGATE_FAQ();