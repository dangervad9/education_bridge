<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$sku_v = ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'docly' );

?>
<div class="pr_footer mt_40 mb-30">

    <ul class="product_meta list-unstyled">

        <?php do_action( 'woocommerce_product_meta_start' ); ?>

        <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

            <li class="sku_wrapper"> <span> <?php esc_html_e( 'SKU:', 'docly' ); ?> </span> <?php echo wp_kses_post($sku_v) ?></li>

        <?php endif; ?>

        <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<li class="posted_in"> <span>' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'docly' ) .'</span>' , '</li>' ); ?>

        <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<li class="tagged_as"><span>' . _n( 'Tag:', 'Tags: ', count( $product->get_tag_ids() ), 'docly' ) . '</span>', '</li>' ); ?>

        <?php do_action( 'woocommerce_product_meta_end' ); ?>

    </ul>

    <div class="share-link">
        <label> <?php esc_html_e( 'Share ON:', 'docly' ) ?> </label>
        <ul class="social-icon list-unstyled">
            <li><a class="facebook" title="<?php esc_attr_e( 'Facebook', 'docly' ) ?>" href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="social_facebook"> </i></a></li>
            <li><a class="twitter" title="<?php esc_attr_e( 'Twitter', 'docly' ) ?>" href="https://twitter.com/intent/tweet?text=<?php the_permalink(); ?>" target="_blank"><i class="social_twitter"> </i></a></li>
            <li><a class="linkedin" title="<?php esc_attr_e( 'Pinterest', 'docly' ) ?>'" href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink() ?>" target="_blank"><i class="social_pinterest"> </i></a></li>
            <li><a class="rss" title="<?php esc_attr_e( 'Linkedin', 'docly' ) ?>" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>" target="_blank"><i class="social_linkedin"> </i></a></li>
        </ul>
    </div>
</div>