<?php

/**
 * SocialV\Utility\Woocommerce\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Woocommerce;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;
use function add_action;
use function SocialV\Utility\socialv;

/**
 * Class for managing Woocommerce UI.
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
	 * @return string Woocommerce slug.
	 */

	public $socialv_option;

	public $user_is_view_grid;
	public $user_is_col_no;


	public function get_slug(): string
	{
		return 'woocommerce';
	}
	function __construct()
	{
		$this->socialv_option = get_option('socialv-options');
		add_filter('woocommerce_gallery_thumbnail_size', function ($size) {
			return array(300, 300);
		});
		add_filter('woof_sort_terms_before_out', array($this, 'socialv_woof_hide_zero_term'));
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */

	public function initialize()
	{
		/* Product load more */
		if (!function_exists('socialv_loadmore_product_ajax_handler')) {
			add_action('wp_ajax_loadmore_product', array($this, 'socialv_loadmore_product_ajax_handler'));
			add_action('wp_ajax_nopriv_loadmore_product', array($this, 'socialv_loadmore_product_ajax_handler'));
		}
		add_action('wp_ajax_load_skeleton', array($this, 'socialv_load_skeleton_ajax_handler'));
		add_action('wp_ajax_nopriv_load_skeleton', array($this, 'socialv_load_skeleton_ajax_handler'));

		add_action('init', array($this, 'socialv_set_default_cookie'), -91);
		add_filter('woocommerce_show_page_title', '__return_false');
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
		add_action('woocommerce_before_shop_loop_item_title', array($this, 'socialv_loop_product_thumbnail'), 10);

		remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

		/* WooCommerce Checkout Fields Hook */
		add_filter('woocommerce_checkout_fields',  array($this, 'custom_wc_checkout_fields'));

		/* Single */
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		add_action('woocommerce_single_product_summary',  array($this, 'woocommerce_my_single_title'), 5);
		add_action('after_setup_theme', array($this, 'socialv_add_woocommerce_support'));
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

		/* Remove add to cart */
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);

		/* Remove product title */
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

		/* Remove product price */
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

		/* Rating Create For Product Loop */
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

		/* Archive Shop Title */
		add_filter('get_the_archive_title', array($this, 'socialv_product_archive_title'));

		/* MiniCart */
		add_filter('woocommerce_add_to_cart_fragments', array($this, 'socialv_refresh_mini_cart_count'));
		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_btn_view_cart'), 21);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_checkout'), 12);

		/* products loop_columns */
		add_filter('woocommerce_sale_flash', array($this, 'lw_hide_sale_flash'));
		add_filter('loop_shop_columns', array($this, 'socialv_loop_columns'), 21);
		add_filter('wc_get_template_part', array($this, 'socialv_wc_template_part'), 10, 3);
		add_filter('loop_shop_per_page', array($this, 'socialv_product_perpage'), 99999);

		add_filter('woocommerce_get_script_data', function ($params) {
			if (isset($params['i18n_view_cart'])) {
				$params['i18n_view_cart'] = '<span class=socialv-button>' . $params['i18n_view_cart'] . '</span>';
			}
			return $params;
		});
		add_action('woocommerce_after_main_content', array($this, 'socialv_woo_notice_massage'), 99);

		if (has_filter('woocommerce_checkout_update_order_review_expired', true)) {
			add_filter('woocommerce_update_order_review_fragments', function ($ar) {
				$ar['form.woocommerce-checkout'] = "<div clas='woocommerce-notices-wrapper'>" . $ar['form.woocommerce-checkout'] . '</div>';
				return $ar;
			});
		}

		/* Get Woof Ajax Filter Product Query */
		add_filter("woof_products_query", function ($query) {
			session_start();
			$_SESSION['socialv_woof_query_ajax'] = $query;
			return $query;
		});
		if (!function_exists('socialv_fetch_woof_filter_ajax_query')) {
			add_action('wp_ajax_fetch_woof_filter_ajax_query', array($this, 'socialv_fetch_woof_filter_ajax_query'));
			add_action('wp_ajax_nopriv_fetch_woof_filter_ajax_query', array($this, 'socialv_fetch_woof_filter_ajax_query'));
		}
		add_action('redux/options/socialv-options/saved', array($this, 'wmpl_save_config_file'));

		/* wishlist title hide */
		add_filter('yith_wcwl_wishlist_params', array($this, 'socialv_wishlist_remove_title'), 10, 3);

		/* hide terms and conditions toggle */
		add_action('wp_enqueue_scripts', array($this, 'socialv_disable_terms'), 1000);
	}

	public function template_tags(): array
	{
		return array(
			'get_single_product_dependent_script' 	=> array($this, 'get_single_product_dependent_script'),
			'socialv_related_product_attr' 		=> array($this, 'socialv_related_product_attr'),
			'socialv_ajax_product_load_scripts' 	=> array($this, 'socialv_ajax_product_load_scripts'),
			'socialv_slider_navigation'			=> array($this, 'socialv_slider_navigation')
		);
	}
	public function socialv_ajax_product_load_scripts()
	{
		wp_enqueue_script("socialv-woocomerce-product-loadmore", get_template_directory_uri() . '/assets/js/ajax-product-load.min.js',  array('jquery'), socialv()->get_version(), true);
	}
	public function get_single_product_dependent_script()
	{
		wp_enqueue_script('products-swiper', get_template_directory_uri() . '/assets/js/products-slider.min.js', array('jquery'), socialv()->get_version(), true);
	}
	public function socialv_woo_notice_massage()
	{ ?>
		<div class="socialv-modal css-prefix-model-woo">
			<div class="modal fade" id="<?php echo esc_attr(''); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<p class="socialv-model-text">

							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(function(jQuery) {
				// On "added_to_cart" live event
				jQuery(document.body).on('added_to_cart', function(a, b, c, d) {
					let prod_name = '“' + d.data('product_name') + '”  has been added to your cart'; // Get the product name
					let notice_model = new bootstrap.Modal(document.querySelector('.css-prefix-model-woo>.modal'));
					jQuery('.css-prefix-model-woo .modal .socialv-model-text').html(prod_name);
					notice_model.show();
				});
			});
		</script>
	<?php
	}


	public function socialv_set_default_cookie()
	{
		if (!wp_doing_ajax() && $GLOBALS["_SERVER"]['REQUEST_METHOD'] !== 'POST') {
			self::set_cookie();
		}
	}

	public static function set_cookie()
	{
		$socialv_option = get_option('socialv-options');
		$options = (isset($socialv_option['woocommerce_shop_grid']) && $socialv_option['woocommerce_shop_grid'] ? $socialv_option['woocommerce_shop_grid'] : '');
		$is_grid = $grid_col = $list_col = '';
		switch ($options) {
			case 1:
				$is_grid = 2;
				break;
			case 2:
				$is_grid = 3;
				break;
		}
		if (isset($_COOKIE['product_view']['col_no']) && !empty($_COOKIE['product_view']['col_no'])) {
			$grid_col = $_COOKIE['product_view']['col_no'];
		} else {
			$grid_col =  $is_grid;
		}
		if (isset($_COOKIE['product_view']['is_grid']) && !empty($_COOKIE['product_view']['is_grid'])) {
			$list_col = $_COOKIE['product_view']['is_grid'];
		} else {
			$list_col = $socialv_option['woocommerce_shop'];
		}
		$arr = array(
			'is_grid' => ($list_col) ? $list_col : 2,
			'col_no' => isset($socialv_option['woocommerce_shop']) && $socialv_option['woocommerce_shop'] == '2' && ($grid_col) ? $grid_col : 3
		);
		foreach ($arr as $key => $value) {
			setcookie('product_view[' . $key . ']', $value, time() + 62208000, '/');
			$_COOKIE['product_view'][$key] = $value;
		}
	}
	public function socialv_yith_wcwl_dequeue_font_awesome_styles()
	{
		wp_deregister_style('yith-wcwl-font-awesome');
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `socialv()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */

	public function lw_hide_sale_flash()
	{
		return false;
	}

	function socialv_product_archive_title($title)
	{
		if (is_post_type_archive('product')) $title = esc_html__("Shop", 'socialv');
		return $title;
	}

	function socialv_add_woocommerce_support()
	{
		add_theme_support('woocommerce');
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
		// Declare WooCommerce support.
	}


	function woocommerce_my_single_title()
	{ ?>
		<h2 itemprop="name" class="product_title entry-title"><span>
				<h5 class="socialv-product-title">
					<a href="<?php the_permalink(); ?>" class="socialv-product-title-link">
						<?php the_title() ?>
					</a>
				</h5>
			</span></h3>
		<?php
	}

	function socialv_loop_product_thumbnail($args = array())
	{
		if (is_shop() && (isset($this->socialv_option['woocommerce_shop']) && $this->socialv_option['woocommerce_shop'] == '1')  ||   $this->user_is_view_grid === '0') {
			get_template_part('template-parts/wocommerce/entry', 'listing');
		} else {
			get_template_part('template-parts/wocommerce/entry');
		}
	}

	// Change the format of fields with type, label, placeholder, class, required, clear, label_class, options
	function custom_wc_checkout_fields($fields)
	{

		//BILLING
		if ($fields['billing']['billing_first_name']) {
			$fields['billing']['billing_first_name']['label'] = false;
			$fields['billing']['billing_first_name']['placeholder'] = esc_html__("First Name *", "socialv");
		}
		if ($fields['billing']['billing_last_name']) {
			$fields['billing']['billing_last_name']['label'] = false;
			$fields['billing']['billing_last_name']['placeholder'] = esc_html__("Last Name *", "socialv");
		}
		if ($fields['billing']['billing_company']) {
			$fields['billing']['billing_company']['label'] = false;
			$fields['billing']['billing_company']['placeholder'] = esc_html__("Company *", "socialv");
		}
		if ($fields['billing']['billing_country']) {
			$fields['billing']['billing_country']['label'] = false;
			$fields['billing']['billing_country']['placeholder'] = esc_html__('Country *', 'socialv');
		}
		if ($fields['billing']['billing_address_1']) {
			$fields['billing']['billing_address_1']['label'] = false;
		}
		if ($fields['billing']['billing_city']) {
			$fields['billing']['billing_city']['label'] = false;
			$fields['billing']['billing_city']['placeholder'] = esc_html__('City *', 'socialv');
		}
		if ($fields['billing']['billing_state']) {
			$fields['billing']['billing_state']['label'] = false;
			$fields['billing']['billing_state']['placeholder'] = esc_html__('State *', 'socialv');
		}
		if ($fields['billing']['billing_postcode']) {
			$fields['billing']['billing_postcode']['label'] = false;
			$fields['billing']['billing_postcode']['placeholder'] = esc_html__('Postcode *', 'socialv');
		}
		if ($fields['billing']['billing_phone']) {
			$fields['billing']['billing_phone']['label'] = false;
			$fields['billing']['billing_phone']['placeholder'] = esc_html__("Phone Number *", "socialv");
		}
		if ($fields['billing']['billing_email']) {
			$fields['billing']['billing_email']['label'] = false;
			$fields['billing']['billing_email']['placeholder'] = esc_html__("E-mail Address *", "socialv");
		}

		return $fields;
	}

	// refresh mini cart ------------//
	function socialv_refresh_mini_cart_count($fragments)
	{
		ob_start();
		$empty = '';
		if (empty(WC()->cart->get_cart_contents_count())) {
			$empty = 'style=display:none';
		}
		?>
			<div id="mini-cart-count" <?php echo esc_attr($empty); ?> class="cart-items-count count">
				<?php echo (WC()->cart->get_cart_contents_count() > 9) ? '9+' : WC()->cart->get_cart_contents_count(); ?>
			</div>
		<?php
		$fragments['#mini-cart-count'] = ob_get_clean();
		return $fragments;
	}

	// Mini cart View Cart Buttou
	function custom_widget_cart_btn_view_cart()
	{
		echo socialv()->socialv_get_comment_btn($tag = "a",  $label = esc_html__("View Cart", "socialv"), $attr = array(
			'href' => wc_get_cart_url(),
			'class' => 'checkout wc-forward view_cart sample',
		));
	}

	//Mini Cart Checkout Button
	function custom_widget_cart_checkout()
	{
		echo socialv()->socialv_get_comment_btn($tag = "a",  $label = esc_html__("Checkout", "socialv"), $attr = array(
			'href' => wc_get_checkout_url(),
			'class' => 'checkout wc-forward',
		));
	}

	/* products loop_columns */
	function socialv_loop_columns()
	{
		if ($_COOKIE['product_view']['is_grid'] == '2') {
			return $_COOKIE['product_view']['col_no'];
		} elseif ($_COOKIE['product_view']['is_grid'] == '1') {
			return 1;
		}

		return 3; // 3 products per row
	}

	/* wishlist title hide */
	function socialv_wishlist_remove_title($args, $action, $action_params)
	{
		if (isset($args['wishlist_meta']) && $args['wishlist_meta']['is_default'] && !empty($args['wishlist_meta']['wishlist_name'])) {
			$args['page_title'] = $args['wishlist_meta']['wishlist_name'];
		}

		return $args;
	}

	/* hide terms and conditions toggle */
	function socialv_disable_terms()
	{
		wp_add_inline_script('wc-checkout', "jQuery( document ).ready( function() { jQuery( document.body ).off( 'click', 'a.woocommerce-terms-and-conditions-link' ); } );");
	}

	public function socialv_wc_template_part($template, $slug, $name)
	{
		if (is_shop() || is_product_category() || is_product_tag()) {
			$template_page = $_COOKIE['product_view']['is_grid'] == '2' ? 'entry.php' : 'entry-listing.php';
			$template_url = get_stylesheet_directory() . 'template-parts/wocommerce/' . $template_page;
			if (file_exists($template_url)) {
				return trailingslashit($template_url);
			}
			return trailingslashit(get_template_directory()) . 'template-parts/wocommerce/' . $template_page;
		}
		return $template;
	}

	public function socialv_product_perpage($per_page)
	{
		if (isset($this->socialv_option['woocommerce_product_per_page'])) {
			if (isset($_REQUEST['loaded_paged'])) {
				return $_REQUEST['loaded_paged'] * (int)$this->socialv_option['woocommerce_product_per_page'];
			}
			return (int)$this->socialv_option['woocommerce_product_per_page'];
		}
		return $per_page;
	}

	public function socialv_woof_hide_zero_term($val)
	{
		$new_term_arr = [];
		foreach ($val as $key => $value) {
			if ($value['count'] > 0) {
				$new_term_arr[$key] = $value;
			}
		}
		return $new_term_arr;
	}

	// Infinite Scroll Start 
	public function socialv_load_skeleton_ajax_handler()
	{
		$skeleton_path = get_template_directory() . '/template-parts/skeleton/';
		try {
			$data = array(
				'skeleton-grid' => file_get_contents($skeleton_path . 'skeleton-grid.php'),
				'skeleton-list' => file_get_contents($skeleton_path . 'skeleton-list.php'),
			);
			if ($data['skeleton-grid'] == false || $data['skeleton-list'] == false) {
				throw new Exception("File not Found");
			}
			wp_send_json_success($data);
		} catch (Exception $e) {
			wp_send_json_error($e->getMessage(), 404);
		}
	}

	public function socialv_loadmore_product_ajax_handler()
	{
		$args = json_decode(stripslashes($_POST['query']), true);
		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';
		$is_grid = $_POST['is_grid'] != 'true' ? 'listing' : 'grid';
		$is_switch = isset($_POST['is_switch']) && $_POST['is_switch'] == 'true' ? true : false;

		if ($is_switch) {
			for ($args['paged'] = 1; $args['paged'] <= $_POST['page']; $args['paged']++) {
				query_posts($args);
				if (have_posts()) :
					while (have_posts()) : the_post();

						get_template_part('template-parts/wocommerce/entry', $is_grid);

					endwhile;

				endif;
			}
		} else {
			query_posts($args);
			if (have_posts()) :
				while (have_posts()) : the_post();
					get_template_part('template-parts/wocommerce/entry', $is_grid);
				endwhile;
			endif;
		}
		die;
	}

	public function socialv_fetch_woof_filter_ajax_query()
	{
		session_start();
		$query = new \WP_Query($_SESSION['socialv_woof_query_ajax']);
		echo json_encode(array('query' => json_encode($_SESSION['socialv_woof_query_ajax']), 'max_page' => $query->max_num_pages));
		wp_reset_postdata();
		wp_reset_query();
		session_unset();
		die;
	}


	// Infinite Scroll End 
	public function wmpl_save_config_file($val)
	{
		if (class_exists('WooCommerce')) {
			$woof_setting = get_option('woof_settings');
			$woof_setting['per_page'] = (int)$val['woocommerce_product_per_page'];
			update_option('woof_settings', $woof_setting);
		}
	}

	// Slider Options
	function socialv_related_product_attr()
	{
		$socialv_options = get_option('socialv-options');
		$attr = [
			'data-slide'         => ($socialv_options['desk_number']) ? $socialv_options['desk_number'] : 4,
			'data-laptop'            => ($socialv_options['lap_number']) ? $socialv_options['lap_number'] : 3,
			'data-tab'     => ($socialv_options['tab_number']) ? $socialv_options['tab_number'] : 2,
			'data-mobile'     => ($socialv_options['mob_number']) ? $socialv_options['mob_number'] : 2,
			'data-autoplay'     => ($socialv_options['related_autoplay']) ? $socialv_options['related_autoplay'] : false,
			'data-loop'     => ($socialv_options['related_loop']) ? $socialv_options['related_loop'] : true,
			'data-speed'     => ($socialv_options['related_speed']) ? $socialv_options['related_speed'] : 2000,
		];

		foreach ($attr as $key => $value) :
			echo esc_attr($key . '= ' . $value . ' ');
		endforeach;
	}


	// Slider Options
	function socialv_slider_navigation()
	{ ?>
			<div class="iqonic-navigation">
				<div class="swiper-button-prev">
					<span class="text-btn">
						<i class="iconly-Arrow-Left-2 icli"></i>
					</span>
				</div>
				<div class="swiper-button-next">
					<span class="text-btn">
						<i class="iconly-Arrow-Right-2 icli"></i>
					</span>
				</div>
			</div>
	<?php
	}
}
