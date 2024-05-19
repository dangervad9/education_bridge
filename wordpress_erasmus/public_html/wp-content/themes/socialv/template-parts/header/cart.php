<?php

/**
 * Template part for displaying the Messages
 *
 * @package socialv
 */
?>
<div class="dropdown dropdown-user-cart">
	<button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="iconly-Bag icli" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php esc_attr_e('Shopping Cart', 'socialv'); ?>"></i>
		<div class="basket-item-count" style="display: inline;">
			<span id="mini-cart-count">
				<?php if (WC()->cart && (WC()->cart->get_cart_contents_count() > 0)) : ?>
					<span class="cart-items-count count">
						<?php echo (WC()->cart) ? WC()->cart->get_cart_contents_count() : ''; ?>
					</span>
				<?php endif; ?>
			</span>
		</div>
	</button>

	<div class="dropdown-menu dropdown-menu-mini-cart">
		<div class="item-heading">
			<h5 class="heading-title"><?php esc_html_e('Shopping Cart', 'socialv'); ?></h5>
		</div>
		<div class="widget_shopping_cart_content">
			<?php
			if (function_exists("woocommerce_mini_cart") && WC()->cart) {
				woocommerce_mini_cart();
			}
			?>
		</div>
	</div>
</div>