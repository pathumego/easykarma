<?php
/**
 * Template Name: Partners Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>




			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				
			<?php endwhile; // end of the loop. ?>

<div id="partners">
<div class="partner"><h4>Jetavana Center for <br>Spiritual Development</h3><img src="<?php bloginfo('template_directory');?>/images/partner_2.png"></div>
<div class="partner"><h4>Buddhist Affairs Council</h4><img src="<?php bloginfo('template_directory');?>/images/partner_1.png"></div>
e<div class="partner"><h4>Buddhist Bussiness Collective<br><br></h4><img src="<?php bloginfo('template_directory');?>/images/partner_3.png"></div>

</div>


		</div><!-- #content -->





<?php get_footer(); ?>