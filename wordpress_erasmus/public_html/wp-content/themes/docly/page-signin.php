<?php
/**
 * Template Name: Sign in Page
 */

get_header('empty');

// Left Column
$left_title = '';
$top_ornament = '';
$bottom_ornament = '';
$featured_image = '';
// Right Column
$right_title = '';
$right_subtitle = '';
$submit_btn_label = '';

if ( function_exists('get_field') ) {
	// Left Column
	$left_title = get_field('left_title');
	$top_ornament = get_field('top_ornament');
	$bottom_ornament = get_field('bottom_ornament');
	$featured_image = get_field('featured_image');
	// Right Column
	$right_title = get_field('right_title');
	$right_subtitle = get_field('right_subtitle');
	$submit_btn_label = get_field('submit_button_label');
}
?>

	<section class="signup_area signup_area_height">
		<div class="row ml-0 mr-0">
			<div class="sign_left signin_left">
				<?php echo !empty($left_title) ? "<h2> {$left_title} </h2>" : ''; ?>
				<?php
				if ( !empty($top_ornament['id']) ) {
					echo wp_get_attachment_image($top_ornament['id'], 'full');
				} else { ?>
					<img src="<?php echo DOCLY_DIR_IMG ?>/sign-up/top_ornamate.png" class="position-absolute top" alt="<?php esc_attr_e('top ornament', 'docly'); ?>">
					<?php
				}
				if ( !empty($bottom_ornament['id']) ) {
					echo wp_get_attachment_image($bottom_ornament['id'], 'full');
				} else { ?>
					<img src="<?php echo DOCLY_DIR_IMG ?>/sign-up/bottom_ornamate.png" class="position-absolute bottom" alt="<?php esc_attr_e('bottom ornament', 'docly'); ?>">
					<?php
				}
				if ( !empty($featured_image['id']) ) {
					echo wp_get_attachment_image($featured_image['id'], 'full');
				} else { ?>
					<img src="<?php echo DOCLY_DIR_IMG ?>/sign-up/door.png" class="position-absolute middle wow fadeInRight" alt="<?php esc_attr_e('door', 'docly'); ?>">
					<?php
				}
				?>
				<div class="round wow zoomIn" data-wow-delay="0.2s"></div>
			</div>
			<div class="sign_right signup_right">
				<div class="sign_inner signup_inner">
					<?php
					if ( !is_user_logged_in() ) :
						$current_user = wp_get_current_user();
						?>
						<div class="text-center">
							<?php echo !empty($right_title) ? "<h3> {$right_title} </h3>" : ''; ?>
							<?php echo !empty($right_subtitle) ? wpautop(wp_kses_post($right_subtitle)) : ''; ?>
						</div>
						<form action="<?php echo esc_url(home_url( '/')); ?>wp-login.php" class="row login_form" method="post">
							<div class="col-lg-12 form-group">
								<label for="username" class="small_text"> <?php esc_html_e( 'Username', 'docly' ); ?> </label>
								<input type="text" class="form-control" id="username" name="log" placeholder="<?php esc_attr_e('Enter the username here.', 'docly'); ?>">
							</div>
							<div class="col-lg-12 form-group">
								<label for="pwd" class="small_text"> <?php esc_html_e( 'Password', 'docly' ); ?> </label>
								<div class="confirm_password">
									<input id="pwd" name="pwd" type="password" class="form-control" autocomplete="off" placeholder="********">
									<a href="<?php echo esc_url(home_url( '/')) . '/wp-login.php?action=lostpassword'; ?>" class="forget_btn">
										<?php esc_html_e( 'Forgotten password?', 'docly' ); ?>
									</a>
								</div>
							</div>
							<div class="col-lg-12 text-center">
								<button type="submit" class="btn action_btn thm_btn">
									<?php echo !empty($submit_btn_label) ? esc_html($submit_btn_label) : esc_html__('Sign in', 'docly'); ?>
								</button>
							</div>
						</form>
					<?php else : ?>
						<div class="text-center">
							<h2 class="signup_title">
								<?php esc_html_e('Welcome ', 'docly'); echo esc_html($current_user->display_name); ?>
							</h2>
							<br>
							<p> <?php esc_html_e('You are logged in', 'docly'); ?> </p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

<?php
get_footer('empty');