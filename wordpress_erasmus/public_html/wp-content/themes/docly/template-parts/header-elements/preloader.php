<?php
// Theme settings options
$opt = get_option('docly_opt' );
$preloader_quotes = !empty($opt['preloader_quotes']) ? $opt['preloader_quotes'] : '';
wp_enqueue_script('preloader');
?>

<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="round_spinner">
            <div class="spinner"></div>
            <?php if ( !empty($opt['preloader_logo']['url']) ) : ?>
                <div class="text">
                    <?php echo "<img src='{$opt['preloader_logo']['url']}' alt='{$opt['logo_title']}'>"; ?>
                    <?php if ( !empty($opt['logo_title']) ) : ?>
                        <h4><?php echo wp_kses_post($opt['logo_title']) ?></h4>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if ( !empty($opt['preloader_title']) ) : ?>
            <h2 class="head"> <?php echo wp_kses_post($opt['preloader_title']) ?> </h2>
        <?php endif; ?>
        <?php if ( is_array($preloader_quotes) ) : ?>
            <p>
                <?php echo esc_html($preloader_quotes[rand(0, count($preloader_quotes) - 1)]); ?>
            </p>
        <?php endif; ?>
    </div>
</div>