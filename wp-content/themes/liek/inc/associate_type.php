<?php

/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function liek_associates_post_type() {

	$labels = array(
		'name'                => __( 'Associates', '' ),
		'singular_name'       => __( 'Associate', '' ),
		'add_new'             => _x( 'Add New Associate', '', '' ),
		'add_new_item'        => __( 'Add New Associate', '' ),
		'edit_item'           => __( 'Edit Associate', '' ),
		'new_item'            => __( 'New Associate', '' ),
		'view_item'           => __( 'View Associate', '' ),
		'search_items'        => __( 'Search Associates', '' ),
		'not_found'           => __( 'No Associates found', '' ),
		'not_found_in_trash'  => __( 'No Associates found in Trash', '' ),
		'parent_item_colon'   => __( 'Parent Associate:', '' ),
		'menu_name'           => __( 'Associates', '' ),
		);

	$associates_args = array(
		'labels'                   => $labels,
		'hierarchical'        => false,
		'description'         => 'Associates listed in the associates page template',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'menu_icon'           => '',
		'show_in_nav_menus'   => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title', 'thumbnail', 'excerpt',
			'page-attributes', 'post-formats')
		);

	register_post_type( 'associate', $associates_args );

	function liek_associates_metabox($post) {
		wp_nonce_field( 'liek_associates_metabox', 'liek_associates_metabox_nonce' );
		?>
		<p>
			<label for="liek_associates_website_url">Url:</label>
			<input type="text" id="liek_associates_website_url"
				name="liek_associates_website_url"
				value="<?php echo get_post_meta( $post->ID, 'liek_associates_website_url', true ) ?>"
				class="widefat" />
		</p>
		<?php
	}


	/**
	 * Called when a post is saved
	 * @param int post_id
	 * @return int post_id upon failure
	 */
	function liek_associates_metabox_save($post_id) {
		// Check nonce and for autosave
		if (!isset($_POST['liek_associates_metabox_nonce']) || !wp_verify_nonce( $_POST['liek_associates_metabox_nonce'], 'liek_associates_metabox' ) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
			return $post_id;
		}

		// Check permissions
		if ('associates' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) {
			return $post_id;
		} else {
			if (!current_user_can('edit_post', $post_id ))
				return $post_id;
		}

		// Sanitise and save data
		update_post_meta( $post_id, 'liek_associates_website_url', $_POST['liek_associates_website_url']);
	}
	add_action( 'save_post', 'liek_associates_metabox_save' );

	function liek_associates_metabox_add() {
		add_meta_box(
			'associates-custom',
			'Associate Info',
			'liek_associates_metabox',
			'associate',
			'advanced',
			'high',
			false);
	}
	add_action( 'add_meta_boxes', 'liek_associates_metabox_add' );
}

add_action( 'init', 'liek_associates_post_type' );

?>