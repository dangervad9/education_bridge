<?php
/**
 * SocialV\Utility\Redux_Framework\Options\Dashboard class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;
use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Dashboard extends Component {

	public function __construct() {
		if(!is_customize_preview())
        $this->set_widget_option();	}

	protected function set_widget_option() {
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Dashboard', 'socialv'),
			'id'    => 'redux-dashboard',
            'has_group_title' => __("Get Started", "socialv"),
			'icon'  => 'custom-Dashboard',
			'fields' => array(

                array(
                    'id'           => 'dashboard-raw',
                    'type'         => 'raw',
                    'full_width' => true,
                    'content_path' =>  dirname( __FILE__ ) . '/raw_html.php'
                )

            ),
		));
	}
}
