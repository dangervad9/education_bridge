<?php

/**
 * SocialV\Utility\PMP class
 *
 * @package socialv
 */

namespace SocialV\Utility\PMP;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;

use function SocialV\Utility\socialv;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `socialv()->the_comments( array $args = array() )`
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
		return 'pmp';
	}

	public function initialize()
	{
	}
	public $socialv_option;
	public function __construct()
	{
		$this->socialv_option = get_option('socialv-options');
		add_action('template_redirect', function () {
			global $post;
			if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'pmpro_login')) {
				add_filter('login_form_top', [$this, 'socialv_pmpro_login_form_top']);
				add_filter('login_form_bottom', [$this, 'socialv_pmpro_login_form_bottom']);
				add_filter('login_form_middle', [$this, 'socialv_pmpro_login_form_middle']);
				add_filter('login_form_defaults', [$this, 'socialv_pmpro_login_form_defaults']);
				add_filter('pmpro_login_forms_handler_nav', [$this, 'socialv_pmpro_login_forms_handler_nav'], 10, 2);
			}
			if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'pmpro_account') || bp_current_action() == 'membership') {
				add_filter('pmpro_actions_nav_separator', function () {
					return ' ';
				});
			}
		});
		add_filter('pmpro_element_class', [$this,  'socialv_pmpro_element_class'], 10, 2);
		add_filter('pmpro_member_action_links', [$this,  'socialv_pmpro_member_action_links']);
		add_filter('pmpro_account_profile_action_links', [$this,  'socialv_pmpro_account_profile_action_links']);
		add_filter('socialv_pmpro_member_header_top', [$this,  'socialv_pmpro_member_header_top']);
		add_action('socialv_pmpro_membership_top_wizard', [$this, 'socialv_pmpro_membership_top_wizard']);
		
	}

	public function template_tags(): array
	{
		return array();
	}

	public function socialv_pmpro_login_form_top()
	{
		echo '<div class="socialv-login-form">';
		socialv()->get_shortcode_content("login");
	}

	public function socialv_pmpro_login_form_bottom()
	{
		ob_start(); // Start output buffering
		do_action('get_socialv_social_after');
		socialv()->get_shortcode_links('register');
		$output = ob_get_clean(); // Get the buffered output
		$output .= '</div>'; // Concatenate the additional content
		return $output;
	}

	public function socialv_pmpro_login_form_middle($args)
	{
		$args = array(
			'label_remember' => __('Remember Me', 'socialv'),
			'id_remember'    => 'rememberme',
			'remember'       => true,
			'value_remember' => false,
			'lost_password'       => true,
			'url_lost_password' => add_query_arg('action', urlencode('reset_pass'), pmpro_login_url()),
			'label_lost_password' => esc_html__('Forgot Password?', 'socialv')
		);
		$html = '<div class="d-flex flex-sm-row justify-content-between align-items-center mb-4">' .
			($args['remember'] ?
				sprintf(
					'<p class="login-remember mb-0"><label class="mb-0"><input name="rememberme" type="checkbox" id="%1$s" value="forever"%2$s /> %3$s</label></p>',
					esc_attr($args['id_remember']),
					($args['value_remember'] ? ' checked="checked"' : ''),
					esc_html($args['label_remember'])
				) : ''
			)  . ($args['lost_password'] ?
				sprintf(
					'<a id="user_changepass" class="forgot-pwd" href="%1$s"/> %2$s</a>',
					esc_url($args['url_lost_password']),
					esc_html($args['label_lost_password'])
				) : ''
			) . '</div>';
		return $html;
	}

	public function socialv_pmpro_login_form_defaults($defaults)
	{
		$defaults['remember'] = '';
		$defaults['submit_class'] = 'custom-class'; // Add your custom class here
		return $defaults;
	}

	public function socialv_pmpro_login_forms_handler_nav($links, $pmpro_form)
	{
		// remove the "Lost password and login" link
		if ($pmpro_form != 'lost_password') {
			$links['lost_password'] = '';
		}
		if ($pmpro_form == "login") {
			$links['register'] = '';
		}
		return  $links;
	}

	public function socialv_pmpro_element_class($classes, $element)
	{
		$search = '/(\bpmpro_btn\b)(?!-)/';
		$replace = 'socialv-button';
		$classes = preg_replace($search, $replace, $classes);
		if ($element == 'pmpro_btn-cancel') {
			$classes = array();
			$classes[] = 'btn socialv-btn-danger';
		}
		if ($element == 'pmpro_cancel-membership-cancel') {
			$classes[] = 'pmpro-btn-danger';
		}
		if (in_array($element, ['pmpro_account-profile', 'pmpro_account-membership', 'pmpro_account-invoices', 'pmpro_account-links'])) {
			$classes = array();
			$classes[] = 'pmpro-card-inner card-inner card-space-bottom';
		}
		if (in_array($element, ['pmpro_actions_nav-right', 'pmpro_actions_nav-left', 'pmpro_cancel_return_home'])) {
			$classes = array();
			$classes[] = 'pmpro-btn-primary';
		}
		return $classes;
	}
	public function socialv_pmpro_member_action_links($links)
	{
		foreach ($links as $key => $link) {
			if (strpos($key, 'change') !== false) {
				$links[$key] = str_replace('<a ', '<a class="btn-sm socialv-btn-danger" ', $link);
			} elseif (strpos($key, 'cancel') !== false) {
				$links[$key] = str_replace('<a ', '<a class="btn-sm socialv-btn-info" ', $link);
			} elseif (strpos($key, 'update-billing') !== false) {
				$links[$key] = str_replace('<a ', '<a class="btn-sm socialv-btn-success" ', $link);
			} elseif (strpos($key, 'renew') !== false) {
				$links[$key] = str_replace('<a ', '<a class="btn-sm socialv-btn-orange" ', $link);
			}
		}

		return $links;
	}
	public function socialv_pmpro_account_profile_action_links($links)
	{
		foreach ($links as $key => $link) {
			if (strpos($key, 'edit-profile') !== false) {
				$links[$key] = str_replace('<a ', '<a class="btn socialv-btn-primary" ', $link);
			} elseif (strpos($key, 'change-password') !== false) {
				$links[$key] = str_replace('<a ', '<a class="btn socialv-btn-success" ', $link);
			} elseif (strpos($key, 'logout') !== false) {
				$links[$key] = str_replace('<a ', '<a class="btn socialv-btn-danger" ', $link);
			}
		}

		return $links;
	}

	public function socialv_pmpro_member_header_top()
	{
		$content = '';
		if ($this->socialv_option['is_pmp_cancel_logo'] == 'yes') :
			$logo_url = (!empty($this->socialv_option['pmp_page_default_cancel_logo']['url'])) ? ($this->socialv_option['pmp_page_default_cancel_logo']['url']) : (get_template_directory_uri() . "/assets/images/redux/cancel.png");
			$content = '<div class="pmpro-logo-main"><div class="pmpro-logo-normal"><img class="img-fluid logo" loading="lazy" src="' . esc_url($logo_url) . '" alt="' . esc_attr__('socialv', 'socialv') . '"></div></div>';
		endif;
		echo apply_filters('socialv_pmpro_member_header_content_top', $content);
	}

	public function socialv_pmpro_membership_top_wizard()
	{
		$current_page_id = get_queried_object_id();
		$checkout_page_link = '';
		$membership_level_page_id = pmpro_getOption('levels_page_id');
		$membership_level_page_link = !empty($membership_level_page_id) ? get_permalink($membership_level_page_id) : '';
		$confirmation_page_id = pmpro_getOption('confirmation_page_id');
		$checkout_page_id = pmpro_getOption('checkout_page_id');

		if ($current_page_id == $confirmation_page_id) {
			$checkout_page_link = !empty($checkout_page_id) ? get_permalink($checkout_page_id) : '';
		}

		$steps = array(
			array(
				'name' => esc_html__('Select Plan', 'socialv'),
				'id' => 'socialv-pmpro_select_plan',
				'link' => $membership_level_page_link,
				'class' => ($current_page_id == $membership_level_page_id) ? 'active' : '',
			),
			array(
				'name' => esc_html__('Account Details', 'socialv'),
				'id' => 'socialv-pmpro_register',
				'link' => $checkout_page_link,
				'class' => ($current_page_id == $checkout_page_id) ? 'active' : '',
			),
			array(
				'name' => esc_html__('Order Summary', 'socialv'),
				'id' => 'socialv-pmpro_checkout_success',
				'class' => ($current_page_id == $confirmation_page_id) ? 'active' : '',
			),
		);
?>

		<div class="socialv-page-header">
			<ul class="socialv-page-items">
				<?php foreach ($steps as $key => $item) : ?>
					<?php
					$href = '';
					if (!empty($item['link'])) {
						$href = esc_url($item['link']);
					}
					?>
					<li class="socialv-page-item  <?php echo esc_attr($item['class']); ?>" id="<?php echo esc_attr($item['id']); ?>">
						<span class="socialv-pre-heading"><?php echo esc_html($key + 1); ?></span>
						<a class="socialv-page-link" href="<?php echo esc_url($href); ?>">
							<?php echo esc_html($item['name']); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
<?php
	}
}
