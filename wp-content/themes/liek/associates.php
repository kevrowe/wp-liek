<?php

/**
 * Template Name: Associates template
 */

get_header();
$post_args = array(
    'posts_per_page' => -1,
    'post_type' => 'associate',
    'orderby'   => 'menu_order',
    'order'     => 'ASC' );


$associates = get_posts( $post_args );
$associate_groups = array_chunk($associates, 4);
?>
<section>
    <div class="row">
        <div class="columns large-12">
            <h1 class="panel-dark"><?php echo $post->post_title ?></h1>
        </div>
    </div>
    <?php
    foreach ($associate_groups as $group) :
        ?>
    <div class="row">
        <?php foreach($group as $associate) : ?>
        <div class="columns large-3 small-6 tiny-12 <?php echo array_search($associate, $group) == sizeof($group)-1 ? 'end' : ''; ?>">
            <article class="associate">
                <div class="avatar">
                    <?php echo wp_get_attachment_image( get_post_thumbnail_id( $associate->ID ), array(100), false); ?>
                    <h1><?php echo $associate->post_title ?></h1>
                </div>
                <p><?php echo $associate->post_excerpt ?></p>
                <div class="cta">
                    <a href="<?php echo get_post_meta( $associate->ID, 'liek_associates_website_url', true ) ?>">Visit website</a>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
</div>
</section>
<?php
endforeach;
get_footer();
?>