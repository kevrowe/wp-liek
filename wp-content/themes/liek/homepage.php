<?php
/**
 * Template Name: Homepage template
 */

get_header();
?>
<div class="row">
	<div class="columns large-12">
		<div class="feature panel-dark">
			<div class="row">
				<?php
				for ($i = 0; $i < 3; $i++) {
					?>
					<article class="columns small-4 large-4 feature-item">
						<?php
						$attachment_id = get_post_meta( $post->ID, 'liek_homepage_feature_'.$i.'_image', true );
						echo wp_get_attachment_image( $attachment_id, array(233,175), false, false );
						?>
						<h2><?php
							echo get_post_meta( $post->ID, 'liek_homepage_feature_'.$i.'_heading', true );
							?></h2>
							<?php
							echo wpautop(get_post_meta( $post->ID, 'liek_homepage_feature_'.$i.'_caption', true ));
							?>
						</article>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
	<h2 class="summary-heading"><?php echo $post->post_title ?></h2>
	</div>
	<article class="summary col-3 row">
		<?php echo wpautop($post->post_content, true); ?>
	</article>
	<article class="summary row">
		<?php echo wpautop(get_post_meta( $post->ID, 'liek_homepage_fullwidth_content', true ), true); ?>
	</article>
	<div class="row">
		<div class="columns large-12">
			<article class="panel-light">
				<?php dynamic_sidebar( 'homepage-widgets' ); ?>
			</article>
		</div>
	</div>
	<?php get_footer(); ?>