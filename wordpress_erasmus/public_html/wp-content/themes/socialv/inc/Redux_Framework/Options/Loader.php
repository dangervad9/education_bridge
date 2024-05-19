<?php
/**
 * SocialV\Utility\Redux_Framework\Options\Loader class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;
use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Loader extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Loader', 'socialv'),
			'desc' => esc_html__('This section contains options for loader.', 'socialv'), 
			'id' => 'loader',
			'icon' => 'custom-loader',
			'fields' => array(

				array(
					'id' => 'display_loader',
					'type' => 'button_set',
					'title' => esc_html__('socialv Loader', 'socialv'),
					'subtitle' => wp_kses('Turn on to show the icon/images loading animation while your site loads', 'socialv'),
					'options' => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default' => esc_html__('no', 'socialv')
				),

				array(
					'id' => 'loader_bg_color',
					'type' => 'color',
					'title' => esc_html__('Loader Background Color', 'socialv'),
					'required' => array('display_loader', '=', 'yes'),
					"class"	=> "socialv-sub-fields",
					'subtitle' => esc_html__('Choose Loader Background Color', 'socialv'),
					'default' => '#ffffff',
					'transparent' => false
				),

				array(
					'id' => 'loader_gif',
					'type' => 'media',
					'url' => true,
					'title' => esc_html__('Add GIF image for loader', 'socialv'),
					'read-only' => false,
					'required' => array('display_loader', '=', 'yes'),
					"class"	=> "socialv-sub-fields",
					'subtitle' => esc_html__('Upload Loader GIF image for your Website.', 'socialv'),
				),

				array(
					'id' => 'loader-dimensions',
					'type' => 'dimensions',
					'units' => array('em', 'px', '%'),
					'units_extended' => 'true',
					'required' => array('display_loader', '=', 'yes'),
					"class"	=> "socialv-sub-fields",
					'title' => esc_html__('Loader (Width/Height) Option', 'socialv'),
					'subtitle' => esc_html__('You can enable or disable any piece of this field. Width, Height, or Units.', 'socialv'),
					'height_label'  =>  'Height',
					'width_label'   =>  'Width',
					'units_label'   => 'Choose option',
				),
			)
		));
	}
}
