<?php

if ( ! class_exists( 'AltimeaSubscription_CSV' ) ) :
	/**
	 * Fired during plugin activation
	 *
	 * @link       http://www.altimea.com
	 * @since      1.0.0
	 *
	 * @package    AltimeaSubscription
	 * @subpackage AltimeaSubscription/admin/includes
	 */

	/**
	 * Fired during plugin activation.
	 *
	 * This class defines all code necessary for generate CSV files.
	 *
	 * @package    AltimeaSubscription
	 * @subpackage AltimeaSubscription/admin/includes
	 * @author     Altimea <apps@altimea.com>
	 */
	Class blogSubscriptionExport {

		/**
		 * Order by
		 *
		 * @var string
		 */
		private $orderby;

		/**
		 * Where
		 *
		 * @var string
		 */
		private $where;


		/**
		 * AltimeaSubscription_CSV constructor.
		 */
		public function __construct( $orderby = 'ASC', $user_verify = null )
		{
			// filter where
			if ($user_verify === true) {
				$this->where = 'WHERE status=1';
			} elseif ($user_verify === false) {
				$this->where = 'WHERE status=0';
			} else {
				$this->where = '';
			}

			// only this values
			if ($orderby === 'ASC' || $orderby === 'DESC') {
				$this->orderby = $orderby;
			}
		}

		/**
		 * Get subscriptions by country
		 *
		 * @param WP_Site|int $site
		 * @return array
		 */
		public function get_subscriptions_by_country()
		{
			global $wpdb;

			/** @var $site WP_Site */
			$prefix = $wpdb->prefix;

			$table = "{$prefix}subscription";
			$site = [];
			$results = $wpdb->get_results(
				"
				SELECT * FROM {$table}
				{$this->where} 
				ORDER BY id {$this->orderby}
			",
				ARRAY_A
			);


			if ( ! empty( $results) )
			{
				return array_map(function ( $result ) use ( $site ) {
					if ( isset( $result['data'] ) ) {
						$questions_data = json_decode( $result['data'], true );

						if ( ! isset( $questions_data['country'] ) || empty( $questions_data['country'] ) ) {

							$country_iso = get_option( 'siteurl' );
							$country_iso = str_replace( '/', '', $country_iso );

							$questions_data['country'] = esc_html( $country_iso );
						}

						$result['data'] = json_encode($questions_data);
					}

					return $result;
				}, $results);

			}
			else
			{
				return array();
			}
		}

		/**
		 * Get all subscription
		 *
		 * @return array
		 */
		public function get_all_subscription()
		{
			$items = array();

			$results = $this->get_subscriptions_by_country();
			$items = array_merge( $items, $results );

			return $items;
		}

		/**
		 * Format report to string csv
		 *
		 * @param array $data user information
		 *
		 * @return String
		 */
		public function format_report_to_string_csv( $data )
		{
			global $countryIso;

			$csv_output = '';
			$result = array(
				'Id',
				'Email',
				'Country',
				'Origen',
				'Fecha de Registro'
			);

			if (count($result) > 0) {
				for ($i = 0; $i < count($result); ++$i) {
					$csv_output = $csv_output.$result[$i].',';
				}
			}

			$csv_output .= "\n";

			// body
			if (count($data) > 0) {
				$counter = 1;
				foreach ($data as $key => $value) {
					$metaData = json_decode($value['data'], true);
					$stringCountryRef = ( isset($metaData['country']) && !empty($metaData['country'])) ? $metaData['country'] : $countryIso;

					$csv_output .= $counter.',';
					$csv_output .= $value['email'].',';
					$csv_output .= $value['country'].',';
					$csv_output .= $value['origin'].',';
					$csv_output .= $value['date_created'].',';
					$csv_output .= $stringCountryRef .',';
					$csv_output .= "\n";
					$counter++;
				}
			}

			return mb_convert_encoding($csv_output, 'UTF-16LE', 'UTF-8');
		}

		/**
		 * Export CSV
		 *
		 * @var string $csv_str
		 * @var null|string $filename
		 */
		public function export_csv( $csv_str, $filename = null )
		{
			global $countryIso;

			if ( ! isset( $countryIso ) || empty( $countryIso ) ) {
				$countryIso = 'network';
			}

			if ( ! isset( $filename ) || empty( $filename ) ) {
				$filename = "users_{$countryIso}_".date('d_m_Y').'.csv';
			}

			header('Content-Encoding: UTF-8');
			header('Content-type: text/csv; charset=UTF-8');
			header("Content-Disposition: attachment; filename={$filename}");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $csv_str;
			exit;
		}

	}
endif;
