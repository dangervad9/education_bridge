<?php

/**
 * SocialV\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class Color extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'socialv_color_options'), 20);
	}

	public function socialv_color_options()
	{
		$socialv_options = get_option('socialv-options');
		$color_var = "";
		if (class_exists('ReduxFramework')) {
			// Light Mode
			$check_color = ($socialv_options['custom_color_switch'] == 'yes');
			if ($check_color) {

				// Button Color
				$color_attrs = ':root { ';
				if (isset($socialv_options['success_color']) && !empty($socialv_options['success_color'])) {
					$color = $socialv_options['success_color'];
					$color_var .= '--color-theme-success: ' . $color . ' !important;';
					$color_var .= '--color-theme-success-dark: ' . $color . 'ff !important;';
					$color_var .= '--color-theme-success-light: ' . $color . '16 !important;';
				}
				if (isset($socialv_options['danger_color']) && !empty($socialv_options['danger_color'])) {
					$color = $socialv_options['danger_color'];
					$color_var .= '--color-theme-danger: ' . $color . ' !important;';
					$color_var .= '--color-theme-danger-dark: ' . $color . 'ff !important;';
					$color_var .= '--color-theme-danger-light: ' . $color . '16 !important;';
				}
				if (isset($socialv_options['warning_color']) && !empty($socialv_options['warning_color'])) {
					$color = $socialv_options['warning_color'];
					$color_var .= '--color-theme-warning: ' . $color . ' !important;';
					$color_var .= '--color-theme-warning-dark: ' . $color . 'ff !important;';
					$color_var .= '--color-theme-warning-light: ' . $color . '26 !important;';
				}
				if (isset($socialv_options['info_color']) && !empty($socialv_options['info_color'])) {
					$color = $socialv_options['info_color'];
					$color_var .= '--color-theme-info: ' . $color . ' !important;';
					$color_var .= '--color-theme-info-dark: ' . $color . 'ff !important;';
					$color_var .= '--color-theme-info-light: ' . $color . '16 !important;';
				}
				if (isset($socialv_options['orange_color']) && !empty($socialv_options['orange_color'])) {
					$color = $socialv_options['orange_color'];
					$color_var .= '--color-theme-orange: ' . $color . ' !important;';
					$color_var .= '--color-theme-orange-dark: ' . $color . 'ff !important;';
					$color_var .= '--color-theme-orange-light: ' . $color . '16 !important;';
				}
				if (!empty($color_var)) {
					$color_attrs .= $color_var;
				}
				$color_attrs .= '}';
				if (!empty($color_attrs)) {
					wp_add_inline_style('socialv-global', $color_attrs);
				}

				// Light mode
				$light_attrs = '[data-mode=light] { ';
				if (isset($socialv_options['text_color']) && !empty($socialv_options['text_color'])) {
					$color = $socialv_options['text_color'];
					$color_var .= '--global-font-color: ' . $color . ' !important;';
				}
				if (isset($socialv_options['title_color']) && !empty($socialv_options['title_color'])) {
					$color = $socialv_options['title_color'];
					$color_var .= ' --global-font-title: ' . $color . ' !important;';
				}
				if (isset($socialv_options['parent_bg_color']) && !empty($socialv_options['parent_bg_color'])) {
					$color = $socialv_options['parent_bg_color'];
					$color_var .= '--color-theme-white-box: ' . $color . ' !important;';
				}
				if (isset($socialv_options['child_bg_color']) && !empty($socialv_options['child_bg_color'])) {
					$color = $socialv_options['child_bg_color'];
					$color_var .= '--global-body-bgcolor: ' . $color . ' !important;';
				}

				if (!empty($color_var)) {
					$light_attrs .= $color_var;
				}
				$light_attrs .= '}';
				if (!empty($light_attrs)) {
					wp_add_inline_style('socialv-global', $light_attrs);
				}


				// Dark Mode 
				$dark_attrs = '[data-mode=dark] { ';
				if (isset($socialv_options['dark_text_color']) && !empty($socialv_options['dark_text_color'])) {
					$color = $socialv_options['dark_text_color'];
					$color_var .= '--global-font-color: ' . $color . ' !important;';
				}
				if (isset($socialv_options['dark_title_color']) && !empty($socialv_options['dark_title_color'])) {
					$color = $socialv_options['dark_title_color'];
					$color_var .= ' --global-font-title: ' . $color . ' !important;';
				}
				if (isset($socialv_options['dark_parent_bg_color']) && !empty($socialv_options['dark_parent_bg_color'])) {
					$color = $socialv_options['dark_parent_bg_color'];
					$color_var .= '--color-theme-white-box: ' . $color . ' !important;';
				}
				if (isset($socialv_options['dark_child_bg_color']) && !empty($socialv_options['dark_child_bg_color'])) {
					$color = $socialv_options['dark_child_bg_color'];
					$color_var .= '--global-body-bgcolor: ' . $color . ' !important;';
				}
				if (!empty($color_var)) {
					$dark_attrs .= $color_var;
				}
				$dark_attrs .= '}';
				if (!empty($dark_attrs)) {
					wp_add_inline_style('socialv-global', $dark_attrs);
				}
			}
		}
	}
}
