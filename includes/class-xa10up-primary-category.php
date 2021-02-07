<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both
 * the public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    XA10up_Primary_Category
 * @subpackage XA10up_Primary_Category/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    XA10up_Primary_Category
 * @subpackage XA10up_Primary_Category/includes
 * @author     Xristopher Anderton <xris@ink.fish>
 */
class XA10up_Primary_Category {

	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      XA10up_Primary_Category_Loader $loader Maintains and registers
	 *           all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this
	 *           plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout
	 * the plugin. Load the dependencies, define the locale, and set the hooks
	 * for the admin area and the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'xa10up-primary-category';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_action( 'init', 'xa10up_post_type_review' );
		add_action( 'init', 'xa10up_register_taxonomy_genre' );
		add_action( 'init', 'xa10up_register_taxonomy_studio' );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - XA10up_Primary_Category_Loader. Orchestrates the hooks of the plugin.
	 * - XA10up_Primary_Category_i18n. Defines internationalization
	 * functionality.
	 * - XA10up_Primary_Category_Admin. Defines all hooks for the admin area.
	 * - XA10up_Primary_Category_Public. Defines all hooks for the public side
	 * of the site.
	 *
	 * Create an instance of the loader which will be used to register the
	 * hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Post type for reviews
		 */
		require_once plugin_dir_path( __FILE__ ) . 'post-type-review.php';

		/**
		 * Taxonomy for genre
		 */
		require_once plugin_dir_path( __FILE__ ) . 'taxonomy-genre.php';

		/**
		 * Taxonomy for studio
		 */
		require_once plugin_dir_path( __FILE__ ) . 'taxonomy-studio.php';

		/**
		 * The class responsible for adding taxonomies to search results
		 */
		require_once plugin_dir_path( __FILE__ ) . 'class-xa10up-primary-category-search.php';


		/**
		 * The class responsible for the plugin settings page.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'class-xa10up-primary-category-settings.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xa10up-primary-category-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xa10up-primary-category-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the
		 * admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-xa10up-primary-category-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-xa10up-primary-category-public.php';

		$this->loader = new XA10up_Primary_Category_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the XA10up_Primary_Category_i18n class in order to set the domain
	 * and to register the hook with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new XA10up_Primary_Category_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new XA10up_Primary_Category_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$plugin_settings = new XA10up_Primary_Category_Settings();

		$this->loader->add_action( 'admin_init', $plugin_settings, 'init' );
		$this->loader->add_action( 'admin_menu', $plugin_settings, 'add_settings_menu' );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		// Add assets.
		$plugin_public = new XA10up_Primary_Category_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Add search results.
		$plugin_search = new XA10up_Primary_Category_Search();

		$this->loader->add_action( 'init', $plugin_search, 'add_taxonomies' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    XA10up_Primary_Category_Loader    Orchestrates the hooks of
	 *                                              the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

}
