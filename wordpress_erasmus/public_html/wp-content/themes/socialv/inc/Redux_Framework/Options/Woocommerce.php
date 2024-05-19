<?php

/**
 * SocialV\Utility\Redux_Framework\Options\User class
 *
 * @package socialv
 */

namespace SocialV\Utility\Redux_Framework\Options;

use Redux;
use SocialV\Utility\Redux_Framework\Component;

class Woocommerce extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('WooCommerce ', 'socialv'),
			'icon'  => 'custom-Woo-commerce',
			'customizer_width' => '500px',
		));


		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Shop Page', 'socialv'),
			'id'    => 'Woocommerce',
			'icon' => 'custom-shop',
			'subsection' => true,
			'fields' => array(
				array(
					'id'        => 'woocommerce_shop',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop page Setting', 'socialv'),
					'subtitle'  => wp_kses(__('Choose among these structures (Product Listing, Product Grid) for your shop section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.', 'socialv'), array('br' => array())),
					'options'   => array(
						'1' => array(
							'title' => esc_html__('Product Listing', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/one-column-dark.png',
							'class' => 'one-column'
						),
						'2' => array(
							'title' => esc_html__('Product Grid', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/three-column-dark.png',
							'class' => 'three-column'
						),
					),
					'default'   => '2',
				),
				array(
					'id'        => 'woocommerce_shop_grid',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop Grid page Setting', 'socialv'),
					'options'   => array(
						'4' => array(
							'title' => esc_html__('Left sidebar', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/left-sidebar-dark.png',
							'class' => 'left-sidebar'
						),
						'5' => array(
							'title' => esc_html__('Right sidebar', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/right-sidebar-dark.png',
							'class' => 'right-sidebar'
						),
						'1' => array(
							'title' => esc_html__('Two column', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/two-column-dark.png',
							'class' => 'two-column'
						),
						'2' => array(
							'title' => esc_html__('Three column', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/three-column-dark.png',
							'class' => 'three-column'
						),
					),
					'default'   => '5',
					'required'  => array('woocommerce_shop', '=', '2'),
				),
				array(
					'id'        => 'woocommerce_shop_list',
					'type'      => 'image_select',
					'title'     => esc_html__('Shop List page Setting', 'socialv'),
					'options'   => array(
						'4' => array(
							'title' => esc_html__('Left sidebar', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/left-sidebar-dark.png',
							'class' => 'left-sidebar'
						),
						'5' => array(
							'title' => esc_html__('Right sidebar', 'socialv'), 
							'img' => get_template_directory_uri() . '/assets/images/redux/right-sidebar-dark.png',
							'class' => 'right-sidebar'
						),
					),
					'default'   => '5',
					'required'  => array('woocommerce_shop', '=', '1'),
				),

				array(
					'id' => 'woocommerce_product_per_page',
					'type' => 'slider',
					'title' => esc_html__('Set Product Per Page', 'socialv'),
					'subtitle' => esc_html__('Here This option provide set product per paged item', 'socialv'),
					'min' => 1,
					'step' => 1,
					'max' => 99,
					'default' => 10
				),

			)
		));
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Product Page', 'socialv'),
			'id'    => 'product_page',
			'icon' => 'custom-product',
			'subsection' => true,
			'fields' => array(

				array(
					'id' => 'socialv_show_related_product',
					'type' => 'button_set',
					'title' => esc_html__('Display Related Product', 'socialv'),
					'subtitle' => esc_html__('This Option Display Related Product On Single Product Page', 'socialv'),
					'options' => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default' => esc_html__('yes', 'socialv')
				),

				array(
					'id'       => 'desk_number',
					'type'     => 'text',
					'title'    => esc_html__('Number of Product Display On Desktop', 'socialv'),
					'default'  => esc_html__('4', 'socialv'),
					'required' => array('socialv_show_related_product', '=', 'yes'),
					'subtitle' => esc_html__('Enter Numeric Value Only', 'socialv')
				),

				array(
					'id'       => 'lap_number',
					'type'     => 'text',
					'title'    => esc_html__('Number of Product Display On Laptop', 'socialv'),
					'default'  => esc_html__('3', 'socialv'),
					'required' => array('socialv_show_related_product', '=', 'yes'),
					'subtitle' => esc_html__('Enter Numeric Value Only', 'socialv')

				),

				array(
					'id'       => 'tab_number',
					'type'     => 'text',
					'title'    => esc_html__('Number of Product Display On Tablet', 'socialv'),
					'default'  => esc_html__('2', 'socialv'),
					'required' => array('socialv_show_related_product', '=', 'yes'),
					'subtitle' => esc_html__('Enter Numeric Value Only', 'socialv')
				),

				array(
					'id'       => 'mob_number',
					'type'     => 'text',
					'title'    => esc_html__('Number of Product Display On Mobile', 'socialv'),
					'default'  => esc_html__('2', 'socialv'),
					'required' => array('socialv_show_related_product', '=', 'yes'),
					'subtitle' => esc_html__('Enter Numeric Value Only', 'socialv')
				),

				array(
					'id'       => 'related_autoplay',
					'type'     => 'button_set',
					'title'    => esc_html__('Show Autoplay ?', 'socialv'),
					'options'  => array(
						'true' => esc_html__('True', 'socialv'),
						'false' => esc_html__('False', 'socialv'),
					),
					'default'  => 'false',
					'required' => array('socialv_show_related_product', '=', 'yes'),
				),

				array(
					'id'       => 'related_loop',
					'type'     => 'button_set',
					'title'    => esc_html__('Show Loop ?', 'socialv'),
					'options'  => array(
						'true' => esc_html__('True', 'socialv'),
						'false' => esc_html__('False', 'socialv'),
					),
					'default'  => 'true',
					'required' => array('socialv_show_related_product', '=', 'yes'),
				),
				
                array(
                    'id' => 'related_speed',
                    'type' => 'slider',
                    'title' => esc_html__('Set Speed', 'socialv'),
                    'min' => 0,
                    'step' => 1,
                    'max' => 10000,
					'default' => 2000,
                    'display_value' => 'select',
                    'required' => array('socialv_show_related_product', '=', 'yes'),
                ),

				array(
					'id'       => 'related_dots',
					'type'     => 'button_set',
					'title'    => esc_html__('Show Pagination ?', 'socialv'),
					'options'  => array(
						'true' => esc_html__('True', 'socialv'),
						'false' => esc_html__('False', 'socialv'),
					),
					'default'  => 'true',
					'required' => array('socialv_show_related_product', '=', 'yes'),
				),

				array(
					'id'       => 'related_nav',
					'type'     => 'button_set',
					'title'    => esc_html__('Show Navigation ?', 'socialv'),
					'options'  => array(
						'true' => esc_html__('True', 'socialv'),
						'false' => esc_html__('False', 'socialv'),
					),
					'default'  => 'true',
					'required' => array('socialv_show_related_product', '=', 'yes'),
				),
				
			)
		));
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Products Setting', 'socialv'),
			'id'    => 'single_page',
			'subsection' => true,
			'icon' => 'custom-product-settings',
			'fields' => array(


				array(
					'id'        => 'socialv_display_product_name',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Name', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'socialv_display_price',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Price', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'socialv_display_product_rating',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Rating', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default'   => 'yes'
				),


				array(
					'id'        => 'socialv_display_product_addtocart_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display AddToCart Icon', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default'   => 'yes'
				),

				array(
					'id'        => 'socialv_display_product_wishlist_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display Wishlist Icon', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default'   => 'yes'
				),


				array(
					'id'        => 'socialv_display_product_quickview_icon',
					'type'      => 'button_set',
					'title'     => esc_html__('Display QuickView Icon', 'socialv'),
					'options'   => array(
						'yes' => esc_html__('Yes', 'socialv'),
						'no' => esc_html__('No', 'socialv')
					),
					'default'   => 'yes'
				),

			),

		));
	}
}
