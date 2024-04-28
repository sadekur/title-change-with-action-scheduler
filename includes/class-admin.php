<?php
namespace Title_Change_Action_Scheduler;

class Admin {
    /**
     * Initialize the admin hooks.
     */
    public function init() {
        // Enqueue admin scripts and styles.
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function enqueue_admin_scripts() {
        // Enqueue admin CSS.
        wp_enqueue_style( 'tca-admin-style', TCA_PLUGIN_URL . 'assets/css/admin.css', array(), TCA_VERSION );

        // Enqueue admin JS.
        wp_enqueue_script( 'tca-admin-script', TCA_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), TCA_VERSION, true );
    }
}
