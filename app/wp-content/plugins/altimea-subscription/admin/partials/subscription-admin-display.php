<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    blogSubscription
 * @subpackage blogSubscription/admin/partials
 */
?>
<div class="wrap">
	<h2><?php _e('Lista de suscriptos') ?></h2>
	<section>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<form action="" method="get">
					</form>
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php $this->blog_list_subscription_table->display(); ?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</section>
	<div class="wrap">
		<form method="post">
			<input type="hidden" name="export-all-subscription-csv" value="1" />
			<?php submit_button( __( 'Descargar', 'altimea-subscription' ) ); ?>
		</form>
	</div>
</div>
