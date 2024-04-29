<?php
namespace Title_Change_Action_Scheduler;

class Admin {
	/**
	 * Initialize the admin hooks.
	 */
	public function init() {
		// Enqueue admin scripts and styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu_action_schedular' ) );
		add_action( 'srs_schedule_action', array( $this, 'change_title' ) );
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

	public function admin_menu_action_schedular() {
		add_menu_page( __( 'Action Schedular', 'title-change-action-scheduler' ), 
		   __( 'Action Schedular', 'title-change-action-scheduler' ),
		   'manage_options',
		   'cng-title',
			 array( $this, 'menu_callback' ),
		   'dashicons-admin-tools',
		   99
	   );
	}

	public function menu_callback() {
		?>
		<h1>Action Scheduler Demo</h1>
		<?php
		if ( isset( $_GET[ 'action' ] ) && 'add-single' === $_GET[ 'action' ] ) {

			$output = $this->add_single_action();
			?>
			<p><strong>Action output:</strong></p>
			<p>
				<?php
				esc_html_e( $output );
				?>
			</p>
			<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=cng-title">Reset</a>
			<?php
		} else {
			?>
			<p>This page lets an administrator schedule an action. </p>
			<form method="post" action="<?php echo esc_url(add_query_arg('action', 'add-single')); ?>">
			<label for="new_title">New Title:</label>
			<input type="text" id="new_title" name="new_title" required>
			<button type="submit">Schedule Title Change</button>
		</form>
			<?php
			$url = add_query_arg( 'action', 'add-single' );
			?>
		<!-- <li><a href="<?php echo esc_url( $url ); ?>">Add single scheduled action.</a></li> -->
		<?php
		}
	}

	function add_single_action() {
		if (isset($_POST['new_title'])) {
			$new_title = sanitize_text_field($_POST['new_title']);
			$timestamp    = strtotime('+ 2 minutes');
			$hook       = 'srs_schedule_action';
			$args       = array('new_title' => $new_title);
			$group      = '';
			$job_id = as_schedule_single_action($timestamp, $hook, $args, $group);
		}
		return 'Action added with Job ID: ' . $job_id;
	}
	public function change_title($args) {
		if (isset($args['new_title'])) {
			update_option('blogname', $args['new_title']);
		}
	}

}
