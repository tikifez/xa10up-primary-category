<?php
/**
 * Primary Category settings section header
 *
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    XA10up_Primary_Category
 * @subpackage XA10up_Primary_Category/admin/partials
 */

if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

if ( isset( $_GET['settings-updated'] ) ) {
	add_settings_error( 'xa10up_messages', 'xa10up_message', __( 'Settings Saved', 'xa10up' ), 'updated' );
}

settings_errors( 'xa10up_messages' );
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
		<?php
		settings_fields( 'xa10up' );
		do_settings_sections( 'xa10up-settings' );
		submit_button( 'Save Settings' );
		?>
    </form>
</div>
