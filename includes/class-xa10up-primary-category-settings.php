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
	 * Filters post types.
	 *
	 * @param WP_Post_Type $var Post type to be filtered.
	 *
	 * @return boolean
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 */
	public static function filter_post_types( $var ) {
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
	 * @static
	 */
	public static function template_section_description( $args ) {
		load_template( plugin_dir_path( __FILE__ ) . '../admin/partials/xa10up-primary-category-section-description.php', false, $args );
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
	 * @static
	 */
	public static function filter_taxonomies( $var ) {
		// TODO: Allow the user to select excluded categories.

		$excluded_taxonomies = array(
			'post_tag',
			'post_format',
		);

		return ! in_array( $var->name, $excluded_taxonomies, true );
	}

	/**
	 * Template for taxonomy fields
	 *
	 * @param array $args Array of template arguments.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @static
	 */
	public static function template_post_taxonomies( $args ) {
		load_template( plugin_dir_path( __FILE__ ) . '../admin/partials/xa10up-primary-category-post-taxonomies.php', false, $args );
	}

	/**
	 * Template for settings menu
	 *
	 * @since    1.0.0
	 * @access   public
	 * @static
	 */
	public static function template_settings_menu() {
		load_template( plugin_dir_path( __FILE__ ) . '../admin/partials/xa10up-primary-category-settings-section.php', false );
	}

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
			'xa10up_section_primary_category',
			__( 'Primary Category', 'xa10up' ),
			array(
				'XA10up_Primary_Category_Settings',
				'template_section_description',
			),
			'xa10up-settings'
		);

		// Register fields for post type taxonomies.
		$post_args  = array( 'public' => true );
		$post_types = array_filter(
			get_post_types( $post_args, 'object' ),
			array( 'XA10up_Primary_Category_Settings', 'filter_post_types' )
		);

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $name => $post_type ) {
				$post_type_label = $post_type->label;

				add_settings_field(
					'xa10up_field_' . $name,
					$post_type_label,
					array(
						'XA10up_Primary_Category_Settings',
						'template_post_taxonomies',
					),
					'xa10up-settings',
					'xa10up_section_primary_category',
					array(
						'label_for' => 'xa10up_field_' . $name . '_primary',
						'class'     => 'xa10up_row',
						'post_type' => $post_type,
					)
				);
			}
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
			'xa10up-settings',
			array(
				'XA10up_Primary_Category_Settings',
				'template_settings_menu',
			)
		);
	}
}


