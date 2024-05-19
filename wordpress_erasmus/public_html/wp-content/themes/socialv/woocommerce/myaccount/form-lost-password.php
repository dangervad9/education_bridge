<?php

/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form');
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">
        <div class="col-lg-6 mx-auto">
            <div class="card-main">
                <div class="card-inner">
                    <div class="socialv-login-form">
                        <p class="mb-4"><?php echo apply_filters('woocommerce_lost_password_message', esc_html__('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'socialv')); ?></p>
                        <div class="forgetpwd-email">
                            <label for="user_email"><?php esc_html_e('Username or Email*', 'socialv'); ?></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="iconly-Message icli"></i></span>
                                <input class="woocommerce-Input woocommerce-Input--text form-control" type="text" name="user_login" id="user_login" placeholder="<?php echo esc_attr('Enter Username or Email*', 'socialv'); ?>" autocomplete="username" required />
                            </div>
                        </div>
                        <div class="clear"></div>

                        <?php do_action('woocommerce_lostpassword_form'); ?>
                        <div class="socialv-auth-button mb-0">
                            <input type="hidden" name="wc_reset_password" value="true" />
                            <button type="submit" class="w-100 socialv-button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="<?php esc_attr_e('Reset password', 'socialv'); ?>">
                                <?php esc_html_e('Reset password', 'socialv'); ?>
                            </button>
                        </div>
                        <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
                    </div>
                </div>
            </div>
        </div>
</form>
<?php
do_action('woocommerce_after_lost_password_form');
