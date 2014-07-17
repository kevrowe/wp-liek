<?php
/**
 * Custom Homepage meta
 */
function liek_homepage_feature_metabox($post) {
	?>
	<div data-template="homepage.php" data-parent="homepage-feature">
		<?php
		wp_nonce_field( 'liek_homepage_feature_metabox', 'liek_homepage_feature_metabox_nonce' );

		for ($i = 0; $i < 3; $i++) {
			$image = get_post_meta( $post->ID, 'liek_homepage_feature_'.$i.'_image', true );
			$heading = get_post_meta( $post->ID, 'liek_homepage_feature_'.$i.'_heading', true );
			$caption = get_post_meta( $post->ID, 'liek_homepage_feature_'.$i.'_caption', true );
			?>
			<h4>Feature <?php echo $i+1 ?></h4>
			<p>
				<label for="<?php echo 'liek_homepage_feature_'.$i.'_image' ?>">Image</label>
				<?php
				$image_selector_args = array(
					'field_name' => 'liek_homepage_feature_'.$i.'_image',
					'field_id' => 'liek_homepage_feature_'.$i.'_image',
					'field_value' => esc_attr($image),
					'field_multiple'=> false);
				liek_image_selector($image_selector_args);
				?>
			</p>
			<p>
				<label for="<?php echo 'liek_homepage_feature_'.$i.'_heading' ?>">Heading</label>
				<input type="text" id="<?php echo 'liek_homepage_feature_'.$i.'_heading' ?>" name="<?php echo 'liek_homepage_feature_'.$i.'_heading' ?>" value="<?php echo esc_attr($heading); ?>" class="widefat"/>
			</p>
			<?php
			wp_editor( $caption, 'liek_homepage_feature_'.$i.'_caption', array('media_buttons'=>false, 'textarea_rows'=>4));
		}
		?>
	</div>
	<?php
}

/**
 * Called when a post is saved
 * @param int post_id
 * @return int post_id upon failure
 */
function liek_homepage_feature_metabox_save($post_id) {
	// Check nonce and for autosave
	if (!isset($_POST['liek_homepage_feature_metabox_nonce']) || !wp_verify_nonce( $_POST['liek_homepage_feature_metabox_nonce'], 'liek_homepage_feature_metabox' ) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
		return $post_id;
	}

	// Check permissions
	if ('page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) {
		return $post_id;
	} else {
		if (!current_user_can('edit_post', $post_id ))
			return $post_id;
	}

	// Sanitise and save data
	for ($i = 0; $i < 3; $i++) {
		$image = sanitize_file_name($_POST['liek_homepage_feature_'.$i.'_image']);
		$heading = sanitize_text_field($_POST['liek_homepage_feature_'.$i.'_heading']);
		$caption = $_POST['liek_homepage_feature_'.$i.'_caption'];

		update_post_meta( $post_id, 'liek_homepage_feature_'.$i.'_image', $image);
		update_post_meta( $post_id, 'liek_homepage_feature_'.$i.'_heading', $heading);
		update_post_meta( $post_id, 'liek_homepage_feature_'.$i.'_caption', $caption);
	}
}
add_action( 'save_post', 'liek_homepage_feature_metabox_save' );

function liek_homepage_fullwidth_metabox($post) {
	?>
	<div data-template="homepage.php" data-parent="homepage-fullwidth">
		<?php
		wp_nonce_field( 'liek_homepage_fullwidth_metabox', 'liek_homepage_fullwidth_metabox_nonce' );

		$content = get_post_meta( $post->ID, 'liek_homepage_fullwidth_content', true );
		wp_editor( $content, 'liek_homepage_fullwidth_content', array('media_buttons'=>true, 'textarea_rows'=>8));
		?>
	</div>
	<?php
}

/**
 * Called when a post is saved
 * @param int post_id
 * @return int post_id upon failure
 */
function liek_homepage_fullwidth_metabox_save($post_id) {
	// Check nonce and for autosave
	if (!isset($_POST['liek_homepage_fullwidth_metabox_nonce']) || !wp_verify_nonce( $_POST['liek_homepage_fullwidth_metabox_nonce'], 'liek_homepage_fullwidth_metabox' ) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
		return $post_id;
	}

	// Check permissions
	if ('page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) {
		return $post_id;
	} else {
		if (!current_user_can('edit_post', $post_id )){
			return $post_id;}
	}

	// Sanitise and save data
	$content = $_POST['liek_homepage_fullwidth_content'];
	update_post_meta( $post_id, 'liek_homepage_fullwidth_content', $content);
}
add_action( 'save_post', 'liek_homepage_fullwidth_metabox_save' );

function liek_homepage_metaboxes_add() {
	add_meta_box(
		'homepage-fullwidth',
		'Homepage Full Width Content',
		'liek_homepage_fullwidth_metabox',
		'page',
		'normal',
		'high',
		false);

	add_meta_box(
		'homepage-feature',
		'Homepage Feature',
		'liek_homepage_feature_metabox',
		'page',
		'normal',
		'high',
		false);

}
add_action( 'add_meta_boxes', 'liek_homepage_metaboxes_add' );
?>