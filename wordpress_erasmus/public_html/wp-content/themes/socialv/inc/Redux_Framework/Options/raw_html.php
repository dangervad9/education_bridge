<?php $theme_setup_page = admin_url("themes.php?page=one-click-demo-import"); ?>
<span class="welcome-back"><?php esc_html_e('Welcome back!','socialv'); ?></span>
<div class="dashboard-main-wrap">
    <div class="dashboard-main">
        <h4 class="redux-title"><?php esc_html_e('Experience Our Live Demo Of SocialV Wordpress Theme.','socialv'); ?></h4>
        <p class="redux-desc"><?php esc_html_e('SocialV is the perfect theme for social networking community BuddyPress theme.','socialv'); ?></p>
        <a href="<?php echo esc_url("https://wordpress.iqonic.design/product/wp/socialv/"); ?>" target="_blank" class="redux-btn"><?php esc_html_e('Live Demo','socialv'); ?></a>
    </div>
    <div class="redux-feature-main">
        <div class="redux-feature-box">
            <div class="icon-box-main">
                <i class="custom-Download"></i>
            </div>
            <h5 class="redux-title"><?php esc_html_e('Demo Import','socialv'); ?></h5>
            <p class="redux-desc"><?php esc_html_e('Import your demo content, widgets and theme settings with one click.','socialv'); ?></p>
            <a href="<?php echo esc_url($theme_setup_page); ?>" target="_blank" class="redux-btn"><?php esc_html_e('Start Import','socialv'); ?></a>
        </div>
        <div class="redux-feature-box">
            <div class="icon-box-main">
                <i class="custom-doc"></i>
            </div>
            <h5 class="redux-title"><?php esc_html_e('documentation','socialv'); ?></h5>
            <p class="redux-desc"><?php esc_html_e('Document include all the following except of theme, plugins, widgets & theme settings.','socialv'); ?></p>
            <a href="<?php echo esc_url("https://assets.iqonic.design/documentation/wordpress/socialv-doc/index.html"); ?>" target="_blank" class="redux-btn"><?php esc_html_e('Go To Documentation','socialv'); ?></a>
        </div>
        <div class="redux-feature-box">
            <div class="icon-box-main">
                <i class="custom-support"></i>
            </div>
            <h5 class="redux-title"><?php esc_html_e('need help?','socialv'); ?></h5>
            <p class="redux-desc"><?php esc_html_e("Need help with something you can't find an answer to in our documentation? Open Support Ticket.","socialv"); ?></p>
            <a href="<?php echo esc_url("https://iqonic.desky.support/"); ?>" target="_blank" class="redux-btn"><?php esc_html_e('Submit a Ticket','socialv'); ?></a>
        </div>
    </div>
</div>