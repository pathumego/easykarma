<?php
/**
 * Template Name: Plans Template
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


<?php include("part_plans.php"); ?>



<div id="icons">
	<H2>Looking for something quick? try the Quickies</h2>
<ul>
	<li><a href="<?php echo home_url(); ?>/plans/quickies/"><img src="<?php bloginfo('template_directory');?>/images/icon_quick.png"><p>Proffessional Success <br>and Exams</p></a></li>
	<li><a href="<?php echo home_url(); ?>/plans/quickies/"><img src="<?php bloginfo('template_directory');?>/images/icon_gift.png"><p>As a Birthday Gift</p></a></li>
	<li><a href="<?php echo home_url(); ?>/plans/quickies/"><img src="<?php bloginfo('template_directory');?>/images/icon_health.png"><p> Wising Good Health</p></a></li>

</ul>
</div>
	






<?php get_footer(); ?>