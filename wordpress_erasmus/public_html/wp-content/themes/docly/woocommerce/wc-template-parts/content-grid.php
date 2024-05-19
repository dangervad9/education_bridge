<?php
global $wc_loop_i;
global $product;
$opt = get_option( 'docly_opt' );
$column = wc_get_loop_prop( 'columns' );
$is_product_lightbox = isset($opt['is_product_lightbox']) ? $opt['is_product_lightbox'] : '1';
$is_add_to_cart = isset($opt['is_add_to_cart']) ? $opt['is_add_to_cart'] : '1';

switch ($column) {
    case '3':
        $col = '4';
        $image_size = 'docly_270x320';
        break;
    case '4':
        $col = '3';
        $image_size = 'docly_300x320';
        break;
    case '2':
        $col = '6';
        $image_size = 'full';
        break;
    default:
        $col = '4';
        $image_size = 'docly_270x320';
        break;
}
?>
<div <?php wc_product_class( 'col-md-'.$col.' col-sm-6' ); ?>>
    <div class="single_product_item">
        <a class="product_img" href="<?php the_permalink() ?>">
            <?php the_post_thumbnail($image_size, array( 'class' => 'img-fluid')) ?>
        </a>
        <div class="single_pr_details">
            <a href="<?php the_permalink() ?>">
                <h5> <?php the_title() ?> </h5>
            </a>
            <?php woocommerce_template_loop_price(); ?>
            <?php woocommerce_template_single_rating() ?>
        </div>
    </div>
</div>