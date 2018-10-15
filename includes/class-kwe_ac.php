<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       facebook.com/moicsmarkez
 * @since      1.0.0
 *
 * @package    Kwe_ac
 * @subpackage Kwe_ac/includes
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
 * @package    Kwe_ac
 * @subpackage Kwe_ac/includes
 * @author     moicsmarkez <moicsmarkez@yahoo.com>
 */
class Kwe_ac {

    /**
     * @var Singleton The reference the *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone() {
        
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup() {
        
    }

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Kwe_ac_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    protected function __construct() {
        if (defined('KWE_AC_VERSION')) {
            $this->version = KWE_AC_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'kwe_ac';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Kwe_ac_Loader. Orchestrates the hooks of the plugin.
     * - Kwe_ac_i18n. Defines internationalization functionality.
     * - Kwe_ac_Admin. Defines all hooks for the admin area.
     * - Kwe_ac_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-kwe_ac-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-kwe_ac-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-kwe_ac-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-kwe_ac-public.php';

        $this->loader = new Kwe_ac_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Kwe_ac_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Kwe_ac_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Kwe_ac_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'menu_admin');
        $this->loader->add_action( 'wp_ajax_saved_api_settings_and_events', $plugin_admin ,'guardar_opciones_api_and_events');	
        $this->loader->add_action( 'wp_ajax_remove_envt_kwe_ac', $plugin_admin ,'eliminar_evento');	
        $this->loader->add_action( 'wp_ajax_remove_video_kwe_ac', $plugin_admin ,'eliminar_video');	
        $this->loader->add_action( 'init', $plugin_admin, 'capturar_hash');

        $this->loader->add_action( 'admin_head',$plugin_admin, 'kwe_ac_shortcode_button' );
        $this->loader->add_action( 'wp_ajax_ac_check', $plugin_admin, 'ac_check' ); 
    }

    

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Kwe_ac_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action( 'wp_ajax_nopriv_ac_event', $plugin_public, 'ac_event' );
        $this->loader->add_action( 'wp_ajax_ac_event', $plugin_public, 'ac_event' );
        $this->loader->add_action( 'wp_ajax_nopriv_ac_videos_tag', $plugin_public, 'ac_add_tag' );
        $this->loader->add_action( 'wp_ajax_ac_videos_tag', $plugin_public, 'ac_add_tag' );
        
        add_shortcode( 'AC_%FULLNAME%', array( $plugin_public,'kwe_ac_shortc_fullname') );	
        add_shortcode( 'AC_%EMAIL%', array( $plugin_public,'kwe_ac_shortc_email') );	
        add_shortcode( 'AC_%FIRSTNAME%', array( $plugin_public,'kwe_ac_shortc_firstname') );	
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
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Kwe_ac_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
