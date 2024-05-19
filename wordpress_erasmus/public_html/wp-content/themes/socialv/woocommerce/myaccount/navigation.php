<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
echo "<div class='row'>";
do_action( 'woocommerce_before_account_navigation' );

$icon_array = [
	'Dashboard' 		=> 'icon-dashboard me-3',
	'Orders'			=> 'icon-list-solid me-3',
    'Subscriptions'     => 'iconly-Message icli me-3',
    'Downloads'     => 'icon-download me-3',
    'Addresses'     => 'icon-location me-3',
    'Payment methods'     => 'iconly-Wallet icli mr-3',
    'Account details'     => 'icon-user-solid me-3',
    'Logout'     => 'icon-sign-out me-3',
];

?>

<div class="col-lg-3 ">
    <nav class="woocommerce-MyAccount-navigation">
        <ul>
            <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                   <?php 
                   if(!empty($icon_array[$label])){ ?>
                    <i class="<?php echo esc_attr($icon_array[$label]); ?> mr-3"></i>
                    <?php } ?>
                    <span><?php echo esc_html( $label ); ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>


<?php do_action( 'woocommerce_after_account_navigation' ); ?>