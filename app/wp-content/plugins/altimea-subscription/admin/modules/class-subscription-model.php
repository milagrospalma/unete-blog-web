<?php

class blogSubscriptionModel {

	private static $instance;
	private $keyNameVersion;
	private $dbversion;

	public function __construct()
	{
 		self::$instance = $this;
 		$this->keyNameVersion = 'dbversion';
 		$this->dbversion = '2.0';
 	}

	/**
	 * Get Unique instance of the object
	 *
	 * @return Object
	 */
	public static function getInstance()
	{
		 if (!isset(self::$instance)) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get table name
	 *
	 * @return String
	 */
	public static function getTableName()
	{
		global $wpdb;
		$tableName = "{$wpdb->prefix}subscription";

		return $tableName;
	}

	/**
	 * Create table 'install'
	 *
	 * @param Boolean $networkwide status multisite
	 *
	 *@return Void
	 */
	public function install($networkwide)
	{
		global $wpdb;

		if (function_exists('is_multisite') && is_multisite()) {
			// check if it is a network activation - if so, run the activation function for each blog id
			if ($networkwide) {
				$old_blog = $wpdb->blogid;
				// Get all blog ids
				$blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");

				foreach ($blogids as $blog_id) {
					switch_to_blog($blog_id);
					$this->_activate();
				}

				switch_to_blog($old_blog);
				return;
			}
		}

		$this->_activate();
	}

	/**
	 * Delete table
	 * @return Void
	 */
	public function uninstall($networkwide)
	{
		global $wpdb;

		if (function_exists('is_multisite') && is_multisite()) {
			// check if it is a network activation - if so, run the activation function for each blog id
			if ($networkwide) {
				$old_blog = $wpdb->blogid;
				// Get all blog ids
				$blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
				foreach ($blogids as $blog_id) {
					switch_to_blog($blog_id);
					$this->_activateForDelete();
				}

				switch_to_blog($old_blog);
				return;
			}
		}

		$this->_activateForDelete();
	}

	/**
	 * Check if exist the table else created there
	 * @return Void
	 */
	private function _activate()
	{
		global $wpdb;

		$tableName = self::getTableName();
		if ($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") != $tableName) {
			$this->_createTable($tableName);
		}
	}

	/**
	 * Check if exits the table and delete there
	 * @return Void
	 */
	private function _activateForDelete()
	{
		global $wpdb;

		$tableName = self::getTableName();
		if ($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") == $tableName) {
			$this->_deleteTable($tableName);
		}
	}

	/**
	 * Create table
	 */
	private function _createTable($tableName)
	{
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		if (!empty ($wpdb->charset))
			$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";

		if (!empty ($wpdb->collate))
			$charset_collate .= " COLLATE {$wpdb->collate}";

		$sql = "CREATE TABLE {$tableName} (
			`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`email` varchar(40) NOT NULL UNIQUE,
			`country` varchar(5) NOT NULL,
			`origin` varchar(50) NULL,
			`data` text,
			`date_created` datetime NULL,
			INDEX index_origin (origin),
			INDEX index_email (email)
		) {$charset_collate};";

		require_once ABSPATH.'wp-admin/includes/upgrade.php';
		dbDelta($sql);

		// add table version
		update_option($this->keyNameVersion, $this->dbversion);
	}

	/**
	 * Delete tables
	 * @return Void
	 */
	private function _deleteTable()
	{
		global $wpdb;
		$tableName = self::getTableName();
		$wpdb->query("DROP TABLE {$tableName}");
	}

	/**
	 * Update status suscriber to '1', Search user by hashMD5
	 *
	 * @param String $hashMd5 md5 String
	 *
	 * @return Boolean|String return False if the suscriber is already
	 * suscribed and actived else return email
	 */
	public function findAndUpdateSuscriptor($hashMd5)
	{
		global $wpdb;
		$rs = false;

		$table = self::getTableName();
		$countData = $wpdb->get_var($wpdb->prepare(
			"SELECT count(id) FROM $table WHERE status=0;",
			$hashMd5
		));

		if ($countData == 1) {
			$dateNow = date('Y-m-d H:i:s');
			$result = $wpdb->get_var($wpdb->prepare(
				"UPDATE $table SET status=1 WHERE status=0;",
				$dateNow,
				$hashMd5
			));
			// getData
			$dataObj = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT id, email FROM $table WHERE status=1 AND;",
					$hashMd5
				),
				ARRAY_A
			);

			if (is_array($dataObj) && !empty($dataObj[0]['email'])) {
				$rs = $dataObj[0]['email'];
			}
		}

		return $rs;
	}

	/**
	* Get status Boolean if user exist
	*
	* @param String  $email user email
	*
	* @return Booleam
	*/
	static function asm_existUserSearchByEmail($email)
	{
		global $wpdb;
		$rs = false;

		$table = self::getTableName();
		$email = sanitize_email($email);
		$rsData = $wpdb->get_row("SELECT id FROM {$table} WHERE email = '$email' LIMIT 1", ARRAY_A);
		if (is_array($rsData) && count($rsData) > 0) {
			$rs = true;
		}

		return $rs;
	}

	/**
	 * Register users as suscribers
	 * only if not exit user register yet.
	 *
	 * @param Array $paramData multiple args
	 *
	 * @return Booleam
	 */
	static function insertSubscription($paramData)
	{
		global $wpdb;
		$rsValues[0]['status'] = false;
		$rsValues[0]['error'] = '100';
		$rsValues[0]['message'] = __('Información no valida', 'altimea-subscription');

		$rsValues[1]['status'] = false;
		$rsValues[1]['error'] = '101';
		$rsValues[1]['message'] = __('Este correo ya ha sido registrado', 'altimea-subscription');

		$rsValues[2]['status'] = true;
		$rsValues[2]['error'] = '';
		$rsValues[2]['message'] = __('Información insertada correctamente.', 'altimea-subscription');

		$rsValues[3]['status'] = false;
		$rsValues[3]['error'] = '100';
		$rsValues[3]['message'] = __('Información no valida', 'altimea-subscription');

		extract($paramData);
		$rs = $rsValues[0];

		if (
			isset($email) &&
			isset($country) &&
			isset($data) &&
			isset($origin)
		) {
			// insert users
			if (self::asm_existUserSearchByEmail($email) === false) {
				$table_name = self::getTableName();
				$dateNow = date('Y-m-d H:i:s');

				$wpdb->insert(
					$table_name,
					array(
						'email' => strtolower($email),
						'country' => $country,
						'date_created' => $dateNow,
						'origin' => $origin,
						'data' => is_array($data) ? json_encode($data) : ''
					),
					array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
				);

				if ($wpdb->insert_id > 0) { // success response
					$rs = $rsValues[2];
				} else {
					$rs = $rsValues[3];
				}
			} else {
				$rs = $rsValues[1];
			}
		}

		return $rs;
	}

	/**
	 * Get user information by email
	 *
	 * @param String $email
	 * @param Boolean $stringJsonToArray Status for return the field 'data' in array
	 *
	 * @return Array|NULL
	 */
	public function asm_getUserByEmail($email, $stringJsonToArray = false)
	{
		global $wpdb;
		$rs = false;

		$tableName = self::getTableName();
		$email = sanitize_email($email);
		$rs = $wpdb->get_row("SELECT * FROM {$tableName} WHERE email = '$email' LIMIT 1", ARRAY_A);

		if (is_array($rs) && count($rs) > 0) {
			if ($stringJsonToArray == true) {
				$rs['data'] = json_decode($rs['data'], true);
			}
		}

		return $rs;
	}

	/**
	 * Get data users
	 *
	 * @param String $orderby
	 * @param Booleam $verifiedUser
	 */
	public static function asm_getDataUsersArray($orderby = 'ASC', $verifiedUser = '')
	{
		global $wpdb;
		$table = self::getTableName();

		// filter where
		$where = '';
		if ($verifiedUser === true) {
			$where .= 'WHERE status=1';
		} elseif ($verifiedUser === false) {
			$where .= 'WHERE status=0';
		}

		// only this values
		if ($orderby != 'ASC' || $orderby != 'DESC') {
			$orderby = 'ASC';
		}

		//sql
		$sql = "SELECT * FROM {$table} {$where} ORDER BY id {$orderby}";
		$result = $wpdb->get_results($sql, 'ARRAY_A');

		return $result;
	}

	/**
	 * update table
	 * @return Void
	 */
	public function updateTable()
	{
		global $wpdb;
		$tableName = self::getTableName();
		$installed_ver = get_option($this->keyNameVersion);

		if ($installed_ver != $this->dbversion) {
			$charset_collate = $wpdb->get_charset_collate();

			if (!empty ($wpdb->charset))
				$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";

			if (!empty ($wpdb->collate))
				$charset_collate .= " COLLATE {$wpdb->collate}";

			// add sql here
			$sql = "";

			require_once ABSPATH.'wp-admin/includes/upgrade.php';
			dbDelta($sql);

			// add table version
			update_option($this->keyNameVersion, $this->dbversion);
		}
	}

}
