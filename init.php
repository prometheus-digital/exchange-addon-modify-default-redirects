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
	$settings = it_exchange_get_option( 'addon_modify_default_redirects', true );
	$form_options = array(
		'id'      => 'it-exchange-add-on-modify-default-redirects-settings',
		'action'  => 'admin.php?page=it-exchange-addons&add-on-settings=modify-default-redirects',
	);
	$form         = new ITForm( array(), array( 'prefix' => 'it-exchange-add-on-modify-default-redirects' ) );

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
		if ( ! empty( $_POST['__it-form-prefix'] ) && 'it-exchange-add-on-modify-default-redirects' == $_POST['__it-form-prefix'] )
			ITUtility::show_status_message( __( 'Options Saved', 'LION' ) );

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
				$selected_type = empty( $settings[$slug]['type'] ) ? 'default' : $settings[$slug]['type'];
				$selected      = empty( $settings[$slug]['target'] ) ? 'default' : $settings[$slug]['target'];
				?>
				<div class="it-row">
					<div class="it-column column-1">
						<span><?php echo $redirect['setting_title']; ?></span><?php if ( ! empty( $redirect['tooltip'] ) ) { it_exchange_admin_tooltip( $redirect['tooltip'] ); } ?>
					</div>
					<div class="it-column column-2">
						<span><?php echo it_exchange_modify_default_redirects_get_settings_dropdown( 'type-selector', $slug, $selected_type ); ?></span>
					</div>
					<div class="it-column column-3">
						<div class="landing-page default <?php echo ( 'default' == $selected_type ) ? '' : 'hide-if-js'; ?>">
							<span><?php echo $redirect['defaults_to']; ?></span>
						</div>
						<div class="landing-page exchange <?php echo ( 'exchange' == $selected_type ) ? '' : 'hide-if-js'; ?>">
							<span><?php echo it_exchange_modify_default_redirects_get_settings_dropdown( 'exchange', $slug, $selected ); ?></span>
						</div>
						<div class="landing-page wp-page <?php echo ( 'wp-page' == $selected_type ) ? '' : 'hide-if-js'; ?>">
							<span><?php echo it_exchange_modify_default_redirects_get_settings_dropdown( 'wp-page', $slug, $selected ); ?></span>
						</div>
						<div class="landing-page wp-post <?php echo ( 'wp-post' == $selected_type ) ? '' : 'hide-if-js'; ?>">
							<span><?php echo it_exchange_modify_default_redirects_get_settings_dropdown( 'wp-post', $slug, $selected ); ?></span>
						</div>
						<div class="landing-page external-url <?php echo ( 'external-url' == $selected_type ) ? '' : 'hide-if-js'; ?>">
							<span><input type="text" name="it-exchange-modify-default-redirects[<?php echo $slug; ?>][external-url]" value="<?php esc_attr_e( $selected ); ?>" placeholder="<?php esc_attr_e( 'http://' ); ?>" /></span>
						</div>
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
	wp_enqueue_script( 'it-exchange-addon-modify-default-redirects-admin', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/lib/assets/admin.js' ) );
	wp_enqueue_style( 'it-exchange-addon-modify-default-redirects-admin', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/lib/assets/admin.css' ) );
}
add_action( 'admin_enqueue_scripts', 'it_exchange_addon_modify_default_redirects_enqueue_admin_scripts', 11 );

/**
 * Returns a select box for the settings page
 *
 * @since 1.0.0
 *
 * @param  string $type     the type of redirect. eg: default, exchange, wp-post, wp-page, external-url
 * @param  string $slug     the identifier
 * @param  mixed  $selected the selected value
 * @return string           the select field
*/
function it_exchange_modify_default_redirects_get_settings_dropdown( $type, $slug, $selected ) {
	switch( $type ) {
		case 'exchange' :
			$pages   = it_exchange_get_pages();
			$select  = '<select name="it-exchange-modify-default-redirects[' . $slug . '][exchange]">';
			$select .= '<option value="0" ' . selected( $selected, false, false ) . '>Select an Exchange page</option>';
			foreach( (array) $pages as $page ) {
				if ( empty( $page['menu'] ) )
					continue;
				$select .= '<option value="' . $page['slug'] . '" ' . selected( $selected, $page['slug'], false ) . '>' . $page['name'] . '</option>';
			}
			$select .= '</select>';
			return $select;
			break;
		case 'wp-page' :
			$pages = get_pages();
			$select  = '<select name="it-exchange-modify-default-redirects[' . $slug . '][wp-page]">';
			$select .= '<option value="0" ' . selected( $selected, false, false ) . '>' . __( 'Select a WordPress Page', 'LION' ) . '</option>';
			foreach( (array) $pages as $page ) {
				$select .= '<option value="' . $page->ID . '" ' . selected( $selected, $page->ID, false ) . '>' . get_the_title( $page->ID ) . '</option>';
			}
			$select .= '</select>';
			return $select;
			break;
		case 'wp-post' :
			$posts   = get_posts();
			$select  = '<select name="it-exchange-modify-default-redirects[' . $slug . '][wp-post]">';
			$select .= '<option value="0" ' . selected( $selected, false, false ) . '>' . __( 'Select a WordPress Post', 'LION' ) . '</option>';
			foreach( (array) $posts as $post ) {
				$select .= '<option value="' . $post->ID . '" ' . selected( $selected, $post->ID, false ) . '>' . get_the_title( $post->ID ) . '</option>';
			}
			$select .= '</select>';
			return $select;
			break;
		case 'type-selector' :
			$select  = '<select class="it-exchange-addon-modify-default-redirects-target-types" name="it-exchange-modify-default-redirects[' . $slug . '][type]">';
			$select .= '<option value="default" ' . selected( 'default', $selected, false ) . '>' . __( 'Default', 'LION' ) . '</option>';
			$select .= '<option value="exchange" ' . selected( 'exchange', $selected, false ) . '>' . __( 'Exchange Page', 'LION' ) . '</option>';
			$select .= '<option value="wp-page" ' . selected( 'wp-page', $selected, false ) . '>' . __( 'WordPress Page', 'LION' ) . '</option>';
			$select .= '<option value="wp-post" ' . selected( 'wp-post', $selected, false ) . '>' . __( 'WordPress Post', 'LION' ) . '</option>';
			$select .= '<option value="external-url" ' . selected( 'external-url', $selected, false ) . '>' . __( 'External URL', 'LION' ) . '</option>';
			$select .= '</select>';
			return $select;
			break;
	}
}

/**
 * Saves the settings
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_modify_default_redirects_save_settings() {
    if ( empty( $_POST['it-exchange-modify-default-redirects'] ) || empty( $_GET['add-on-settings'] ) || 'modify-default-redirects' != $_GET['add-on-settings'] )
        return;

	// Loop through array, validate, save anything that isn't default
	$redirects = array();
	foreach( (array) $_POST['it-exchange-modify-default-redirects'] as $key => $values ) {
		$type = empty( $values['type'] ) ? false : $values['type'];
		if ( empty( $type ) || empty( $values[$type] ) )
			continue;

		$redirects[$key] = array( 'type' => $type, 'target' => $values[$type] );
	}

	// Save data
    it_exchange_save_option( 'addon_modify_default_redirects', $redirects );
}
add_action( 'admin_init', 'it_exchange_modify_default_redirects_save_settings' );
