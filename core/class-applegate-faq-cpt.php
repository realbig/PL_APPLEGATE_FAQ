<?php
/**
 * Creates and manages the FAQ CPT.
 *
 * @since      0.1.0
 *
 * @package    ApplegateFAQ
 * @subpackage ApplegateFAQ/core
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class APPLEGATE_FAQ_CPT {

	private $post_type = 'faq';
	private $label_singular = 'FAQ';
	private $label_plural = 'FAQs';
	private $icon = 'format-status';

	private $meta_fields = array(
		'applegate_buckets',
	);

	function __construct() {

		$this->add_actions();
	}

	private function add_actions() {

		add_action( 'init', array( $this, '_create_cpt' ) );
		add_filter( 'post_updated_messages', array( $this, '_post_messages' ) );
		add_action( 'add_meta_boxes', array( $this, '_add_meta_boxes' ), 100 );
		add_action( 'save_post', array( $this, '_save_meta' ) );
	}

	function _create_cpt() {

		$labels = array(
			'name'               => $this->label_plural,
			'singular_name'      => $this->label_singular,
			'menu_name'          => $this->label_plural,
			'name_admin_bar'     => $this->label_singular,
			'add_new'            => "Add New",
			'add_new_item'       => "Add New $this->label_singular",
			'new_item'           => "New $this->label_singular",
			'edit_item'          => "Edit $this->label_singular",
			'view_item'          => "View $this->label_singular",
			'all_items'          => "All $this->label_plural",
			'search_items'       => "Search $this->label_plural",
			'parent_item_colon'  => "Parent $this->label_plural:",
			'not_found'          => "No $this->label_plural found.",
			'not_found_in_trash' => "No $this->label_plural found in Trash.",
		);

		$args = array(
			'labels'             => $labels,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'menu_icon'          => 'dashicons-' . $this->icon,
			'rewrite' => array(
				'slug' => 'faqs',
			),
			'menu_position' => 58.2,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor' ),
		);

		register_post_type( $this->post_type, $args );
	}

	function _post_messages( $messages ) {

		$post             = get_post();
		$post_type_object = get_post_type_object( $this->post_type );

		$messages[ $this->post_type ] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => "$this->label_singular updated.",
			2  => 'Custom field updated.',
			3  => 'Custom field deleted.',
			4  => "$this->label_singular updated.",
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? "$this->label_singular restored to revision from " . wp_post_revision_title( (int) $_GET['revision'], false ) : false,
			6  => "$this->label_singular published.",
			7  => "$this->label_singular saved.",
			8  => "$this->label_singular submitted.",
			9  => "$this->label_singular scheduled for: <strong>" . date( 'M j, Y @ G:i', strtotime( $post->post_date ) ) . '</strong>.',
			10 => "$this->label_singular draft updated.",
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), "View $this->label_singular" );
			$messages[ $this->post_type ][1] .= $view_link;
			$messages[ $this->post_type ][6] .= $view_link;
			$messages[ $this->post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link      = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), "Preview $this->label_singular" );
			$messages[ $this->post_type ][8] .= $preview_link;
			$messages[ $this->post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	function _add_meta_boxes() {

		add_meta_box(
			'bucket',
			'Buckets',
			array( $this, '_bucket_mb' ),
			'faq',
			'side'
		);
	}

	function _bucket_mb( $post ) {

		wp_nonce_field( 'applegate_save_product', 'applegate_product_nonce' );

		$buckets = get_post_meta( $post->ID, 'applegate_buckets', true );

		if ( function_exists( 'get_buckets' ) ) {
			foreach ( get_buckets() as $bucket_ID => $bucket ) {
				?>
				<label>
					<input type="checkbox" name="applegate_buckets[]" value="<?php echo $bucket_ID; ?>"
						<?php echo in_array( $bucket_ID, $buckets ) ? 'checked' : ''; ?> />
					<?php echo $bucket['title']; ?>
				</label>
				<br/>
				<?php
			}
		}
	}

	function _save_meta( $post_ID ) {

		if ( ! isset( $_POST['applegate_product_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['applegate_product_nonce'], 'applegate_save_product' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_page', $post_ID ) ) {
			return;
		}

		foreach ( $this->meta_fields as $field ) {

			if ( ! isset( $_POST[ $field ] ) || empty( $_POST[ $field ] ) ) {
				delete_post_meta( $post_ID, $field );
			}

			update_post_meta( $post_ID, $field, $_POST[ $field ] );
		}
	}
}