<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package farbest
 */
?>
		<h1><?php the_title(); ?></h1>
		<div class=""><?php the_content(); ?></div>
		
		<div class="ingred_acc" style="display:none">
		<?php
		$pages2cats = array(
			'129' => 'ascorbic_acid',
			'121' => 'beta_carotene',
			'150' => 'calcium_ascorbate',
			'107' => 'calcium_caseinate',
			'176' => 'calcium_d_pantothenate',
			'93' => 'caseinonly',
			'95' => 'colostrum',
			'186' => 'crystalline_fructose',
			'164' => 'd_biotin',
			'312' => 'fibers',
			'306' => 'food_ingredients',
			'299' => 'fruits_&_fruit_powders',
			'188' => 'gum_acaciaonly',
			'342' => 'gum_acacia_organic',
			'97' => 'hydrolysates',
			'309' => 'juice_&_concentrates',
			'99' => 'lactoferrin',
			'101' => 'lactoperoxidase',
			'125' => 'lutein',
			'123' => 'lycopene',
			'103' => 'milk_protein',
			'321' => 'monk_fruit',
			'172' => 'niacinonly',
			'174' => 'niacinamide',
			'182' => 'nutrient_premixes_&_blends',
			'115' => 'pea_protein',
			'302' => 'plant_proteins',
			'190' => 'polydextrose',
			'178' => 'pyridoxine',
			'170' => 'riboflavin',
			'152' => 'sodium_ascorbate',
			'11' => 'sodium_caseinate',
			'113' => 'soy_protein',
			'109' => 'specialty',
			'315' => 'supplements',
			'335' => 'sweeteners',
			'168' => 'thiamine',
			'154' => 'vitamin_a',
			'156' => 'vitamin_d',
			'158' => 'vitamin_e',
			'160' => 'vitamin_k',
			'105' => 'whey_protein',
			'1834' => 'rice_protein',
			'2114' => 'cyanocobalamin',
			'2119' => 'folic_acid',
			'2122' => 'methylcobalamin',
			'2130' => 'weighting_agents',
			'3347' => 'gum_acacia_ngpv',
			'3334' => 'pea_protein_ngpv'
);

		$page = get_the_ID();
		
		if (array_key_exists($page, $pages2cats)) {

		$cat = $pages2cats[$page];
	
		
		$args = array(
		'post_type' => 'products', 
		'meta_key' => 'products_order',
			'orderby' => 'meta_value_num',
		    'order' => 'ASC',
			
		'posts_per_page'=>-1,
		'meta_query' => array(
			array(
					'key'     => 'products_categories',
					'value'   => $cat,
					'compare' => 'LIKE'
				)
			)
		);
		
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); 
		
		$prod_desc = get_post_meta($post->ID, 'products_description', true);
		$prod_apps = get_post_meta($post->ID, 'products_applications', true);
		$prod_pack = get_post_meta($post->ID, 'products_packaging', true);
		
		$certifications = get_field('certifications');
		
		?>
		
		<h3 class="post-title dkblue"><?php the_title(); ?><span id="acc_icon" style="display:block;float:right;position:relative"><!--<i class="fa fa-angle-down"></i>--></span></h3>
		<div>
		<p><?php echo $prod_desc; ?></p>
		<?php if(!empty ($prod_apps)) { echo '<p><strong>PROVEN APPLICATIONS:</strong><br>' . $prod_apps . '</p>'; } ?>
		<p><strong>KG CLAIMS:</strong><br><?php the_terms( $post->ID, 'claim', '', ' | ' ); ?></p>
		<p><strong>ACF LABEL CLAIMS:</strong><br><?php the_field('claims'); ?></p>
		<p><strong>PIKLisr Old CERTS:</strong><br><?php echo get_the_term_list( $post->ID, 'certification', '', ' | ' ); ?></p>
		<p><strong>CERTIFICATIONS:</strong><br><?php the_field('certification'); ?></p>	
		<p><strong>ACF NEW STUFF:</strong><br><?php the_field('new_stuff'); ?></p>	
		<?php if(!empty ($prod_pack)) { echo '<p><strong>PACKAGING:</strong><br>' . $prod_pack . '</p>'; } ?>
		</div>
		<?php endwhile; ?>
		<?php } ?>
		</div><!-- close #accordion -->
