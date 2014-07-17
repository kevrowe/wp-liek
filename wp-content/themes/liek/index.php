<?php
/**
 * Template Name: Blog template
 */

get_header();
$paginationLinks = paginate_links( array(
	'base' => str_replace( 99999999, '%#%', esc_url( get_pagenum_link( 99999999 ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
	'prev_text' => 'Previous',
	'next_text' => 'Next',
	'type' => 'array'
	) );

?>
<div class="row">
	<div class="columns large-8">
		<?php
		if ( have_posts() ) :
			echo liek_blog_pagination($paginationLinks);
			while ( have_posts() ) :
				the_post();
				$permalinkUrl = post_permalink( $post->ID, false );
 ?>
		<article class="blog-post-macro">
			<div class="row">
				<div class="columns large-4 small-3 tiny-12 post-image">
					<a href="<?php echo $permalinkUrl ?>">
						<?php echo get_the_post_thumbnail( $post->ID, false, false ); ?>
					</a>
				</div>
				<div class="columns large-8 small-9 tiny-12">
					<h1><a href="<?php echo $permalinkUrl ?>"><?php echo the_title(); ?></a></h1>
					<div class="timestamp">
						<?php echo the_date( ); ?>
					</div>
					<?php echo the_content( 'Read more', false ); ?>
				</div>
			</div>
		</article>
	<?php endwhile;
		echo liek_blog_pagination($paginationLinks);
	else: ?>
		<article class="blog-post-macro">
	<h1>Aqua-proof Blog</h1>
	<p>No posts to display, <a href="/blog">back to the blog</a>.</p>
	</article>
<?php endif; ?>
</div>
<div class="columns large-4">
	<div class="blog-panel">
		<?php dynamic_sidebar( 'blog-sidebar' ); ?>
	</div>
</div>
</div>
<?php get_footer(); ?>