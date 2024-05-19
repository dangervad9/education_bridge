<?php
/**
 * SocialV\Utility\Redux_Framework\Options\SocialMedia class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;
use Redux;
use SocialV\Utility\Redux_Framework\Component;

class SocialMedia extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title'            => esc_html__( 'Social Media', 'socialv' ),
			'id'               => 'social_link',
			'icon'             => 'custom-Social-Media',
			'fields'           => array(

				array(
					'id'       => 'social_media_options',
					'type'     => 'sortable',
					'title'    => esc_html__('Social Media Option', 'socialv'),
					'subtitle' => esc_html__('Enter social media url.', 'socialv'),
					'mode'     => 'text',
					'label'    => true,
					'options'  => array(
						'facebook'     	=> '',
						'twitter'       => '',
						'instagram'     => '',
						'linkedin'      => '',
						'pinterest'     => '',
						'dribbble'      => '',
						'flickr'        => '',
						'skype'         => '',
						'youtube'       => '',
						'rss'           => '',
						'behance'       => '',
					),
				),

			),
		) );
	}
}
