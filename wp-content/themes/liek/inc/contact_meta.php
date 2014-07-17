<?php
/**
 * Custom Homepage meta
 */
function liek_contact_page_metabox($post) {
	?>
	<div data-template="contact.php" data-parent="contact-page">
		<?php
		wp_nonce_field( 'liek_contact_page_metabox', 'liek_contact_page_metabox_nonce' );
		?>
		<p>
			<label for="liek_contact_page_map_coords">Coordinates: </label>
			<p><i>Create and copy from <a href="http://www.the-di-lab.com/polygon/">http://www.the-di-lab.com/polygon/</a></i></p>
			<textarea rows="10" name="liek_contact_page_map_coords" id="liek_contact_page_map_coords" class="widefat"><?php
			echo get_post_meta( $post->ID, 'liek_contact_page_map_coords', true )
			?></textarea>
		</p>
		<p>
			<p>Message appearing when area is clicked:</p>
			<?php
			wp_editor( get_post_meta( $post->ID, 'liek_contact_page_map_tooltip', true ), 'liek_contact_page_map_tooltip', array('media_buttons'=>false, 'textarea_rows'=>6) );
			?>
		</p>
		<p>
			<label for="liek_contact_page_mailto" title="Email address the form submissions are sent to">Target email address:</label>
			<input placeholder="e.g. example@url.com" class="widefat" type="email" id="liek_contact_page_mailto" name="liek_contact_page_mailto" value="<?php echo get_post_meta( $post->ID, 'liek_contact_page_mailto', true ) ?>" />
		</p>
		<p>
			The message appearing after the contact form has been submitted:
		</p>
		<?php
		wp_editor( get_post_meta( $post->ID, 'liek_contact_page_form_message', true ), 'liek_contact_page_form_message', array('media_buttons'=>false) );
		?>
	</div>
	<?php
}

/**
 * Called when a post is saved
 * @param int post_id
 * @return int post_id upon failure
 */
function liek_contact_page_metabox_save($post_id) {
	// Check nonce and for autosave
	if (!isset($_POST['liek_contact_page_metabox_nonce']) || !wp_verify_nonce( $_POST['liek_contact_page_metabox_nonce'], 'liek_contact_page_metabox' ) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
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
	update_post_meta( $post_id, 'liek_contact_page_form_message', $_POST['liek_contact_page_form_message']);
	update_post_meta( $post_id, 'liek_contact_page_mailto', $_POST['liek_contact_page_mailto']);
	update_post_meta( $post_id, 'liek_contact_page_map_coords', $_POST['liek_contact_page_map_coords']);
	update_post_meta( $post_id, 'liek_contact_page_map_tooltip', $_POST['liek_contact_page_map_tooltip']);
}
add_action( 'save_post', 'liek_contact_page_metabox_save' );

function liek_contact_page_metabox_add() {
	add_meta_box(
		'contact-page',
		'Contact Info',
		'liek_contact_page_metabox',
		'page',
		'normal',
		'high',
		false);
}
add_action( 'add_meta_boxes', 'liek_contact_page_metabox_add' );
?>