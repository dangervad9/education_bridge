<?php

/**
 * SocialV\Utility\Editor\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Custom_Helper;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;
use SocialV\Utility\Custom_Helper\Helpers;
use SocialV\Utility\Custom_Helper\Helpers\Activity;
use SocialV\Utility\Custom_Helper\Helpers\Groups;
use SocialV\Utility\Custom_Helper\Helpers\Members;
use SocialV\Utility\Custom_Helper\Helpers\Common;
use SocialV\Utility\Custom_Helper\Helpers\CustomNotifications;
use SocialV\Utility\Custom_Helper\Helpers\Media;
use SocialV\Utility\Custom_Helper\Helpers\Messages;

use function SocialV\Utility\socialv;

/**
 * Class for integrating with the block editor.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
class Component implements Component_Interface, Templating_Component_Interface
{

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	private $members, $groups, $activity, $notifications, $common, $media, $verified_member, $messages;
	public function get_slug(): string
	{
		return 'custom_helper';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public  function __construct()
	{
		$this->members = new Members();
		$this->groups = new Groups();
		$this->activity = new Activity();
		$this->common = new Common();
		if (class_exists('mediapress')) {
			$this->media = new Media();
		}
		if (class_exists('BP_Better_Messages') && function_exists('Better_Messages')) {
			$this->messages = new Messages();
		}
		$this->notifications = new CustomNotifications();
	}
	public function initialize()
	{
		add_action('after_setup_theme', array($this, 'action_add_custom_helper'));
	}


	public function template_tags(): array
	{
		return array(
			'socialv_get_verified_badge'         		=> [$this->members, 'socialv_get_verified_badge'],
			'socialv_is_user_online'         			=> [$this->members, 'socialv_is_user_online'],
			'socialv_group_posts_count' 					=> [$this->groups, 'socialv_group_posts_count'],
			'socialv_group_banner_img'  					=> [$this->groups, 'socialv_group_banner_img'],
			'socialv_bp_groups_members_template_part' 	=> [$this->groups, 'socialv_bp_groups_members_template_part'],
			'socialv_more_content_js' => [$this->groups, 'socialv_more_content_js'],
			'bp_custom_get_send_private_message_link' 		=> [$this->members, 'bp_custom_get_send_private_message_link'],
			'socialv_member_social_socials_info' 		=> [$this->members, 'socialv_member_social_socials_info'],
			'socialv_count_user_comments' 				=> [$this->members, 'socialv_count_user_comments'],
			'socialv_get_total_post_updates_count' 		=> [$this->members, 'socialv_get_total_post_updates_count'],
			'socialv_get_postviews' 						=> [$this->members, 'socialv_get_postviews'],
			'socialv_set_postviews' 						=> [$this->members, 'socialv_set_postviews'],
			'socialv_activity_group_meta' 				=> [$this->activity, 'socialv_activity_group_meta'],
			'is_socialv_user_likes' 						=> [$this->activity, 'is_socialv_user_likes'],
			'socialv_blog_total_user_likes' 				=> [$this->activity, 'socialv_blog_total_user_likes'],
			'is_socialv_user_pin' 						=> [$this->activity, 'is_socialv_user_pin'],
			'socialv_bp_banner' 							=> [$this->common, 'socialv_bp_banner'],
			'socialv_user_profile_modal' 				=> [$this->common, 'socialv_user_profile_modal'],
			'get_shortcode_content' 						=> [$this->common, 'get_shortcode_content'],
			'get_shortcode_links'							=> [$this->common, 'get_shortcode_links'],
			'get_default_login_user' 						=> [$this->common, 'get_default_login_user'],
			'socialv_notification_avatar'				=> [$this->notifications, 'socialv_notification_avatar'],
			'get_ajax_search_content' 						=> [$this->common, 'get_ajax_search_content'],
		);
	}


	public function action_add_custom_helper()
	{
		if (function_exists('buddypress')) {
			new Helpers\Ajax();
		}
	}
}
