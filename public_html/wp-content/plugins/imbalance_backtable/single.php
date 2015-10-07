<?php get_header(); ?> 
  
            <div id="main">
              <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
				<div class="entry">
                <div class="postmetadata">





<span>
<div class="navigation">
<div class="alignleft">

</div></div>                    
                    <br />
					<br />
                    <?php edit_post_link(__('[Edit this entry]'), '<br />', ''); ?>
                </div>
                <h1><?php the_title(); ?></h1>
                <div class="article" id="post-<?php the_ID(); ?>">
                    <?php the_content(); ?>
<?php wp_link_pages(); ?>
<div class="pagelink"><?php wp_link_pages('pagelink=Page %'); ?></div>
                    <div class="postmetadata">

<br />
<div class="navigation">
<div class="alignleft">

<?php previous_post('%',
 '&larr;prev ', 'no'); ?>

<?php next_post(' % ',
 'next&rarr; ', 'no'); ?>
</div></div>





                </div>





                <div id="comments">
					<?php comments_template(); ?>
                </div>
            <?php endwhile; ?>
            <?php else : ?>
                <h1 id="error"><?php _e("Sorry, but you are looking for something that isn&#8217;t here."); ?></h1>
            <?php endif; ?>
            </div>         
            </div>
<?php get_sidebar(); ?> 
<?php get_footer(); ?>