<?php
/**
 * SocialV\Utility\Dynamic_Style\Styles\HeaderSideArea class
 *
 * @package socialv
 */

namespace SocialV\Utility\Dynamic_Style\Styles;

use SocialV\Utility\Dynamic_Style\Component;
use function add_action;

class HeaderSideArea extends Component
{

	public function __construct()
	{        
		add_action('wp_enqueue_scripts', array($this, 'socialv_header_sidearea_dynamic_style'), 20);
	}

	public function socialv_header_sidearea_dynamic_style()
	{
		$socialv_options = get_option('socialv-options');
		$dynamic_css = '';

		if (isset($socialv_options['sidearea_background_type']) && $socialv_options['sidearea_background_type'] != 'default') {
			$type = $socialv_options['sidearea_background_type'];
			if ($type == 'color') {
				if (!empty($socialv_options['sidearea_background_color'])) {
					$dynamic_css .= '.sidebar{
						background : ' . $socialv_options['sidearea_background_color'] . '!important;
					}';
				}
			}

			if ($type == 'image') {
				if (!empty($socialv_options['sidearea_background_image']['url'])) {
					$dynamic_css .= '.sidebar{
						background : url(' . $socialv_options['sidearea_background_image']['url'] . ') !important;
					}';
				}
			}

			if ($type == 'transparent') {
				$dynamic_css .= '.sidebar{
					background : transparent !important;
				}';
			}
		}

		if (isset($socialv_options['sidearea_width']['width']) && !empty($socialv_options['sidearea_width']['width'])) {
			$dynamic_css .= '.sidebar{
				width : ' . $socialv_options['sidearea_width']['width'] . '!important;
			}';
		}

		if (!empty($dynamic_css)) {
			wp_add_inline_style('socialv-global', $dynamic_css);
		}
	}
}
