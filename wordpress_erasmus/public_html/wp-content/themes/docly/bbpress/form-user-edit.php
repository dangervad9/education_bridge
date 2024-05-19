<?php

/**
 * bbPress User Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<form id="bbp-your-profile" method="post" enctype="multipart/form-data">

	<h2 class="entry-title"><?php esc_html_e( 'Name', 'docly' ) ?></h2>

	<?php do_action( 'bbp_user_edit_before' ); ?>

	<fieldset class="bbp-form">
		<legend><?php esc_html_e( 'Name', 'docly' ) ?></legend>

		<?php do_action( 'bbp_user_edit_before_name' ); ?>

		<div>
			<label for="first_name"><?php esc_html_e( 'First Name', 'docly' ) ?></label>
			<input type="text" name="first_name" id="first_name" value="<?php bbp_displayed_user_field( 'first_name', 'edit' ); ?>" class="regular-text" />
		</div>

		<div>
			<label for="last_name"><?php esc_html_e( 'Last Name', 'docly' ) ?></label>
			<input type="text" name="last_name" id="last_name" value="<?php bbp_displayed_user_field( 'last_name', 'edit' ); ?>" class="regular-text" />
		</div>

		<div>
			<label for="nickname"><?php esc_html_e( 'Nickname', 'docly' ); ?></label>
			<input type="text" name="nickname" id="nickname" value="<?php bbp_displayed_user_field( 'nickname', 'edit' ); ?>" class="regular-text" />
		</div>

		<div>
			<label for="display_name"><?php esc_html_e( 'Display Name', 'docly' ) ?></label>

			<?php bbp_edit_user_display_name(); ?>

		</div>

		<?php do_action( 'bbp_user_edit_after_name' ); ?>

	</fieldset>

	<h2 class="entry-title"><?php esc_html_e( 'Contact Info', 'docly' ) ?></h2>

	<fieldset class="bbp-form">
		<legend><?php esc_html_e( 'Contact Info', 'docly' ) ?></legend>

		<?php do_action( 'bbp_user_edit_before_contact' ); ?>

		<div>
			<label for="url"><?php esc_html_e( 'Website', 'docly' ) ?></label>
			<input type="text" name="url" id="url" value="<?php bbp_displayed_user_field( 'user_url', 'edit' ); ?>" maxlength="200" class="regular-text code" />
		</div>

		<?php foreach ( bbp_edit_user_contact_methods() as $name => $desc ) : ?>

			<div>
				<label for="<?php echo esc_attr( $name ); ?>"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?></label>
				<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php bbp_displayed_user_field( $name, 'edit' ); ?>" class="regular-text" />
			</div>

		<?php endforeach; ?>

		<?php do_action( 'bbp_user_edit_after_contact' ); ?>

	</fieldset>

	<h2 class="entry-title"><?php bbp_is_user_home_edit()
		? esc_html_e( 'About Yourself', 'docly' )
		: esc_html_e( 'About the user', 'docly' );
	?></h2>

	<fieldset class="bbp-form">
		<legend><?php bbp_is_user_home_edit()
			? esc_html_e( 'About Yourself', 'docly' )
			: esc_html_e( 'About the user', 'docly' );
		?></legend>

		<?php do_action( 'bbp_user_edit_before_about' ); ?>

		<div>
			<label for="description"><?php esc_html_e( 'Biographical Info', 'docly' ); ?></label>
			<textarea name="description" id="description" rows="5" cols="30"><?php bbp_displayed_user_field( 'description', 'edit' ); ?></textarea>
		</div>

		<?php do_action( 'bbp_user_edit_after_about' ); ?>

	</fieldset>

	<h2 class="entry-title"><?php esc_html_e( 'Account', 'docly' ) ?></h2>

	<fieldset class="bbp-form">
		<legend><?php esc_html_e( 'Account', 'docly' ) ?></legend>

		<?php do_action( 'bbp_user_edit_before_account' ); ?>

		<div>
			<label for="user_login"><?php esc_html_e( 'Username', 'docly' ); ?></label>
			<input type="text" name="user_login" id="user_login" value="<?php bbp_displayed_user_field( 'user_login', 'edit' ); ?>" maxlength="100" disabled="disabled" class="regular-text" />
		</div>

		<div>
			<label for="email"><?php esc_html_e( 'Email', 'docly' ); ?></label>
			<input type="text" name="email" id="email" value="<?php bbp_displayed_user_field( 'user_email', 'edit' ); ?>" maxlength="100" class="regular-text" autocomplete="off" />
		</div>

		<?php bbp_get_template_part( 'form', 'user-passwords' ); ?>

		<div>
			<label for="url"><?php esc_html_e( 'Language', 'docly' ) ?></label>

			<?php bbp_edit_user_language(); ?>

		</div>

		<?php do_action( 'bbp_user_edit_after_account' ); ?>

	</fieldset>

	<?php if ( ! bbp_is_user_home_edit() && current_user_can( 'promote_user', bbp_get_displayed_user_id() ) ) : ?>

		<h2 class="entry-title"><?php esc_html_e( 'User Role', 'docly' ) ?></h2>

		<fieldset class="bbp-form">
			<legend><?php esc_html_e( 'User Role', 'docly' ); ?></legend>

			<?php do_action( 'bbp_user_edit_before_role' ); ?>

			<?php if ( is_multisite() && is_super_admin() && current_user_can( 'manage_network_options' ) ) : ?>

				<div>
					<label for="super_admin"><?php esc_html_e( 'Network Role', 'docly' ); ?></label>
					<label>
						<input class="checkbox" type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( bbp_get_displayed_user_id() ) ); ?> />
						<?php esc_html_e( 'Grant this user super admin privileges for the Network.', 'docly' ); ?>
					</label>
				</div>

			<?php endif; ?>

			<?php bbp_get_template_part( 'form', 'user-roles' ); ?>

			<?php do_action( 'bbp_user_edit_after_role' ); ?>

		</fieldset>

	<?php endif; ?>

	<?php do_action( 'bbp_user_edit_after' ); ?>

	<fieldset class="submit">
		<legend><?php esc_html_e( 'Save Changes', 'docly' ); ?></legend>
		<div>

			<?php bbp_edit_user_form_fields(); ?>

			<button type="submit" id="bbp_user_edit_submit" name="bbp_user_edit_submit" class="button submit user-submit"><?php bbp_is_user_home_edit()
				? esc_html_e( 'Update Profile', 'docly' )
				: esc_html_e( 'Update User',    'docly' );
			?></button>
		</div>
	</fieldset>
</form>
