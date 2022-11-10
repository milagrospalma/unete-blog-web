<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    blogSubscription
 * @subpackage blogSubscription/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    blogSubscription
 * @subpackage blogSubscription/admin
 * @author     Altimea <apps@altimea.com>
 */
class blogSubscriptionAdmin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $subscription    The ID of this plugin.
	 */
	private $subscription;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $blog_list_subscription_table;

	const KEY_SUBSCRIPTION_PAGE = 'blog-page-subscription';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $subscription       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $subscription, $version ) {

		$this->subscription = $subscription;
		$this->version = $version;
		$this->blog_list_subscription_table = false;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in blogSubscriptionLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The blogSubscriptionLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->subscription, plugin_dir_url( __FILE__ ) . 'css/subscription-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in blogSubscriptionLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The blogSubscriptionLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->subscription, plugin_dir_url( __FILE__ ) . 'js/subscription-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function blog_options_pages() {

		$hook = add_menu_page(
			__('Suscripciones', 'altimea-subscription'),
			__('Suscripciones', 'altimea-subscription'),
			'manage_options',
			self::KEY_SUBSCRIPTION_PAGE . "-list",
			array($this, 'blog_page_subscriptions'),
			'dashicons-buddicons-buddypress-logo',
			70
		);
		add_action("load-{$hook}", array($this, 'blog_screen_option'));
	}

	/**
	 * Add screen option to current config page
	 * @return Void
	 */
	public function blog_screen_option()
	{
		$args = [
			'label'		=> __('Suscripciones'),
			'default'	=> 5,
			'option'	=> 'customer_per_page',
		];
		add_screen_option('per_page', $args);
		$this->blog_list_subscription_table = new blogSubscriptionListTable(self::KEY_SUBSCRIPTION_PAGE);
	}

	/**
	 * Show Subscribers
	 */
	public function blog_page_subscriptions()
	{
		$this->blog_list_subscription_table->prepare_items();
		require_once plugin_dir_path(__FILE__) . 'partials/subscription-admin-display.php';
	}

	/**
	 * Export CSV
	 */
	public function blog_export_csv()
	{
		if ( current_user_can( 'manage_options' )
			&& isset( $_POST['export-all-subscription-csv'] )
			&& ! empty( $_POST['export-all-subscription-csv'] )
			&& is_string( $_POST['export-all-subscription-csv'] ) ) {

			$date = date('d_m_Y');
			$filename = "subscription_{$date}.csv";

			$export = new blogSubscriptionExport();
			$items = $export->get_all_subscription();

			if ( is_array( $items ) && ! empty( $items ) ) {
				$csv = $export->format_report_to_string_csv( $items );

				if ( is_string( $csv ) && ! empty( $csv ) ) {
					$export->export_csv( $csv, $filename );
				}
			}
		}
	}

}
