<?php
/**
 * General settings
 *
 * @package CartFlows
 */


?>

<div class="wrap wcf-addon-wrap wcf-clear wcf-container">
	<input type="hidden" name="action" value="wcf_save_common_settings">
	<h1 class="screen-reader-text"><?php _e( 'General Settings', 'cartflows' ); ?></h1>

	<div id="poststuff">
		<div id="post-body" class="columns-2">
			<div id="post-body-content">
				<div class="postbox introduction">
					<h2 class="hndle wcf-normal-cusror ui-sortable-handle">
						<span><?php _e( 'Customize My Account Menu on Your Site', 'cartflows' ); ?></span>
					</h2>
					<div class="inside">
						<p>
							Here you can add/update/disable the menus of My Account setion on your site.
						</p>

						<?php 
							$action     = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );

							if ( ! $action ) {
								$action                 = 'menu';
								$active_tab_menu        = '';
								$active_other_tab         = '';
								$active_email_templates = '';
							}

							switch ( $action ) {
								case 'menu':
									$active_tab_menu = 'nav-tab-active';
									break;
								case 'other':
									$active_other_tab = 'nav-tab-active';
									break;
								
								default:
									$active_other_tab = 'nav-tab-active';
									break;
							}
					        // phpcs:disable
					     ?>

						<div class="nav-tab-wrapper woo-nav-tab-wrapper">
						<?php 
								$url = add_query_arg( array(
			                		'page' => MY_ACCOUNT_SLUG,
			                		'action' => 'menu'
			            		), admin_url( '/admin.php' ) )
			            ?>
							<a href="<?php echo $url; ?>" class="nav-tab <?php if ( isset( $active_tab_menu ) ) { echo $active_tab_menu;}?>">Display Options</a>

						<?php 
								$url = add_query_arg( array(
			                		'page' => MY_ACCOUNT_SLUG,
			                		'action' => 'other'
			            		), admin_url( '/admin.php' ) )
			            ?>
    						<a href="<?php echo $url; ?>" class="nav-tab <?php if ( isset( $active_other_tab ) ) { echo $active_other_tab;}?>">Social Options</a>
						</div>
					</div>
				</div>
				
			</div>
			<div class="postbox-container" id="postbox-container-1">
				<div id="side-sortables">

					<div class="postbox">
						<h2 class="hndle">
							<span class="dashicons dashicons-book"></span>
							<span><?php esc_html_e( 'Knowledge Base', 'cartflows' ); ?></span>
						</h2>
						<div class="inside">
							<p>
								<?php esc_html_e( 'Not sure how something works? Take a peek at the knowledge base and learn.', 'cartflows' ); ?>
							</p>
							<p>
								<a href="<?php echo esc_url( 'https://cartflows.com/docs' ); ?>" target="_blank" rel="noopener"><?php _e( 'Visit Knowledge Base »', 'cartflows' ); ?></a>
							</p>
						</div>
					</div>

					<div class="postbox">
						<h2 class="hndle">
							<span class="dashicons dashicons-groups"></span>
							<span><?php esc_html_e( 'Community', 'cartflows' ); ?></span>
						</h2>
						<div class="inside">
							<p>
								<?php esc_html_e( 'Join the community of super helpful CartFlows users. Say hello, ask questions, give feedback and help each other!', 'cartflows' ); ?>
							</p>
							<p>
								<a href="<?php echo esc_url( 'https://www.facebook.com/groups/cartflows/' ); ?>" target="_blank" rel="noopener"><?php _e( 'Join Our Facebook Group »', 'cartflows' ); ?></a>
							</p>
						</div>
					</div>

					<div class="postbox">
						<h2 class="hndle">
							<span class="dashicons dashicons-sos"></span>
							<span><?php esc_html_e( 'Five Star Support', 'cartflows' ); ?></span>
						</h2>
						<div class="inside">
							<p>
								<?php esc_html_e( 'Got a question? Get in touch with CartFlows developers. We\'re happy to help!', 'cartflows' ); ?>
							</p>
							<p>
								<a href="<?php echo esc_url( 'https://cartflows.com/contact' ); ?>" target="_blank" rel="noopener"><?php _e( 'Submit a Ticket »', 'cartflows' ); ?></a>
							</p>
						</div>
					</div>
				
				</div>
			</div>
		</div>
		<!-- /post-body -->
		<br class="clear">
	</div>
</div>

<?php 
	/**
	 *  Loads Zapier settings admin view.
	 */
	do_action( 'cartflows_after_general_settings' );
?>
