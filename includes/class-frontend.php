<?php
namespace Title_Change_Action_Scheduler;

class Frontend {
    /**
     * Initialize the frontend hooks.
     */
    public function init() {
        // Enqueue frontend scripts and styles.
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
    }

    /**
     * Enqueue frontend scripts and styles.
     */
    public function enqueue_frontend_scripts() {
        // Enqueue frontend CSS.
        wp_enqueue_style( 'tca-frontend-style', TCA_PLUGIN_URL . 'assets/css/frontend.css', array(), TCA_VERSION );

        // Enqueue frontend JS.
        wp_enqueue_script( 'tca-frontend-script', TCA_PLUGIN_URL . 'assets/js/frontend.js', array( 'jquery' ), TCA_VERSION, true );
    }
}
