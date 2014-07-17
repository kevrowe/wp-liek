<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo( 'title' ); ?> - <?php bloginfo('description'); ?></title>
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/normalize.min.css">

	<!-- Foundation 3 for IE 8 and earlier -->
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/foundation3/foundation.css">
	<![endif]-->
	<!-- Foundation 4 for IE 9 and earlier -->
	<!--[if gt IE 8]><!-->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/foundation.min.css">
	<!--<![endif]-->
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/modernizr.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js" type="text/javascript" async=""></script>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php wp_enqueue_style( 'app-style', get_stylesheet_uri(), array( 'dashicons' ), false, false ); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_enqueue_script( 'app-js', get_stylesheet_directory_uri().'/js/app.min.js', 'jquery', false, true ); ?>
	<?php wp_head(); ?>
</head>
<body cz-shortcut-listen="true">
	<div class="container">
		<header class="site-header">
			<div class="row">
				<div class="large-6 columns">
					<a href="<?php bloginfo('url'); ?>">
						<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>"
						width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo('title'); ?>" />
					</a>
				</div>
				<div class="large-6 columns">
					<div class="row">
						<div class="large-12 columns">
							<ul class="main-contact">
								<li>
									<a href="tel:<?php echo esc_attr( get_theme_mod( 'header_telephone', '' ) ); ?>"><i class="icon icon-tel"></i> <?php echo esc_attr( get_theme_mod( 'header_telephone', '' ) ); ?></a>
								</li>
								<li>
									<a href="tel:<?php echo esc_attr( get_theme_mod( 'header_mobile', '' ) ); ?>"><i class="icon icon-mobile"></i> <?php echo esc_attr( get_theme_mod( 'header_mobile', '' ) ); ?></a>
								</li>
								<li>
									<a href="mailto:<?php echo esc_attr( get_theme_mod( 'header_email', '' ) ); ?>"><i class="icon icon-email"></i> <?php echo esc_attr( get_theme_mod( 'header_email', '' ) ); ?></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="micro-nav">
					<h2><i class="icon icon-nav"></i> Menu</h2>
				</div>
				<nav class="large-12 columns nav-wrap">
					<?php
				    /**
					* Displays a navigation menu
					* @param array $args Arguments
					*/
					$menuArgs = array(
						'menu_class' => 'main-nav',
						'container' => false
						);
					wp_nav_menu( $menuArgs );
					?>
				</nav>
			</div>
		</header>