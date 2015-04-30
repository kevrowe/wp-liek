<?php
/**
 * Template Name: Contact template
 */

get_header();

$coord_dump = get_post_meta( $post->ID, 'liek_contact_page_map_coords', true );
$coord_pairs = explode(')', str_replace('(', '', $coord_dump));
$coords = array();

foreach ($coord_pairs as $coord) {
	if (empty($coord)) {
		continue;
	}
	array_push($coords, explode(',', $coord));
}

wp_localize_script( 'app-js', 'ContactMapCoords', $coords );
wp_localize_script( 'app-js', 'ContactMapCallout', wpautop(get_post_meta( $post->ID, 'liek_contact_page_map_tooltip', true )) );
?>
<section>
	<div class="row">
		<div class="columns large-12">
			<h1 class="panel-dark"><?php the_title(); ?></h1>
		</div>
	</div>
	<div class="row">
		<aside class="columns large-5">
			<div class="map" id="areamap"></div>
		</aside>
		<div class="columns large-7">
			<div class="row">
				<article class="columns large-12">
					<div class="callout-left slide-out-parent">
						<?php echo wpautop( $post->post_content, true ); ?>
					</div>
				</article>
				<div class="columns large-12">
					<div class="slide-out">
						<form action="<?php echo get_stylesheet_directory_uri().'/send_mail.php' ?>" method="POST" class="contact-form">
							<div>
								<label for="name">Name*</label>
								<input type="text" name="name" id="name" data-required />
							</div>
							<div>
								<label for="email">Email*</label>
								<input type="email" name="email" id="email" data-required />
							</div>
							<div>
								<label for="telephone">Telephone*</label>
								<input type="text" name="telephone" id="telephone" data-required />
							</div>
							<div>
								<label for="postcode">Postcode</label>
								<input type="text" name="postcode" id="postcode" class="short"/>
							</div>
							<div>
								<label for="message">Additional Information</label>
								<textarea name="message" id="message" cols="30" rows="10"></textarea>
							</div>
							<input type="hidden" name="mailto" value="<?php echo get_post_meta( $post->ID, 'liek_contact_page_mailto', true ) ?>" />
							<input type="submit" value="Send" name="send" id="send" class="primary button success radius full" />
						</form>
						<div class="hide" data-contact-response>
							<?php echo wpautop(get_post_meta( $post->ID, 'liek_contact_page_form_message', true )) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>