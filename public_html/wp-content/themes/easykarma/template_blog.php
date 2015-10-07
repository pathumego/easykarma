<?php
/**
 * Template Name: Blog Template
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



 <?php if(have_posts()) : ?>
  <?php while(have_posts()) : the_post(); ?>
  <h1>
    <?php the_title(); ?>
  </h1>
  <div id="blog_sidebar">
 <?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('blog-sidebar') ) : ?>
<?php endif; ?></div>
 <div class="content_slim">
    <ul>
				      <?php
				$args = array( 'numberposts' => 20);
				$lastposts = get_posts( $args );
				foreach($lastposts as $post) : setup_postdata($post); ?>
	      <div class='story'>
	        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	        <?php the_content(); ?>
	      </div>
      <?php endforeach; ?>
    </ul>
    <?php edit_post_link(__('[Edit this page]'), '<br />', ''); ?>
  </div>
  <?php endwhile; ?>
  <?php else : ?>
  <h1>
    <?php _e("Sorry, but you are looking for something that isn&#8217;t here."); ?>
  </h1>
  <?php endif; ?>


	</div><!-- #primary -->




<?php get_footer(); ?>