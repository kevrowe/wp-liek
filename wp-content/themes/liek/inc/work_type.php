<?php

/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function liek_work_project_post_type() {

	$work_project_labels = array(
		'name'                => __( 'Work Projects', '' ),
		'singular_name'       => __( 'Work Project', '' ),
		'add_new'             => _x( 'Add New Work Project', '', '' ),
		'add_new_item'        => __( 'Add New Work Project', '' ),
		'edit_item'           => __( 'Edit Work Project', '' ),
		'new_item'            => __( 'New Work Project', '' ),
		'view_item'           => __( 'View Work Project', '' ),
		'search_items'        => __( 'Search Work Projects', '' ),
		'not_found'           => __( 'No Work Projects found', '' ),
		'not_found_in_trash'  => __( 'No Work Projects found in Trash', '' ),
		'parent_item_colon'   => __( 'Parent Work Project:', '' ),
		'menu_name'           => __( 'Work Projects', '' ),
		);

	$work_project_args = array(
		'labels'                   => $work_project_labels,
		'hierarchical'        => false,
		'description'         => 'Work projects to display jobs before/after',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 6,
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
			'title', 'editor', 'thumbnail' )
		);

	register_post_type( 'work_project', $work_project_args );

	function liek_work_meta_box($post) {
		wp_nonce_field( 'liek_work_meta_box', 'liek_work_meta_box_nonce' );
		?>
		<em>Work Images and Feature Image should fit 4:3 aspect ratio and be of 600x450 resolution</em>
		<div class="work-item-images">
			<?php
			for ($i = 0; $i < 3; $i++) {
				$image = get_post_meta( $post->ID, 'liek_work_image_'.$i.'_image', true );
				?>
				<div>
					<h4>Image <?php echo $i+1 ?></h4>
					<p>
						<?php
						$image_selector_args = array(
							'field_name' => 'liek_work_image_'.$i.'_image',
							'field_id' => 'liek_work_image_'.$i.'_image',
							'field_value' => esc_attr($image),
							'field_multiple'=> false);
						liek_image_selector($image_selector_args);
						?>
					</p>
				</div>
				<?php
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
	function liek_work_meta_box_save($post_id) {
		// Check nonce and for autosave
		if (!isset($_POST['liek_work_meta_box_nonce']) || !wp_verify_nonce( $_POST['liek_work_meta_box_nonce'], 'liek_work_meta_box' ) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
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
		for ($i = 0; $i < 3; $i++) {
			update_post_meta( $post_id, 'liek_work_image_'.$i.'_image', $_POST['liek_work_image_'.$i.'_image'] );
		}
	}
	add_action( 'save_post', 'liek_work_meta_box_save' );

	function liek_work_meta_box_add() {
		add_meta_box(
			'work-custom',
			'Work Images',
			'liek_work_meta_box',
			'work_project',
			'normal',
			'high',
			false);
	}
	add_action( 'add_meta_boxes', 'liek_work_meta_box_add' );
}

add_action( 'init', 'liek_work_project_post_type' );


?>