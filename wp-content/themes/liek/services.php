<?php
/**
 * Template Name: Services template
 */

get_header();
$post_args = array(
	'posts_per_page' => -1,
	'post_type' => 'service');

$services_posts = get_posts( $post_args );
?>
<section>
	<?php
	for ($i = 0; $i < sizeof($services_posts); $i += 2) :
		$service_post = $services_posts[$i];
	?>
	<div class="row">
		<article class="service columns large-6">
			<h1 class="panel-dark slide-trigger" data-toggle="service"><?php echo $service_post->post_title; ?></h1>
			<div class="slide-down mobile-hide" data-toggle-target="service">
				<?php echo wpautop($service_post->post_content, true); ?>
			</div>
		</article>
		<?php
		if (sizeof($services_posts) > $i+1) :
			$service_post = $services_posts[$i+1];
		?>
		<article class="service columns large-6">
			<h1 class="panel-dark slide-trigger" data-toggle="service"><?php echo $service_post->post_title; ?></h1>
			<div class="slide-down mobile-hide" data-toggle-target="service">
				<?php echo wpautop($service_post->post_content, true); ?>
			</div>
		</article>
	<?php endif; ?>
</div>
<?php
endfor;?>
</section>
<?php
get_footer();
?>