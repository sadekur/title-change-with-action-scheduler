<?php
/**
 * Plugin Name: Title Change Action Scheduler
 * Description: This plugin allows scheduling actions to change titles.
 * Version: 1.0
 * Author: SRS
 * Requires Plugins: woocommerce
 * Author URI: http://srs.com
 * Text Domain: title-change-action-scheduler
 * Domain Path: /languages
 */

namespace Title_Change_Action_Scheduler;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Plugin {
    /**
     * The single instance of this class.
     *
     * @var Plugin
     */
    private static $instance;

    /**
     * Plugin version.
     *
     * @var string
     */
    private $version = '1.0';

    /**
     * Get the single instance of this class.
     *
     * @return Plugin Instance.
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        $this->define_constants();
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Define plugin constants.
     */
    private function define_constants() {
        define( 'TCA_VERSION', $this->version );
        define( 'TCA_PLUGIN_FILE', __FILE__ );
        define( 'TCA_PLUGIN_DIR', plugin_dir_path( TCA_PLUGIN_FILE ) );
        define( 'TCA_PLUGIN_URL', plugin_dir_url( TCA_PLUGIN_FILE ) );
    }

    /**
     * Load plugin dependencies.
     */
    private function load_dependencies() {
        // Load admin class.
        require_once TCA_PLUGIN_DIR . 'includes/class-admin.php';

        // Load frontend class.
        require_once TCA_PLUGIN_DIR . 'includes/class-frontend.php';

    }

    /**
     * Initialize hooks.
     */
    private function init_hooks() {
        $admin = new Admin();
        $admin->init();

        $frontend = new Frontend();
        $frontend->init();
    }
}

// Initialize the plugin.
Plugin::get_instance();
