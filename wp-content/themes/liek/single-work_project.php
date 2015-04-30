<?php

get_header();

// Get images
$thumbnails = array();
$largeUrls = array();

for ($i = 0; $i < 3; $i++) {
	$imageId = get_post_meta( $post->ID, 'liek_work_image_'.$i.'_image', true );
	$largeUrl = wp_get_attachment_image_src( $imageId, false, false );
	$thumbnail = wp_get_attachment_image( $imageId, array(320,240), false, array('data-large-url'=>$largeUrl[0], 'class' => 'feature-image-item') );
	array_push($thumbnails, $thumbnail);
	array_push($largeUrls, $largeUrl);
}

?>

<div class="row">
	<div class="columns large-12" data-ajax-content>
		<h2><?php echo $post->post_title ?></h2>
		<?php
		echo wpautop( $post->post_content, false );
		foreach ($thumbnails as $thumbnail) {
			echo $thumbnail;
		}
		?>
		<div class="feature-image">
			<img src="<?php echo $largeUrls[0][0]; ?>">
		</div>
	</div>
</div>
<?php
get_footer();
?>