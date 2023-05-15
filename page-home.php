<?php
/**
 * Template name: Homepage
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package farbest
 */

get_header(); ?>

<?php

$args = array(
		'post_type' => 'homepage',
		'posts_per_page'=>1
		);

$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$logo = get_post_meta($post->ID, 'homepage_logo', true); 
		$bkgd_img = get_post_meta($post->ID, 'homepage_bkgd_img', true);
		$headline = get_post_meta($post->ID, 'homepage_headline', true);  
		$fbb_headline = get_post_meta($post->ID, 'homepage_fbb_headline', true);  
		$fbb_content = get_post_meta($post->ID, 'homepage_fbb_content', true);  
		$fbb_button = get_post_meta($post->ID, 'homepage_fbb_button', true);  
		$fbb_button_link = get_post_meta($post->ID, 'homepage_fbb_button_link', true);  
		$fcta_headline = get_post_meta($post->ID, 'homepage_fcta_headline', true);  
		$fcta_content = get_post_meta($post->ID, 'homepage_fcta_content', true);  
		$fcta_footnote = get_post_meta($post->ID, 'homepage_fcta_footnote', true);  
		$fcta_button = get_post_meta($post->ID, 'homepage_fcta_button', true);  
		$fcta_button_link = get_post_meta($post->ID, 'homepage_fcta_button_link', true);  
		$sbb_headline = get_post_meta($post->ID, 'homepage_sbb_headline', true);  
		$sbb_content = get_post_meta($post->ID, 'homepage_sbb_content', true);  
		$sbbl_button = get_post_meta($post->ID, 'homepage_sbbl_button', true);   
		$sbbl_content = get_post_meta($post->ID, 'homepage_sbbl_content', true);    
		$sbbc_button = get_post_meta($post->ID, 'homepage_sbbc_button', true);    
		$sbbc_content = get_post_meta($post->ID, 'homepage_sbbc_content', true);    
		$sbbr_button = get_post_meta($post->ID, 'homepage_sbbr_button', true);    
		$sbbr_content = get_post_meta($post->ID, 'homepage_sbbr_content', true);    
		$scta_headline = get_post_meta($post->ID, 'homepage_scta_headline', true);     
		$scta_content = get_post_meta($post->ID, 'homepage_scta_content', true);     
		$scta_button = get_post_meta($post->ID, 'homepage_scta_button', true);     
		$scta_button_link = get_post_meta($post->ID, 'homepage_scta_button_link', true);     
		$partners_headline = get_post_meta($post->ID, 'homepage_partners_headline', true);     
		$partners_content = get_post_meta($post->ID, 'homepage_partners_content', true); 
?>

<?php endwhile; ?>
<div id="hero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/<?php echo $bkgd_img; ?>');"><img class="home" src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $logo; ?>"><h1 class="home"><?php echo $headline; ?></h1></div>
<div id="ingredients">
<div class="fb_content">
<div><h2 class="home"><?php echo $fbb_headline; ?></h2></div>
<div><?php echo $fbb_content; ?></div>
<div><a href="<?php echo $fbb_button_link; ?>" class="hb_other"><h5><span><?php echo $fbb_button; ?> <i class="fa fa-chevron-right"></i></span></h5></a></div>
</div>
</div>
<div id="cta1">
<div class="fb_content clearfix">
<div class="left60">
<div><h3 class="home"><?php echo $fcta_headline; ?></h3></div>
<div><h6><?php echo $fcta_content; ?></h6></div>
<div class="note"><?php echo $fcta_footnote; ?></div>
</div>
<div class="left40">
<div style="white-space:nowrap;"><a href="<?php echo $fcta_button_link; ?>" class="hb_other"><span class="button"><?php echo $fcta_button; ?> <i class="fa fa-chevron-right"></i></span></a></div>
</div>
</div>
</div>
<div id="offerings">
<div class="fb_content">
<div><h2 class="home"><?php echo $sbb_headline; ?></h2></div>
<div class="tnh"><?php echo $sbb_content; ?></div>
<div class="clearfix">
<div class="threeWide"><h4><span><?php echo $sbbl_button; ?></span></h4><?php echo $sbbl_content; ?></div>
<div class="threeWide"><h4><span><?php echo $sbbc_button; ?></span></h4><?php echo $sbbc_content; ?></div>
<div class="threeWide"><h4><span><?php echo $sbbr_button; ?></span></h4><?php echo $sbbr_content; ?></div>
</div>
</div>
</div>
<div id="cta2">
<div class="fb_content clearfix">
<div class="left65">
<div><h3 class="home"><?php echo $scta_headline; ?></h3></div>
<div><h6><?php echo $scta_content; ?></h6></div>
</div>
<div class="left35">
<!--<div style="white-space:nowrap;"><?php echo do_shortcode('[fc id="9" type="popup" class="homebutton"]Ask a Specialist  <i class="fa fa-chevron-right"></i>[/fc]'); ?></div>-->
<div style="white-space:nowrap;"><a href="<?php echo $scta_button_link; ?>"><span class="button"><?php echo $scta_button; ?> <i class="fa fa-chevron-right"></i></span></a></div>
</div>
</div>
</div>

<div id="partners">
<div class="fb_content" style="max-width:1000px">
<div><h2><?php echo $partners_headline; ?></h2></div>
<div><?php echo $partners_content; ?></div>
<p></p>
<?php echo do_shortcode('[carousel-horizontal-posts-content-slider id="3428"]') ?>
</div>
</div>	

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
