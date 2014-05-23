<?php
/**
 * This allows store owners to define where customers get routed on or after certain events take place.
 * @package IT_Exchange
 * @since 1.0.0
*/

/**
 * Prints the Settings page
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_modify_default_redirects_settings_callback() {
	$form_values  = it_exchange_get_option( 'addon_modify_default_redirects', true );
	if ( ! isset( $form_values['show-continue-shopping-button'] ) )
		$form_values['show-continue-shopping-button'] = true;
	$form_options = array(
		'id'      => 'it-exchange-add-on-modify-default-redirects-settings',
		'action'  => 'admin.php?page=it-exchange-addons&add-on-settings=modify-default-redirects',
	);
	$form         = new ITForm( $form_values, array( 'prefix' => 'it-exchange-add-on-modify-default-redirects' ) );

	// Get our whitelist for approved actions
	$possible_redirects = it_exchange_addon_modify_default_redirects_get_registered_redirects();
	?>
	<div class="wrap">
		<?php ITUtility::screen_icon( 'it-exchange' ); ?>
		<h2><?php _e( 'Modify Default Redirects', 'LION' ); ?></h2>

		<?php do_action( 'it_exchange_modify_default_redirects_settings_page_top' ); ?>
		<?php do_action( 'it_exchange_addon_settings_page_top' ); ?>
		<?php $form->start_form( $form_options, 'it-exchange-modify-default-redirects-settings' ); ?>

		<?php
		do_action( 'it_exchange_digital_downloads_settings_form_top' );
		if ( ! empty( $form_values ) )
			foreach ( $form_values as $key => $var )
				$form->set_option( $key, $var );

		if ( ! empty( $_POST['__it-form-prefix'] ) && 'it-exchange-add-on-modify-default-redirects' == $_POST['__it-form-prefix'] )
			ITUtility::show_status_message( __( 'Options Saved', 'LION' ) );

		// Loop through saved settings and print them out
		/*
		$action_select = '
		<select id="it-exchange-addon-modify-default-redirects-possible-rewrites-select">
			<option value="">' . __( 'Select an action', 'LION' ) . '</option>';
			foreach( $possible_redirects as $slug => $redirect ) {
				$action_select .= '<option value="' . esc_attr( $slug ) . '">' . $redirect['select_title'] . '</select>';
			}
		$action_select .= '</select>';
		*/
		$action_target_type = '
		<select id="it-exchange-addon-modify-default-redirects-target-types">
		<option value="0">' . __( 'Default', 'LION' ) . '</option>
		<option value="exchange-page">' . __( 'Exchange Page', 'LION' ) . '</option>
		<option value="wp-page">' . __( 'WordPress Page', 'LION' ) . '</option>
		<option value="wp-post">' . __( 'WordPress Post', 'LION' ) . '</option>
		<option value="external-url">' . __( 'External URL', 'LION' ) . '</option>
		</select>';
		?>
		<div class="it-exchange-addon-modify-default-redirects-table">
			<div class="it-row ps-header">
				<div class="it-column column-1">
					<span><?php _e( 'Action or Event', 'LION' ); ?></span>
				</div>
				<div class="it-column column-2">
					<span><?php _e( 'Page Type', 'LION' ); ?></span>
				</div>
				<div class="it-column column-3">
					<span><?php _e( 'Landing Page', 'LION' ); ?></span>
				</div>
			</div>
			<?php foreach( $possible_redirects as $slug => $redirect ) {
				?>
				<div class="it-row">
					<div class="it-column column-1">
						<span><?php echo $redirect['setting_title']; ?></span><?php if ( ! empty( $redirect['tooltip'] ) ) { it_exchange_admin_tooltip( $redirect['tooltip'] ); } ?>
					</div>
					<div class="it-column column-2">
						<span><?php echo $action_target_type; ?></span>
					</div>
					<div class="it-column column-3">
						<span><?php echo $redirect['defaults_to']; ?></span>
					</div>
				</div>
				<?php
			} ?>
		</div>
		<?php
		do_action( 'it_exchange_modify_default_redirects_settings_form_bottom' );
		?>
		<p class="submit">
			<?php $form->add_submit( 'submit', array( 'value' => __( 'Save Changes', 'LION' ), 'class' => 'button button-primary button-large' ) ); ?>
		</p>
	<?php $form->end_form(); ?>
	<?php do_action( 'it_exchange_modify_default_redirects_settings_page_bottom' ); ?>
	<?php do_action( 'it_exchange_addon_settings_page_bottom' ); ?>
</div>
<?php
}

/**
 * Provides registered redirect options
 *
 * @since 1.0.0
 *
 * @return array
*/
function it_exchange_addon_modify_default_redirects_get_registered_redirects() {
	$redirects = array(
		'login-to-profile' => array(
			'setting_title' => __( 'Successful log-in from the Log-in Page', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'profile' ),
			'tooltip'       => __( 'This is where a customer will be directed after a successful log-in attempt.', 'LION' ),
		),
		'login-failed-from-login' => array(
			'setting_title' => __( 'Failed log-in from the Log-in Page', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'login' ),
			'tooltip'       => __( 'This is where a customer will be directed after a failed log-in attempt from the log-in page.', 'LION' ),
		),
		'login-failed-from-checkout' => array(
			'setting_title' => __( 'Failed log-in from the Checkout Page', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'checkout' ),
			'tooltip'       => __( 'This is where a customer will be directed after a failed log-in attempt from the checkout page.', 'LION' ),
		),
		'registration-to-profile' => array(
			'setting_title' => __( 'Successful registration from the Registration Page', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'profile' ),
			'tooltip'       => __( 'This is where a customer will be directed after a successful registration from the registration page.', 'LION' ),
		),
		'registration-to-checkout' => array(
			'setting_title' => __( 'Successful registration from the Checkout Page', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'checkout' ),
			'tooltip'       => __( 'This is where a customer will be directed after a successful registration from the checkout page.', 'LION' ),
		),
		'login-to-profile-when-user-logged-in' => array(
			'setting_title' => __( 'When a Logged in User Navigates to the Log-in Page', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'profile' ),
			'tooltip'       => __( 'This is where a customer that is logged in will be directed if they attempt to manually navigate to the Log-in page.', 'LION' ),
		),
		'download-pickup-hash-not-found-to-store' => array(
			'setting_title' => __( 'Digital Download: Not Found', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'downloads' ),
			'tooltip'       => __( 'This is where a customer is routed if they attempt to download a Digital Download Product\'s file that can\'t be found by Exchange.', 'LION' ),
		),
		'download-pickup-user-not-logged-in' => array(
			'setting_title' => __( 'Digital Download: Customer not logged in', 'LION' ),
			'defaults_to'   => it_exchange_get_page_url( 'login' ),
			'tooltip'       => __( 'This is where a customer is routed if they attempt to download a Digital Download Product\'s but they aren\'t logged in.', 'LION' ),
		),
	);
	$redirects = apply_filters( 'it_exchange_addon_modify_default_redirects_get_registered_redirects', $redirects );
	return (array) $redirects;
}

/**
 * Saves the settings page values
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_modify_default_redirects_save_settings() {
	if ( empty( $_POST['__it-form-prefix'] ) || 'it-exchange-add-on-modify-default-redirects' != $_POST['__it-form-prefix'] )
		return;

	$form_values = it_exchange_get_option( 'addon_modify_default_redirects', true );
	$form_values['show-continue-shopping-button'] = ! empty( $_POST['it-exchange-add-on-modify-default-redirects-show-continue-shopping-button'] );
	it_exchange_save_option( 'addon_modify_default_redirects', $form_values );
}
add_action( 'admin_init', 'it_exchange_modify_default_redirects_save_settings' );

/**
 * Enqueues css and js for admin page
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_addon_modify_default_redirects_enqueue_admin_scripts( $prefix ) {
	if ( empty( $prefix ) || 'exchange_page_it-exchange-addons' != $prefix )
		return;

	if ( empty( $_GET['add-on-settings'] ) || 'modify-default-redirects' != $_GET['add-on-settings'] )
		return;

	wp_enqueue_script( 'it-exchange-dialog' );
	wp_enqueue_style( 'it-exchange-addon-modify-default-redirects-admin', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/lib/assets/admin.css' ) );
}
add_action( 'admin_enqueue_scripts', 'it_exchange_addon_modify_default_redirects_enqueue_admin_scripts', 11 );
