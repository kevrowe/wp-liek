<?php
/**
 * Template Name: Blog template
 */

get_header();
$permalinkUrl = post_permalink( $post->ID, false );
$returnUrl = strstr($_SERVER['HTTP_REFERER'], 'blog') > -1
				? $_SERVER['HTTP_REFERER']
				: '/blog';
?>
<div class="row">
	<div class="columns large-12">
		<div class="panel-dark">
			<a href="<?php echo $returnUrl ?>" class="back-link">Return to blog</a>
		</div>
	</div>
	<div class="columns large-12">
		<?php
		if ( have_posts() ) :
			previous_posts_link();
		next_posts_link();
		while ( have_posts() ) :
			the_post(); ?>
		<article class="blog-post">
			<div class="row">
				<div class="columns large-4 small-5 tiny-12 post-image">
					<?php echo get_the_post_thumbnail( $post->ID, false, false ); ?>
				</div>
				<div class="columns large-8 small-7 tiny-12">
					<h1><?php echo the_title(); ?></h1>
					<div class="timestamp">
						<?php echo the_date( ); ?>
					</div>
					<div class="tags">
						<p>
							<?php the_tags( false, false, false); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="columns large-12">
					<?php echo the_content( 'Read more', false ); ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
	<!-- post navigation -->
	<?php else: ?>
		<article class="blog-post">
			<h1>Aqua-proof Blog</h1>
			<p>No posts to display, <a href="/blog">back to the blog</a>.</p>
		</article>
	<?php endif; ?>
	</div>
	<div class="columns large-12">
		<div class="panel-dark">
			<a href="<?php echo $returnUrl ?>" class="back-link">Return to blog</a>
		</div>
	</div>
</div>
<?php get_footer(); ?>