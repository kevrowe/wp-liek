<?php
/**
 * Template Name: Work gallery template
 */

get_header();

$work_projects = get_posts( array(
    'posts_per_page' => -1,
    'post_type'=>'work_project') );

?>
<div class="row">
	<div class="columns large-12">
		<h1 class="panel-dark">Gallery</h1>
	</div>
</div>
<div class="row">
	<div class="columns large-12">
		<div class="work-gallery">
			<div hidden class="showcase">
				<div class="close"></div>
				<div class="showcase-content"></div>
			</div>
			<div class="items">
				<?php
				foreach ($work_projects	as $project) {
					?>
					<div class="item" data-name="<?php echo $project->post_name ?>">
						<?php echo get_the_post_thumbnail( $project->ID, array(320,240), false ); ?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
?>