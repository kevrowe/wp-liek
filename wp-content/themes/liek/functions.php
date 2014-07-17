<?php

/**
 * Navigation menu
 */
register_nav_menu( 'primary-nav', 'Primary Navigation' );

/**
 *	Search only posts
 */
function SearchFilter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}

	return $query;
}
add_filter('pre_get_posts','SearchFilter');


/**
* Create sidebars
* @param string|array  Builds Sidebar based off of 'name' and 'id' values.
*/
$homepage_sidebar_args = array(
	'name'          => __( 'Homepage Footer', '' ),
	'id'            => 'homepage-widgets',
	'description'   => 'Widget area on the bottom of the homepage template',
	'class'         => 'homepage-widgets',
	'before_widget' => '',
	'after_widget'  => ''
	);

register_sidebar( $homepage_sidebar_args );

/**
* Creates blog sidebar
* @param string|array  Builds Sidebar based off of 'name' and 'id' values.
*/
$blog_sidebar_args = array(
	'name'          => __( 'Blog Sidebar', '' ),
	'id'            => 'blog-sidebar',
	'description'   => 'Sidebar for the blog page',
	'class'         => 'blog-sidebar',
	'before_widget' => '<aside class="blog-widget">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>'
);

register_sidebar( $blog_sidebar_args );

/**
 *	Pagination
 */
function liek_blog_pagination($links) {
	if (sizeof($links) == 0) {
		return false;
	}
	ob_start();?>
	<div class="pagination">
		<?php
		foreach ($links as $index => $link) {
			?>
			<div class="page-link">
				<?php echo $link; ?>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * MCE Styles
 */
function liek_mce_buttons($buttons) {
	$buttons[] = 'styleselect';
	return $buttons;
}
add_filter('mce_buttons', 'liek_mce_buttons');

function liek_mce_before_init_insert_formats( $init_array ) {
	// Define the style_formats array
	$style_formats = array(
		// Each array child is a format with it's own settings
		array(
			'title' => 'Big Green Button',
			'inline' => 'a',
			'classes' => 'primary button success radius block',
			'exact' => false,
			'selector' => 'a'
			)
		);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'liek_mce_before_init_insert_formats' );

/**
 * Add custom header theme support
 */
function liek_add_custom_header() {
	$defaults = array(
		'default-image'          => get_template_directory_uri() . '/img/aquaproof.png',
		'random-default'         => false,
		'width'                  => 690,
		'height'                 => 236,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => false,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
		);

	add_theme_support( 'custom-header', $defaults );
}
add_action( 'init', 'liek_add_custom_header' );

/**
 * Custom image selector fields
 * @param array $args - [field_name, field_id, field_value, field_multiple]
 */
function liek_image_selector($args)
{
	extract($args);

	$field_class = empty($field_class) ? 'button button-large' : $field_class;
	$default_image_url = 'http://placehold.it/100x100&text=No Image';
	$style_string = 'cursor:pointer;display:block;margin:10px 0;max-height:100px;max-width:100px;';

	wp_enqueue_script( 'liek_image_selector', get_stylesheet_directory_uri() . '/js/app.admin.min.js', array('jquery', 'media-upload'), 1, true );
	$image_attr = array(
		'style'=> $style_string,
		'data-media-selector'=>'');
		?>
		<p>
			<?php
			$img = wp_get_attachment_image( $field_value, array(100), false, $image_attr );

			if (empty($img)) {
				?>
				<img src="<?=$default_image_url?>" alt="No image" style="<?=$style_string?>" data-media-selector>
				<?php
			} else {
				echo $img;
			}
			?>
			<input type="button" value="Choose Image" class="<?=$field_class?>" data-media-selector />
			<input type="hidden" name="<?=$field_name?>" id="<?=$field_id?>" value="<?=$field_value?>" data-media-target <?php echo $field_multiple ? 'data-media-multiple' : '' ?>/>
		</p>
		<?php
	}

/**
 * Custom Header Fields
 */
function custom_header_fields()
{
	?>
	<h3>Header Contact Information</h3>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="hide-if-no-js">
				<th scope="row"><?php _e( 'Telephone:' ); ?></th>
				<td>
					<p>
						<input type="text" name="header_telephone" id="header_telephone"
						value="<?php echo esc_attr( get_theme_mod( 'header_telephone', '' ) ); ?>" />
					</p>
				</td>
			</tr>
			<tr valign="top" class="hide-if-no-js">
				<th scope="row"><?php _e( 'Mobile:' ); ?></th>
				<td>
					<p>
						<input type="text" name="header_mobile" id="header_mobile"
						value="<?php echo esc_attr( get_theme_mod( 'header_mobile', '' ) ); ?>" />
					</p>
				</td>
			</tr>
			<tr valign="top" class="hide-if-no-js">
				<th scope="row"><?php _e( 'Email:' ); ?></th>
				<td>
					<p>
						<input type="text" name="header_email" id="header_email"
						value="<?php echo esc_attr( get_theme_mod( 'header_email', '' ) ); ?>" />
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}
add_action('custom_header_options', 'custom_header_fields');

/**
 * Add custom header save functions
 */
function save_custom_header_fields()
{
	if ( isset( $_POST['header_telephone'] ) && isset( $_POST['header_mobile'] )
		&& isset($_POST['header_email']) )
	{
		check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );

		if ( current_user_can('manage_options') ) {
			set_theme_mod( 'header_telephone', $_POST['header_telephone'] );
			set_theme_mod( 'header_mobile', $_POST['header_mobile'] );
			set_theme_mod( 'header_email', $_POST['header_email'] );
		}
	}
	return;
}
add_action('admin_head', 'save_custom_header_fields');

/**
 * Misc. Hooks
 */
function add_custom_admin_css() {
	wp_enqueue_style('custom-admin-css', get_stylesheet_directory_uri() . '/css/admin.css', false, false, false);
}

add_action( 'admin_head', 'add_custom_admin_css' );
add_theme_support( 'post-thumbnails' );

/**
 * Custom Page Meta
 */
include 'inc/homepage_meta.php';
include 'inc/contact_meta.php';

/**
 * Custom Post Types
 */
include 'inc/associate_type.php';
include 'inc/work_type.php';
include 'inc/services_type.php';
?>