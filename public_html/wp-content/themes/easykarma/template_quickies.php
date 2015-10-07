<?php
/**
 * Template Name: Quickies Template
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

<div id="single_pakagecard">
<div id="support_primary">
	


<div id="quickies">
	 <h3>Want More ? Add Quickies</h3>
	 <p>Quickies are one orders that will add onto your existing Karma plan. Ideal for collecting Karma for your Hospitalized friend or as a birthday gift.</p>


		
    
<?php { query_posts("cat=18"); } ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

    <div id="loop" class="<?php if ($_COOKIE['mode'] == 'grid') echo 'grid'; else echo 'list'; ?> clear">


 
<div <?php post_class('post clear'); ?> id="post_<?php the_ID(); ?>">

        
            <?php if ( has_post_thumbnail() ) :?>
            <a href="<?php the_permalink() ?>" class="thumb"><?php the_post_thumbnail('thumbnail', array(
                        'alt'	=> trim(strip_tags( $post->post_title )),
                        'title'	=> trim(strip_tags( $post->post_title )),
                    )); ?></a>
            <?php endif; ?>

            
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

            <div class="post-meta">
                                   on <span
                        class="post-date"><?php the_time(__('M j, Y')) ?></span> <em> </em><?php edit_post_link( __( 'Edit entry'), '<em>&bull; </em>'); ?>
            </div>
            <div class="post-content"><?php
$content = get_the_content('Read more');
print $content;
?></div>
        </div>


    <?php endwhile; ?>

    </div>  </div> 
  

<?php endif; ?>

		

</div>

</div><!-- #content -->
</div><!-- #content -->
<?php include("part_quickies.php"); ?>
		

	</div><!-- #primary -->



<?php get_footer(); ?>