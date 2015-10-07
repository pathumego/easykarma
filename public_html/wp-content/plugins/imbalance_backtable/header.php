<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="https://plus.google.com/{plusPageUrl}" rel="publisher" />
<link href="https://plus.google.com/105228512607691163589" rel="publisher" />
<meta name="google-site-verification" content="6gSEtapYnSYfswkYOjAhou4xMjrIEnXSArUgH1S64_c" />
<meta name="msvalidate.01" content="F1A943B5E55969772F6C76D6A2BB15A9" />
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1"><![endif]-->
    <!--[if IE 7]>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie7.css" type="text/css" media="screen" />
    <![endif]-->
    <!--[if IE 6]>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie6.css" type="text/css" media="screen" />
    <![endif]-->
    <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_enqueue_script('jquery'); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
    <script src="<?php bloginfo('template_url'); ?>/js/columnizer.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/columnize.js" type="text/javascript"></script>   
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/animatedcollapse.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/collapse.js"></script>
</head>
<body <?php body_class(); ?>>

	<div id="outer">
    	<div id="top">
        	<div id="logo">
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
				<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" /></a>
        		<?php else: ?>
        		<a href="<?php bloginfo("url"); ?>/"><img src="<?php echo get_option('imbalance_custom_logo'); ?>" alt="<?php bloginfo('name'); ?>" /></a>        		
        		<?php endif ?>
        	</div>
        </div>
      

<div id="categoriesport">








           


 
				  
				

<?php
				    if ( function_exists( 'wp_nav_menu' ) ) {
				    	wp_nav_menu( array( 'theme_location' => 'custom-menu' , 'container' => '' , 'fallback_cb'=> 'custom_menu' , 'depth' => 1 ) ); }
				    else
					    { custom_menu(); }
					?>

</div>           
           