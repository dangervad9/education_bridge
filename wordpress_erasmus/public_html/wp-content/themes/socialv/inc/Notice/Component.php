<?php

/**
 * SocialV\Utility\Notice\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Notice;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;
use function add_action;
use function SocialV\Utility\socialv;

/**
 * Class for managing notice UI.
 *
 * Exposes template tags:
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'notice';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public 	function initialize()
	{
	}

	public function __construct()
	{
		add_action('admin_notices',  array($this, 'iqonic_update_plugin'), 0);

		// sale banner
		if (strtotime(date('Y-m-d')) >= strtotime('2023-03-20') && strtotime(date('Y-m-d')) <= strtotime('2023-03-31')) {
			add_action('admin_notices',  array($this, 'socialv_sale_banner'), 0);
		}

		if (class_exists('mediapress')) {
			add_action('admin_notices',  array($this, 'socialv_latest_mediapress_announcement'), 0);
		}

		if (class_exists('BP_Better_Messages')) {
			add_action('admin_notices',  array($this, 'socialv_latest_messages_announcement'), 0);
		}

		add_action('wp_ajax_socialv_dismiss_notice', array($this, 'socialv_dismiss_notice'), 10);
		add_action('admin_enqueue_scripts', array($this, 'socialv_notice_enqueue_admin_script'));
		add_action('wp_ajax_socialv_import_settings',  array($this, 'socialv_import_settings'));
		add_action('wp_ajax_nopriv_socialv_import_settings',  array($this, 'socialv_import_settings'));
		add_action('demo_import_media_settings', array($this, 'demo_import_media_settings'));
		add_action('demo_import_messages_settings', array($this, 'demo_import_messages_settings'));
		if (class_exists('Wpstory_Premium')) {
			add_action('after_setup_theme', array($this, 'socialv_theme_switch_support'));
		}
		// Post Update
		add_action('after_switch_theme', array($this, 'socialv_save_posts_options'));
	}

	public function template_tags(): array
	{
		return array();
	}

	public function iqonic_update_plugin()
	{
		global $current_user;
		$user_id = $current_user->ID;

		$theme_setup_page = admin_url("themes.php?page=tgmpa-install-plugins");
		if (!get_user_meta($user_id, 'iqonic_plugin_update_announcement', true)) {

			// Plugin Required Version
			$required_iqonic_extension_version = '2.0.1';
			$required_imt_version = '1.2.3';
			$required_reaction_version = '1.1.0';

			// Plugin Current Version and Activation Status
			$plugins = get_plugins();
			$iqonic_extension_version = isset($plugins['iqonic-extensions/iqonic-extension.php']['Version']) ? $plugins['iqonic-extensions/iqonic-extension.php']['Version'] : '0';
			$iqonic_moderation_version = isset($plugins['iqonic-moderation-tool/iqonic-moderation-tool.php']['Version']) ? $plugins['iqonic-moderation-tool/iqonic-moderation-tool.php']['Version'] : '0';
			$iqonic_reaction_version = isset($plugins['iqonic-reactions/iqonic-reactions.php']['Version']) ? $plugins['iqonic-reactions/iqonic-reactions.php']['Version'] : '0';
			$iqonic_extension_isactive = is_plugin_active('iqonic-extensions/iqonic-extension.php');
			$iqonic_moderation_isactive = is_plugin_active('iqonic-moderation-tool/iqonic-moderation-tool.php');
			$iqonic_reaction_isactive = is_plugin_active('iqonic-reactions/iqonic-reactions.php');

			// Check if required plugins are installed
			$plugins_to_install = array();
			if (!$iqonic_extension_isactive) {
				$plugins_to_install[] = esc_html__('Iqonic Extensions', 'socialv');
			}
			if (!$iqonic_moderation_isactive) {
				$plugins_to_install[] = esc_html__('Iqonic Moderation Tool', 'socialv');
			}
			if (!$iqonic_reaction_isactive) {
				$plugins_to_install[] = esc_html__('Iqonic Reactions', 'socialv');
			}
			// Display message to install required plugins
			if (!empty($plugins_to_install)) {
				if (($iqonic_extension_isactive && $iqonic_moderation_isactive && $iqonic_reaction_isactive) && ($iqonic_extension_version > $required_iqonic_extension_version && $iqonic_moderation_version > $required_imt_version && $iqonic_reaction_version > $required_reaction_version)) {
				} else {
					if (($iqonic_extension_isactive || $iqonic_moderation_isactive || $iqonic_reaction_isactive) && ($iqonic_extension_version < $required_iqonic_extension_version || $iqonic_moderation_version < $required_imt_version || $iqonic_reaction_version < $required_reaction_version)) {
						$this->iqonic_update_plugin_notice($theme_setup_page, $plugins_to_install, $iqonic_extension_isactive, $iqonic_moderation_isactive, $iqonic_reaction_isactive, $iqonic_extension_version, $required_iqonic_extension_version, $iqonic_moderation_version, $required_imt_version, $iqonic_reaction_version, $required_reaction_version);
					}
				}
			} else {
				if (!empty($plugins_to_install) || (($iqonic_extension_isactive || $iqonic_moderation_isactive || $iqonic_reaction_isactive) && ($iqonic_extension_version < $required_iqonic_extension_version || $iqonic_moderation_version < $required_imt_version || $iqonic_reaction_version < $required_reaction_version))) {
					$this->iqonic_update_plugin_notice($theme_setup_page, $plugins_to_install, $iqonic_extension_isactive, $iqonic_moderation_isactive, $iqonic_reaction_isactive, $iqonic_extension_version, $required_iqonic_extension_version, $iqonic_moderation_version, $required_imt_version, $iqonic_reaction_version, $required_reaction_version);
				}
			}
		}
	}
	public function iqonic_update_plugin_notice($theme_setup_page, $plugins_to_install, $iqonic_extension_isactive, $iqonic_moderation_isactive, $iqonic_reaction_isactive, $iqonic_extension_version, $required_iqonic_extension_version, $iqonic_moderation_version, $required_imt_version, $iqonic_reaction_version, $required_reaction_version)
	{ ?>
		<div class="notice notice-warning socialv-notice is-dismissible" id="iqonic_plugin_update_announcement">
			<div class="iqonic-plugin-update-message">
				<?php
				// Install Plugin
				if (!empty($plugins_to_install)) {
					$plugins_to_install_str = implode(', ', $plugins_to_install);
				?>
					<h3><?php esc_html_e('The following required plugins are not installed: ', 'socialv'); ?>
						<?php echo esc_html($plugins_to_install_str); ?>
					</h3>
					<h3><?php esc_html_e('Please install the required plugins from the following link: ', 'socialv'); ?>
						<a href="<?php echo esc_url($theme_setup_page); ?>" rel="noopener noreferrer"><?php esc_html_e('Click Here To Install Plugin', 'socialv') ?></a>
					</h3>
					<?php
				}
				// Update Plugin
				if ($iqonic_extension_isactive || $iqonic_moderation_isactive || $iqonic_reaction_isactive) {
					if ($iqonic_extension_version < $required_iqonic_extension_version || $iqonic_moderation_version < $required_imt_version || $iqonic_reaction_version < $required_reaction_version) { ?>

						<h3><?php esc_html_e('We have updates available in our plugins.', 'socialv'); ?>
							<a href="<?php echo esc_url('https://assets.iqonic.design/documentation/wordpress/socialv-doc/index.html#update-plugin', 'socialv') ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Check Here - How To Update Plugin', 'socialv') ?></a>
						</h3>

						<h3><span class="note-title"><?php esc_html_e('Note:', 'socialv'); ?></span><?php esc_html_e('Prior to updating, please make sure to backup previous versions of the plugin in case you have made any custom code changes.', 'socialv'); ?>
							<a href="<?php echo esc_url('https://assets.iqonic.design/documentation/wordpress/socialv-doc/index.html#manual-update', 'socialv') ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Click here', 'socialv') ?></a>
						</h3>

				<?php }
				}
				?>
			</div>
			<div class="socialv-notice-cta">
				<button class="socialv-notice-dismiss socialv-dismiss-welcome notice-dismiss" data-msg="iqonic_plugin_update_announcement"><span class="screen-reader-text"><?php esc_html_e('Dismiss', 'socialv'); ?></span></button>
			</div>
		</div>
		<?php
	}
	public function socialv_sale_banner()
	{
		global $current_user;
		$user_id = $current_user->ID;
		if (!get_user_meta($user_id, 'socialv_sale_banner_announcement', true)) {  ?>
			<div class="notice socialv-notice is-dismissible" id="socialv_sale_banner_announcement">
				<div class="socialv-notice-message socialv-sale">
					<a href=" <?php echo esc_url('https://iqonic.design/') ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/sale.jpg'); ?>" alt="<?php esc_attr_e('sale-banner', 'socialv') ?>"></a>
				</div>
				<div class="socialv-notice-cta">
					<button class="socialv-notice-dismiss socialv-dismiss-welcome notice-dismiss" data-msg="socialv_sale_banner_announcement"><span class="screen-reader-text"><?php esc_html_e('Dismiss', 'socialv'); ?></span></button>
				</div>
			</div>
			<?php  }
	}

	public function socialv_latest_mediapress_announcement()
	{
		global $current_user;
		$user_id = $current_user->ID;
		global $wp_filesystem;
		require_once(ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
		$media_setting = false;
		$import_file =  trailingslashit(get_template_directory()) . 'inc/Import/Demo/socialv-media-setting.json';
		if (file_exists($import_file)) {
			$content = $wp_filesystem->get_contents($import_file);
			if (!empty($content) && json_decode($content, true) != get_option('mpp-settings')) {
				$media_setting = true;
			}
		}
		if (!get_user_meta($user_id, 'socialv_mediapress_notification')) {
			if ($media_setting == true) { ?>
				<div class="notice notice-warning socialv-notice is-dismissible" id="socialv_mediapress_notification">
					<div class="socialv-notice-message socialv-media">
						<div class="socialv-notice-message-inner">
							<div class="socialv-heading"><?php esc_html_e('Get MediaPress plugin settings similar to SocialV Theme Demo.', 'socialv'); ?></div>
						</div>
					</div>
					<div class="socialv-notice-main-box">
						<form class="iqonic_media_form" method="post">
							<button name="socialv_media_button" class="w-100 socialv-button iqonic-data-input" type="submit" value="<?php esc_attr_e('Import MediaPress Setting', 'socialv'); ?>"><?php esc_html_e('Import MediaPress Setting', 'socialv'); ?></button>
							<input type="hidden" name="media_form_type" data-value="<?php esc_attr_e('Media', 'socialv'); ?>" value="<?php esc_attr_e('Media', 'socialv'); ?>" />
						</form>
						<?php
						if (isset($element_nonce) && true == $element_nonce) { ?>
							<?php wp_nonce_field('socialv_ajax_import_settings', 'socialv_ajax_import_settings_nonce'); ?>
						<?php } else { ?>
							<?php wp_nonce_field('socialv_ajax_import_settings', 'socialv_ajax_import_settings_nonce'); ?>
						<?php } ?>
					</div>
					<div class="socialv-notice-cta">
						<button class="socialv-notice-dismiss socialv-dismiss-welcome notice-dismiss" data-msg="socialv_mediapress_notification"><span class="screen-reader-text"><?php esc_html_e('Dismiss', 'socialv'); ?></span></button>
					</div>
				</div>
			<?php
			}
		}
	}


	public function socialv_latest_messages_announcement()
	{
		global $current_user;
		$user_id = $current_user->ID;
		global $wp_filesystem;
		require_once(ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
		$chat_setting = false;
		$import_file =  trailingslashit(get_template_directory()) . 'inc/Import/Demo/socialv-chat-setting.json';
		if (file_exists($import_file)) {
			$content = $wp_filesystem->get_contents($import_file);
			if (!empty($content) && json_decode($content, true) != get_option('bp-better-chat-settings')) {
				$chat_setting = true;
			}
		}
		if (!get_user_meta($user_id, 'socialv_messages_notification')) {
			if ($chat_setting == true) { ?>
				<div class="notice notice-warning socialv-notice is-dismissible" id="socialv_messages_notification">
					<div class="socialv-notice-message socialv-message">
						<div class="socialv-notice-message-inner">
							<div class="socialv-heading"><?php esc_html_e('Get better messaging plugin settings similar to SocialV Theme Demo.', 'socialv'); ?></div>
						</div>
					</div>
					<div class="socialv-notice-main-box">
						<form class="iqonic_media_form" method="post">
							<button name="socialv_chat_button" class="w-100 socialv-button iqonic-data-input" type="submit" value="<?php esc_attr_e('Import Better Messages Setting', 'socialv'); ?>"><?php esc_html_e('Import Better Messages Setting', 'socialv'); ?></button>
							<input type="hidden" name="media_form_type" data-chat-value="<?php esc_attr_e('Chat', 'socialv'); ?>" value='<?php esc_attr_e('Chat', 'socialv'); ?>' />
						</form>
						<?php
						if (isset($element_nonce) && true == $element_nonce) { ?>
							<?php wp_nonce_field('socialv_ajax_import_settings', 'socialv_ajax_import_settings_nonce'); ?>
						<?php } else { ?>
							<?php wp_nonce_field('socialv_ajax_import_settings', 'socialv_ajax_import_settings_nonce'); ?>
						<?php } ?>
					</div>
					<div class="socialv-notice-cta">
						<button class="socialv-notice-dismiss socialv-dismiss-welcome notice-dismiss" data-msg="socialv_messages_notification"><span class="screen-reader-text"><?php esc_html_e('Dismiss', 'socialv'); ?></span></button>
					</div>
				</div>
<?php
			}
		}
	}

	public function socialv_dismiss_notice()
	{
		global $current_user;
		$user_id = $current_user->ID;
		if (!empty($_POST['action']) && $_POST['action'] == 'socialv_dismiss_notice') {
			if ($_POST['data'] === 'socialv_mediapress_notification') {
				add_user_meta($user_id, 'socialv_mediapress_notification', 'true', true);
				wp_send_json_success();
			} else if ($_POST['data'] === 'socialv_messages_notification') {
				add_user_meta($user_id, 'socialv_messages_notification', 'true', true);
				wp_send_json_success();
			} else if ($_POST['data'] === 'socialv_sale_banner_announcement') {
				add_user_meta($user_id, 'socialv_sale_banner_announcement', 'true', true);
				wp_send_json_success();
			} else if ($_POST['data'] === 'iqonic_plugin_update_announcement') {
				add_user_meta($user_id, 'iqonic_plugin_update_announcement', 'true', true);
				wp_send_json_success();
			}
		}
	}

	function socialv_import_settings()
	{
		// if ajax is not loaded, exit
		if (!wp_doing_ajax()) {
			exit;
		}

		if (isset($_POST['formType']) && $_POST['dataValue'] === $_POST['formType']) {
			if (isset($_REQUEST['socialv_ajax_import_settings_nonce']) && !wp_verify_nonce($_REQUEST['socialv_ajax_import_settings_nonce'], 'socialv_ajax_import_settings')) {
				exit;
			}
			do_action('demo_import_media_settings');
			echo json_encode(array('status' => 'media-success', 'message' => esc_html__('You have successfully set your MediaPress setting same as SocialV Theme Demo.', 'socialv')));
			exit();
		} elseif (isset($_POST['formType']) && $_POST['chatValue'] === $_POST['formType']) {
			if (isset($_REQUEST['socialv_ajax_import_settings_nonce']) && !wp_verify_nonce($_REQUEST['socialv_ajax_import_settings_nonce'], 'socialv_ajax_import_settings')) {
				exit;
			}
			do_action('demo_import_messages_settings');
			echo json_encode(array('status' => 'message-success', 'message' => esc_html__('You have successfully set your Better Messages setting same as SocialV Theme Demo.', 'socialv')));
			exit();
		}

		exit();
	}

	function demo_import_media_settings()
	{
		global $wp_filesystem;
		require_once(ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
		$media_file =  trailingslashit(get_template_directory()) . 'inc/Import/Demo/socialv-media-setting.json';
		if (file_exists($media_file)) {
			$content = $wp_filesystem->get_contents($media_file);
			if (!empty($content)) {
				update_option('mpp-settings', json_decode($content, true));
			}
		}
	}

	function demo_import_messages_settings()
	{
		global $wp_filesystem;
		require_once(ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
		$import_file =  trailingslashit(get_template_directory()) . 'inc/Import/Demo/socialv-chat-setting.json';
		if (file_exists($import_file)) {
			$content = $wp_filesystem->get_contents($import_file);
			if (!empty($content)) {
				update_option('bp-better-chat-settings', json_decode($content, true));
			}
		}
	}

	public function socialv_notice_enqueue_admin_script()
	{
		// Js Varibale
		$global_localize_values = array(
			'admin_notice' 	=> esc_html__('Warning: Are you sure you want to replace your default setting with SocialV Theme Setting?', 'socialv'),
		);
		$global_localize_vars = apply_filters("socialv_global_script_vars", $global_localize_values);
		wp_register_script('socialv_custom_global_script', false);
		wp_localize_script(
			'socialv_custom_global_script',
			'socialv_global_script',
			$global_localize_vars
		);
		wp_enqueue_script('socialv_custom_global_script');
		wp_enqueue_script('admin-custom', get_template_directory_uri() . '/assets/js/admin-custom.min.js', array('jquery'), socialv()->get_version());
		wp_enqueue_style('admin-custom', get_template_directory_uri() . '/assets/css/admin-custom.min.css', array(), socialv()->get_version());
	}

	function socialv_theme_switch_support()
	{
		$story_options = get_option('wp-story-premium');
		$story_options['buddypress_users_activities'] = 1;
		$story_options['buddypress_integration'] = 1;
		$story_options['buddypress_activities_form'] = 1;
		$story_options['user_publish_status'] = 'publish';
		update_option('wp-story-premium', $story_options);
	}

	function socialv_save_posts_options()
	{
		global $query_posts;
		$query_posts = new \WP_Query(array(
			'post_type' => array('post')
		));
		while ($query_posts->have_posts()) :
			$query_posts->the_post();
			wp_update_post(array(
				'ID' => get_the_ID(),
				'post_content' => get_the_content(),
			));
		endwhile;
		wp_reset_postdata();
	}
}
