<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\General class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class General extends Component
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'socialv_general_root_var'), 20);
		add_action('wp_enqueue_scripts', array($this, 'socialv_create_general_style'), 20);
	}
	public function socialv_general_root_var()
	{
		$socialv_options = get_option('socialv-options');
		$id = (function_exists('is_shop') && is_shop()) ? wc_get_page_id('shop') : get_queried_object_id();
		$general_var = '';
		if (isset($socialv_options['grid_container']['width']) && !empty($socialv_options['grid_container']['width'])) {
			if ($socialv_options['grid_container']['width'] != 'em' && $socialv_options['grid_container']['width'] != 'px' && $socialv_options['grid_container']['width'] != '%') {
				$general = $socialv_options['grid_container']['width'];
				$general_var .= '--content-width: ' . $general . ' !important;';
			}
		}

		$spacings = [
			'page_spacing' 			=> ['--global-page-top-spacing', '--global-page-bottom-spacing'],
			'tablet_page_spacing'	=> ['--global-page-top-spacing-tablet', '--global-page-bottom-spacing-tablet'],
			'mobile_page_spacing'	=> ['--global-page-top-spacing-mobile', ' --global-page-bottom-spacing-mobile']
		];

		$is_page_spacing = get_post_meta($id, '_is_page_spacing', true);
		foreach ($spacings as $options_value => $vars) {
			$page_top_spacing = get_post_meta($id, '_' . $options_value, true);
			$page_bottom_spacing = get_post_meta($id, '_bottom_' . $options_value, true);
			if ($is_page_spacing == 'custom') {
				$general_var .= !empty($page_top_spacing) || $page_top_spacing == "0" ? $vars[0] . ":" . $page_top_spacing . " !important;" : '';
				$general_var .= !empty($page_bottom_spacing) || $page_bottom_spacing == "0" ? $vars[1] . ":" . $page_bottom_spacing . " !important;" : '';
			} else {
				if (isset($socialv_options['is_page_spacing']) && $socialv_options['is_page_spacing'] == "custom") {
					$general_var .= !empty($socialv_options[$options_value]["top"]) ? $vars[0] . ":" . $socialv_options[$options_value]["top"] . " !important;" : "";
					$general_var .= !empty($socialv_options[$options_value]["bottom"]) ? $vars[1] . ":" . $socialv_options[$options_value]["bottom"] . " !important;" : "";
				}
			}
		}
		if (!empty($general_var)) {
			$general_var = ":root{" . $general_var . "}";
			wp_add_inline_style('socialv-global', $general_var);
		}
	}
	public function socialv_create_general_style()
	{

		$socialv_options = get_option('socialv-options');
		$general_var = '';

		if (isset($socialv_options['body_back_option']) && $socialv_options['body_back_option'] == 1) {
			if (isset($socialv_options['body_color'])  && !empty($socialv_options['body_color'])) {
				$general = $socialv_options['body_color'];
				$general_var .= 'body { background : ' . $general . ' !important; }';
			}
		}
		if (isset($socialv_options['body_back_option']) && $socialv_options['body_back_option'] == 3) {
			if (isset($socialv_options['body_image']['url']) && !empty($socialv_options['body_image']['url'])) {
				$general = $socialv_options['body_image']['url'];
				$general_var .= 'body { background-image: url(' . $general . ') !important; }';
			}
		}

		if (isset($socialv_options['back_to_top_btn']) && $socialv_options['back_to_top_btn'] == 'no') {
			$general_var .= '.css-prefix-top { display: none; }';
		}

		if (!empty($general_var)) {
			wp_add_inline_style('socialv-global', $general_var);
		}
	}
}
