<?php
/**
 * Template name: Woo Ingredients Filter Page 2
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package farbest
 */

get_header(); ?>

<style>
div.formcraft-css.body-append.image_button_cover.placement-right.now-show {display:none;}
</style>

	
		<div id="primary" class="content-area ">
	<div id="breadCrumb"><?php breadcrumb_simple(); ?></div>
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : ?>
			
			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->


				<?php get_template_part( 'loop'); 

				

			get_template_part( 'content', 'none' ); 
			end(); ?>

		


		</main><!-- #main -->
	</div><!-- #primary -->

	
<?php do_action ('get_sidebar'); ?>
<?php get_footer(); ?>