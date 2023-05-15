<?php
/**
 * Template name: Woo Ingredients Filter Page new
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

<div class="fb_content fb_left ieheightfix">
	<div class="sidebar-filter" style="width=20%;">
		Product Filter
		<?php the_field('claims'); ?></div>
	
		<div id="primary" class="content-area ">
	<div id="breadCrumb"><?php breadcrumb_simple(); ?></div>
			
			
	<div class="sidebar-filter" style="width=20%;"><?php do_action ('get_sidebar'); ?></div>
			
		<main id="main" class="site-main" role="main">
			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php if ( have_posts() ) : while(have_posts()) : the_post(); ?>
			
			
			<?php the_content(); ?>
			<?php endwhile; endif; ?>


		</main><!-- #main -->
	</div><!-- #primary -->

</div>
<?php //do_action ('get_sidebar'); ?>
<?php get_footer(); ?>