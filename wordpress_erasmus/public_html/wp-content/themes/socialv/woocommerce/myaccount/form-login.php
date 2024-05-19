<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>

    <div class="u-columns col2-set row" id="customer_login">

        <div class="u-column1 col-lg-6">

        <?php else : ?>
            <div class="col-lg-6 mx-auto">
            <?php endif; ?>
            <div class="card-main">
                <div class="card-inner">
                    <div class="socialv-login-form">
                        <h5 class="socialv-wc-login-title"><?php esc_html_e('Login', 'socialv'); ?></h5>

                        <form class="woocommerce-form woocommerce-form-login login mb-0" method="post">
                            <?php do_action('woocommerce_login_form_start'); ?>
                            <p class="login-username"><label for="username"><?php esc_html_e('Username or Email Address*', 'socialv'); ?></label>
                            <div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Add-User icli"></i></span><input type="text" class="userform form-control" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e('Username or email address *', 'socialv'); ?>" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required/></div>
                            </p>
                            <p class="login-password"><label for="password"><?php esc_html_e('Password', 'socialv'); ?></label>
                            <div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Lock icli"></i></span><input type="password" name="password" id="password" autocomplete="current-password" class="password form-control" placeholder="<?php esc_attr_e('Password', 'socialv'); ?>" required/></div>
                            </p>
                            <?php do_action('woocommerce_login_form'); ?>

                            <div class="d-flex flex-sm-row justify-content-between align-items-center">
                                <p class="login-remember"><label><input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e('Remember Me', 'socialv'); ?></label></p>
                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="forgot-pwd"><?php esc_html_e('Lost your password?', 'socialv'); ?></a>
                            </div>
                            <p class="login-submit mb-0">
                                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                                <!-- login button -->
                                <button type="submit" class="w-100 socialv-button woocommerce-Button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e('Log in', 'socialv'); ?>">
                                    <?php esc_html_e('Log in', 'socialv'); ?>
                                </button>
                            </p>
                            <?php do_action('woocommerce_login_form_end'); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>

            </div>

            <div class="u-column2 col-lg-6 mt-4 mt-lg-0">
                <div class="card-main">
                    <div class="card-inner">
                        <div class="socialv-login-form">
                            <h5 class="socialv-wc-login-title"><?php esc_html_e('Register', 'socialv'); ?></h5>

                            <form method="post" class="woocommerce-form woocommerce-form-register register mb-0" <?php do_action('woocommerce_register_form_tag'); ?>>

                                <?php do_action('woocommerce_register_form_start'); ?>

                                <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                                    <p class="login-username"><label for="username"><?php esc_html_e('Username *', 'socialv'); ?></label>
                                    <div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Add-User icli"></i></span><input type="text" required="" class="userform form-control" name="username" id="reg_username" autocomplete="username" placeholder="<?php echo esc_attr('Username *', 'socialv'); ?>" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /></div>
                                    </p>
                                <?php endif; ?>
                                <p class="login-username"><label for="email"><?php esc_html_e('Email address *', 'socialv'); ?></label>
                                <div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Message icli"></i></span><input type="email" class="email form-control" name="email" id="reg_email" autocomplete="email" placeholder="<?php echo esc_attr('Email address *', 'socialv'); ?>" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required /></div>
                                </p>

                                <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                                    <p class="login-username"><label for="password"><?php esc_html_e('Password *', 'socialv'); ?></label>
                                    <div class="input-group mb-3"><span class="input-group-text"><i class="iconly-Lock icli"></i></span><input type="password" class="password form-control" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php echo esc_attr('Password *', 'socialv'); ?>" required /></div>
                                    </p>
                                <?php endif; ?>

                                <?php do_action('woocommerce_register_form'); ?>

                                <p class="login-submit mb-0">
                                    <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                                    <!-- register button  -->
                                    <button type="submit" class="w-100 socialv-button woocommerce-Button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="register" value="<?php esc_attr_e('Register', 'socialv'); ?>">
                                        <?php esc_html_e('Register', 'socialv'); ?>
                                    </button>
                                </p>

                                <?php do_action('woocommerce_register_form_end'); ?>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
    </div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form');
