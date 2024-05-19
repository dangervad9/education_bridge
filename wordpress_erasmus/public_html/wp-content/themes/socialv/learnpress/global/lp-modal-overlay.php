<?php
/**
 * Template for displaying modal overlay.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/global/lp-modal-overlay.php.
 *
 * @author  tungnx
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

?>

<div class="lp-modal-dialog">
	<div class="lp-modal-content">
		<div class="lp-modal-header">
			<h3 class="modal-title"><?php esc_html_e('Modal title' , 'socialv'); ?></h3>
		</div>
		<div class="lp-modal-body">
			<div class="main-content"><?php esc_html_e('Main Content' , 'socialv'); ?></div>
		</div>
		<div class="lp-modal-footer">
			<button type="button" class="btn socialv-btn-danger btn-no"><?php esc_html_e( 'No', 'socialv' ); ?></button>
			<button type="button" class="btn socialv-btn-primary btn-yes"><?php esc_html_e( 'Yes', 'socialv' ); ?></button>
		</div>
	</div>
</div>
