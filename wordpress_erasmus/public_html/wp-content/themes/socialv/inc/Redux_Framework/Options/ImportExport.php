<?php
/**
 * SocialV\Utility\Redux_Framework\Options\ImportExport class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;
use Redux;
use SocialV\Utility\Redux_Framework\Component;

class ImportExport extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Import / Export', 'socialv'),
			'id'    => 'import-export',
			'icon'  => 'custom-import-export',
			'customizer' => false,
			'fields' => array(

				array(
					'id'         => 'redux_import_export',
					'type'       => 'import_export',
					'full_width' => true,
				),

			)
		));
	}
}
