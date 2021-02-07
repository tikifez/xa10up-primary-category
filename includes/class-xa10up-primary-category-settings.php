<?php
/**
 * Manages the settings page for the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    XA10up_Primary_Category
 * @subpackage XA10up_Primary_Category/includes
 */

/**
 * Manages the settings page for the plugin.
 *
 * @package    XA10up_Primary_Category
 * @subpackage XA10up_Primary_Category/includes
 * @author     Your Name <email@example.com>
 */

class XA10up_Primary_Category_Settings {

	/**
	 * Initialize plugin settings
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function init() {
		register_setting( 'xa10up', 'xa10up_options' );

		// Register section.
		add_settings_section(
			'xa10up_section_developers',
			__( 'Primary category', 'xa10up' ),
			array( 'XA10up_Primary_Category_Settings', 'xa10up_section_primary_category_callback' ),
			'xa10up'
		);

		// Register fields for post type taxonomies.
		$post_args  = array( 'public' => true );
		$post_types = array_filter( get_post_types( $post_args, 'object' ), 'filter_post_types' );

		foreach ( $post_types as $name => $post_type ) {
			$post_type_label = $post_type->label;

			add_settings_field(
				'xa10up_field_' . $name,
				__( $post_type_label, 'xa10up' ),
				'xa10up_field_taxonomies_cb',
				'xa10up',
				array( 'XA10up_Primary_Category_Settings', 'primary_category_section_description_template' ),
				array(
					'label_for' => 'xa10up_field_' . $name . '_primary',
					'class'     => 'xa10up_row',
					'post_type' => $post_type,
				)
			);
		}
	}

	/**
	 * Add the top level menu page.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function add_settings_menu() {
		add_menu_page(
			'xa10up',
			'Primary Taxonomies',
			'manage_options',
			'xa10up',
			array( 'XA10up_Primary_Category_Settings', 'template_settings_menu' )
		);
	}

	/**
	 * Filters primary taxonomies.
	 *
	 * @param WP_Taxonomy $var Taxonomy to be filtered.
	 *
	 * @return boolean
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function filter_taxonomies( $var ) {
		// TODO: Allow the user to select excluded categories.

		$excluded_taxonomies = array(
			'category',
			'post_tag',
			'post_format',
		);

		return ! in_array( $var->name, $excluded_taxonomies, true );
	}

	/**
	 * Filters post types.
	 *
	 * @param WP_Post_Type $var Post type to be filtered.
	 *
	 * @return boolean
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function filter_post_types( $var ) {
		$excluded_post_types = array(
			'attachment',
		);

		return ! in_array( $var->name, $excluded_post_types, true );
	}

	/**
	 * Template for section description
	 *
	 * @param array $args Array of template arguments.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function template_section_description( $args ) {
		// TODO: mv this to template file.
		?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Sets the primary taxonomy for post types. The primary category is used for search results.', 'xa10up' ); ?></p>
		<?php
	}

	/**
	 * Template for taxonomy fields
	 *
	 * @param array $args Array of template arguments.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function template_post_taxonomies( $args ) {
		$post_type  = $args['post_type'];
		$options    = get_option( 'xa10up_options' );
		$taxonomies = array_filter( get_object_taxonomies( $post_type->name, 'object' ), 'x10up_filter_taxonomies' );
		?>
        <select
                id="<?php echo esc_attr( $args['label_for'] ); ?>"
                data-custom="<?php echo esc_attr( $args['xa10up_custom_data'] ); ?>"
                name="xa10up_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'none', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'None', 'xa10up' ); ?>
            </option>
			<?php foreach ( $taxonomies as $key => $value ) : ?>
                <option value="<?php echo $key; ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], $key, false ) ) : ( '' ); ?>>
					<?php esc_html_e( $value->labels->singular_name, 'xa10up' ); ?>
                </option>
			<?php endforeach; ?>
        </select>
		<?php
	}

	/**
	 * Template for settings menu
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function template_settings_menu() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'xa10up_messages', 'xa10up_message', __( 'Settings Saved', 'xa10up' ), 'updated' );
		}

		settings_errors( 'xa10up_messages' );
		?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
				<?php
				settings_fields( 'xa10up' );
				do_settings_sections( 'xa10up' );
				submit_button( 'Save Settings' );
				?>
            </form>
        </div>
		<?php
	}
}


