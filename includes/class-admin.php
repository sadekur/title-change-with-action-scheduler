<?php
namespace Title_Change_Action_Scheduler;

class Admin {
    /**
     * Initialize the admin hooks.
     */
    public function init() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_menu', array($this, 'admin_menu_action_schedular'));
        add_action('srs_schedule_action', array($this, 'change_title'));
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_style('tca-admin-style', TCA_PLUGIN_URL . 'assets/css/admin.css', array(), TCA_VERSION);
        wp_enqueue_script('tca-admin-script', TCA_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), TCA_VERSION, true);
    }

    public function admin_menu_action_schedular() {
        add_menu_page(__('Action Scheduler', 'title-change-action-scheduler'),
            __('Action Scheduler', 'title-change-action-scheduler'),
            'manage_options',
            'cng-title',
            array($this, 'menu_callback'),
            'dashicons-admin-tools',
            99
        );
    }

     public function menu_callback() {
    	?>
    	<h1>Action Scheduler Demo</h1>
    	<?php
    	if (isset($_POST['submit']) && check_admin_referer('submit_new_title', 'new_title_nonce')) {
    		$output = $this->add_single_action();
    		echo '<p><strong>Action output:</strong> ' . esc_html($output) . '</p>';
    	}
    	?>
    	<form method="post" action="">
            <?php wp_nonce_field('submit_new_title', 'new_title_nonce'); ?>
            <label for="new_title">New Title:</label>
            <input type="text" id="new_title" name="new_title" required>
            <button type="submit" name="submit">Schedule Title Change</button>
        </form>
    	<a href="<?php echo esc_url(admin_url('admin.php?page=cng-title')); ?>">Reset</a>
    	<?php
    }

   	public function add_single_action() {
		// add action parameters
		if (!empty($_POST['new_title'])) {
	        $new_title = sanitize_text_field($_POST['new_title']);
			$timestamp = strtotime('+2 minutes');
            $hook = 'srs_schedule_action';
            $args = array('new_title' => $new_title);
            $group = '';

			// Action Scheduler API function call
			$job_id = as_schedule_single_action( $timestamp, $hook, $args, $group );
			return 'Action added with Job ID: ' . $job_id;
		}
	        return 'No new title provided.';
	}

     public function change_title($args) {
        if (!empty($args['new_title']) && get_option('blogname') !== $args['new_title']) {
            update_option('blogname', $args['new_title']);
        }
    }
}
