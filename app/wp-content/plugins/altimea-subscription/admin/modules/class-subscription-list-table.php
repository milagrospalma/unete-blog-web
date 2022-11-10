<?php

if (!class_exists('WP_List_Table')) {
	require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
}

class blogSubscriptionListTable extends WP_List_Table
{
	private static $instance;

	private $menuSlug;
	/**
	 * Construct
	 */
	public function __construct($menuSlug)
	{
		parent::__construct(array(
			'singular'	=> __('suscriptor', 'altimea-subscription'),
			'plural'	=> __('suscriptores', 'altimea-subscription'),
			'ajax'		=> false
		));

		$this->menuSlug = $menuSlug;
	}

	/**
	 * Get table name
	 *
	 * @return String
	 */
	public static function getTableName()
	{
		return blogSubscriptionModel::getTableName();
	}

	/**
	 * Retrieve data from the table
	 *
	 * @param Int $per_page
	 * @param Int $page_number
	 *
	 * @return mixed
	 */
	public static function get_Data($per_page = 5, $page_number = 1)
	{
		global $wpdb;
		$tableName = self::getTableName();

		$sql = "SELECT * FROM {$tableName} ";
		error_log(print_r($sql,true));

		if (!empty($_REQUEST['orderby'])) {
			$sql .= ' ORDER BY '.esc_sql($_REQUEST['orderby']);
			$sql .= !empty($_REQUEST['order']) ? ' '.esc_sql($_REQUEST['order']) : ' DESC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET '.($page_number - 1) * $per_page;

		$result = $wpdb->get_results($sql, 'ARRAY_A');

		return $result;
	}

	/**
	 * Returns records count
	 *
	 * @return null|string
	 */
	public static function record_count()
	{
		global $wpdb;
		$tableName = self::getTableName();
		$sql = "SELECT COUNT(*) FROM {$tableName}";

		return $wpdb->get_var($sql);
	}

	/**
	 * Method for name column.
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	public function column_name($item)
	{
		// create a nonce
		$delete_nonce = wp_create_nonce('sp_delete_customer');

		$title = '<strong>' . $item['name'] . '</strong>';

		$admin_url = admin_url('admin.php');
		$actions = [
			'delete' => sprintf(
				'<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>',
				$admin_url,
				esc_attr($_REQUEST['page']),
				'delete',
				absint($item['id']),
				$delete_nonce)
		];

		return $title . $this->row_actions($actions);
	}

	/**
	 * Define what data to show on each column of the table.
	 *
	 * @param  array $item        Data
	 * @param  string $column_name - Current column name
	 *
	 * @return mixed
	 */
	public function column_default($item, $column_name)
	{
		switch ($column_name) {
			case 'id':
			case 'email':
			case 'country':
			case 'status':
			case 'date_created':
			return $item[$column_name];
			default:

			return print_r($item, true);
		}
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns()
	{
		$columns = array(
			'cb' => '<input type="checkbox"  />',
			'id' => 'ID',
			'email' => 'Correo',
			'country' => 'Pais',
			'date_created' => 'Fecha de Creación',
		);

		return $columns;
	}

	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns()
	{
		$sortable_columns = array(
			'id' => array('id', false),
			'email' => array('email', false),
			'country' => array('country', false),
			'date_created' => array('date_created', false),
		);

		return $sortable_columns;
	}

	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items()
	{
		$this->_column_headers = $this->get_column_info();

		/* Process bulk action */
		$this->process_bulk_action();

		$per_page = $this->get_items_per_page('customer_per_page', 15);
		$current_page = $this->get_pagenum();
		$sortable = $this->get_sortable_columns();
		$total_items = self::record_count();

		$this->set_pagination_args([
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page' => $per_page, //WE have to determine how many items to show on a page
		]);

		$this->items = self::get_Data($per_page, $current_page);
	}

	/**
	 * show action delete in action selector
	 * @return Array
	 */
	public function get_bulk_actions()
	{
		$actions = array(
			'delete' => 'Delete',
		);

		return $actions;
	}

	/**
	 * Show checkbox in table view
	 * @return String
	 */
	public function column_cb($item)
	{
		return sprintf(
		'<input type="checkbox" name="delete[]" value="%s" />', $item['id']
		);
	}

	/**
	 * Parser url action for: delete
	 * @return Void
	 */
	public function process_bulk_action()
	{
		// If the delete bulk action is triggered
		if ((isset($_POST['action']) && $_POST['action'] == 'delete')
		|| (isset($_POST['action2']) && $_POST['action2'] == 'delete')
		) {
			$delete_ids = esc_sql($_POST['delete']);

			// loop over the array of record IDs and delete them
			foreach ($delete_ids as $id) {
				self::delete_subscriber($id);
			}

			// $arr_params = array('page' => 'asm-id-settings');
			$arr_params = array('page' => $this->menuSlug);
			echo wp_redirect(esc_url(add_query_arg($arr_params)), 301);
			exit;
		}
	}

	/**
	 * Delete subscriber
	 */
	public static function delete_subscriber($id)
	{
		global $wpdb;

		$tableName = self::getTableName();
		$wpdb->delete("{$tableName}", ['ID' => $id], ['%d']);
	}

	public function no_items()
	{
		_e('No se encontrarón registros', 'altimea-subscription');
	}

}
