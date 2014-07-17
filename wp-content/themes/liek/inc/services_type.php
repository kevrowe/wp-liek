<?php /**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function liek_services_type() {

	$labels = array(
		'name'                => __( 'Services', '' ),
		'singular_name'       => __( 'Service', '' ),
		'add_new'             => _x( 'Add New Service', '', '' ),
		'add_new_item'        => __( 'Add New Service', '' ),
		'edit_item'           => __( 'Edit Service', '' ),
		'new_item'            => __( 'New Service', '' ),
		'view_item'           => __( 'View Service', '' ),
		'search_items'        => __( 'Search Services', '' ),
		'not_found'           => __( 'No Services found', '' ),
		'not_found_in_trash'  => __( 'No Services found in Trash', '' ),
		'parent_item_colon'   => __( 'Parent Service:', '' ),
		'menu_name'           => __( 'Services', '' ),
	);

	$args = array(
		'labels'                   => $labels,
		'hierarchical'        => false,
		'description'         => 'Services provided by Aqua-proof',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'menu_icon'           => '',
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title', 'editor' )
	);

	register_post_type( 'service', $args );
}

add_action( 'init', 'liek_services_type' );
 ?>