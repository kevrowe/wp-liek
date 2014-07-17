<?php
/**
 * Template Name: Content page template
 */

get_header();
?>
<div class="row">
	<div class="columns large-12">
		<article class="blog-post">
			<div class="row">
				<?php if (has_post_thumbnail( $post->ID )): ?>
					<div class="columns large-4 small-5 tiny-12 post-image">
						<?php echo get_the_post_thumbnail( $post->ID, false, false ); ?>
					</div>
				<?php endif; ?>
				<div class="columns large-12">
					<h1><?php echo the_title(); ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="columns large-12">
					<?php echo wpautop($post->post_content, true); ?>
				</div>
			</div>
		</article>
	</div>
</div>
<?php get_footer(); ?>