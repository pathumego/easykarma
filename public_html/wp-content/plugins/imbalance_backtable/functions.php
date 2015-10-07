<?php
// ===========
// = Sidebar =
// ===========
if ( function_exists('register_sidebar') )
    register_sidebar();

// ====================================
// = WordPress 2.9+ Thumbnail Support =
// ====================================
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 305, 5000 , TRUE ); // 305 pixels wide by 380 pixels tall, set last parameter to true for hard crop mode
add_image_size( 'background', 305, 5000 ); // Set thumbnail size

// ===========================
// = WordPress 3.0+ Nav Menu =
// ===========================
register_nav_menus(
	array(
	'custom-menu'=>__('Custom menu'),
	)
);
function custom_menu(){
	wp_list_pages('title_li=&depth=1');
}

// ==================================
// = WP 3.0 Custom Background Setup =
// ==================================
if ( function_exists( 'add_custom_background' ) )
    { add_custom_background(); }


// =========================
// = Change excerpt lenght =
// =========================
add_filter('excerpt_length', 'my_excerpt_length');
function my_excerpt_length($length) {
return get_option('imbalance_excln'); }

// =================================
// = Change default excerpt symbol =
// =================================
function imbalance_excerpt($text) { return str_replace('[...]', '', $text); } add_filter('the_excerpt', 'imbalance_excerpt');


// =================================
// = Add comment callback function =
// =================================
function imbalance_comments($comment, $args, $depth) {
	$default = urlencode(get_bloginfo('template_directory') . '/images/default-avatar.png');
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	 <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
		<?php echo get_avatar($comment,$size='55', $default ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">wrote:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
 
      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
 
      <?php comment_text() ?>

	<div class="reply">
	         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
     </div>
<?php
}


// ==========================
// = Include Photo-Galleria =
// ==========================
if ( get_option('imbalance_gallery_off') == 'checked') { /* do nothing */ } else { include TEMPLATEPATH . '/js/photo-galleria/photo-galleria.php'; }  

 





// ====================
// = Add options page =
// ====================
function themeoptions_admin_menu()
{
	// here's where we add our theme options page link to the dashboard sidebar
	add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'themeoptions_page');
}

function themeoptions_page()
{
	if ( $_POST['update_themeoptions'] == 'true' ) { themeoptions_update(); }  //check options update
	// here's the main function that will generate our options page
	?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2>IMBALANCE Theme Options</h2>

		<form method="POST" action="">
			<input type="hidden" name="update_themeoptions" value="true" />

			<h3>Your social links</h3>
			
			
<table width="90%" border="0">
  <tr>
    <td valign="top" width="50%"><p><label for="fbkurl"><strong>Facebook URL</strong></label><br /><input type="text" name="fbkurl" id="fbkurl" size="32" value="<?php echo get_option('imbalance_fbkurl'); ?>"/></p><p><small><strong>example:</strong><br /><em>http://www.facebook.com/wpshower</em></small></p></td>
    <td valign="top"width="50%"><p><label for="twturl"><strong>Twitter URL</strong></label><br /><input type="text" name="twturl" id="twturl" size="32" value="<?php echo get_option('imbalance_twturl'); ?>"/></p><p><small><strong>example:</strong><br /><em>http://twitter.com/wpshower</em></small></p>
</td>
  </tr>
</table>

			<h3>Custom logo</h3>
			
			
<table width="90%" border="0">
  <tr>
    <td valign="top" width="50%"><p><label for="custom_logo"><strong>URL to your custom logo</strong></label><br /><input type="text" name="custom_logo" id="custom_logo" size="32" value="<?php echo get_option('imbalance_custom_logo'); ?>"/></p><p><small><strong>Usage:</strong><br /><em><a href="<?php bloginfo("url"); ?>/wp-admin/media-new.php">Upload your logo</a> (461 x 70px) using WordPress Media Library and insert its URL here</em></small></p></td>
    <td valign="top"width="50%"><p>
    	        <?php         		
	        	ob_start();
				ob_implicit_flush(0);
				echo get_option('imbalance_custom_logo'); 
				$my_logo = ob_get_contents();
				ob_end_clean();
        		if (
		        $my_logo == ''
        		): ?>
        		<a href="<?php bloginfo("url"); ?>/">
				<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>"></a>
        		<?php else: ?>
        		<a href="<?php bloginfo("url"); ?>/"><img src="<?php echo get_option('imbalance_custom_logo'); ?>"></a>       		
        		<?php endif ?>
    </p>
</td>
  </tr>
</table>

			<h3>Advanced options</h3>
			
			
<table width="90%" border="0">
<tr>
    <td valign="top" width="50%"><p><label for="excln"><strong>Excerpt lenght (in words)</strong></label><br /><input type="text" name="excln" id="excln" size="32" value="<?php echo get_option('imbalance_excln'); ?>"/><p><small><strong>Dafault value:</strong><em>35<br />- clean the field to disable excerpt completely<br />- automatically disabled if advanced-excerpt plugin is installed</em></small></p>
    </td>

    <td valign="top"width="50%">
	<p><input type="checkbox" name="gallery_off" id="gallery_off" <?php echo get_option('imbalance_gallery_off'); ?> />
	<label for="gallery_off"><strong>Disable jQuery Gallery?</strong><br /></label>
	</p>
	<p><small><em>Select the checkbox to disable jQuery Photo-Galleria<br />on your posts and pages in favour of WordPress photo gallery</em></small></p>
	<br />
	<p><input type="checkbox" name="sidebar_off" id="sidebar_off" <?php echo get_option('imbalance_sidebar_off'); ?> />
	<label for="sidebar_off"><strong>Disable Featured Posts on top of Sidebar?</strong><br /></label></p>
	<p><small><em>Select the checkbox to disable featured posts display on top of your sidebar</em></small></p>	
	</td>

  </tr>
</table>
			
			
			
			<p><input type="submit" name="search" value="Update Options" class="button button-primary" /></p>
		</form>

	</div>
	<?php
}

add_action('admin_menu', 'themeoptions_admin_menu');



// Update options function

function themeoptions_update()
{
	// this is where validation would go
	update_option('imbalance_fbkurl', 	$_POST['fbkurl']);
	update_option('imbalance_twturl', 	$_POST['twturl']);
	update_option('imbalance_excln', 	$_POST['excln']);
	update_option('imbalance_custom_logo', 	$_POST['custom_logo']);
	if ($_POST['gallery_off']=='on') { $display = 'checked'; } else { $display = ''; }
	update_option('imbalance_gallery_off', 	$display);
	if ($_POST['sidebar_off']=='on') { $display = 'checked'; } else { $display = ''; }
	update_option('imbalance_sidebar_off', 	$display);

}
?><?php
/* Clean up the admin sidebar navigation *************************************************/
function remove_admin_menu_items() {
  $remove_menu_items = array(__('Links'),__('Tools'), __('Comments'));
  global $menu;
  end ($menu);
  while (prev($menu)){
    $item = explode(' ',$menu[key($menu)][0]);
    if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
      unset($menu[key($menu)]);}
    }
  }
add_action('admin_menu', 'remove_admin_menu_items');
?><?php
function wps_admin_bar() {
    global $wp_admin_bar;
   
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );?>
<?php
/* 
 * Remove the Comment Bubble from the WordPress Admin Bar 
 */  
function remove_comment_bubble() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('comments');  
}  
add_action( 'wp_before_admin_bar_render', 'remove_comment_bubble' );  ?>
<?php
/* 
 * Add a simple menu & link that opens in a new window 
 * Change the Menu 'title' name and 'href' link. 
 */  
function custom_adminbar_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'View Portfolio' ),  
        'href' => 'http://backtable.co/portfolio/',  
        'meta'  => array( target => '_blank' ) )  
    );  
}  
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );  
/* The add_action # is the menu position: 
10 = Before the WP Logo 
15 = Between the logo and My Sites 
25 = After the My Sites menu 
100 = End of menu 
*/   ?><?php
// disable default dashboard widgets
function disable_default_dashboard_widgets() {

	remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');?><?php
function example_dashboard_widget_function() {
	// Display whatever it is you want to show
	echo "You Can start posting your projects by clickin on Posts>Add New on the Sidebar to the Left.";
} 

// Create the function use in the action hook
function example_add_dashboard_widgets() {
	wp_add_dashboard_widget('example_dashboard_widget', 'Hello Ashvin!', 'example_dashboard_widget_function');
}
// Hoook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );?><?php
function modify_footer_admin () {  
  echo 'Created by <a href="http://www.la-ulu.com">la-olu Collective</a>. Powered by <a href="http://www.wordpress.org">WordPress</a>';  
}  add_filter('admin_footer_text', 'modify_footer_admin');?>