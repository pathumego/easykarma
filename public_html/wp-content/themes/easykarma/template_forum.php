<?php
/**
 * Template Name: Forum Template
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


?>
<html itemscope itemtype="http://schema.org/Organization">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>
<?php bloginfo('name'); ?>
<?php wp_title(); ?>
</title>
	<meta name="description" content="">
	<meta name="author" content="">
<meta property="og:image" content="http://easykarma.biz/wp-content/uploads/2013/05/avatar.jpg"/>
<meta property="og:title" content="EasyKarma - Doing good Karma the Buddhist way"/>
<meta property="og:description" content="Easy Karma is a service that will help you to reach the ultimate spiritual goals with minimum effort."/>

<meta property="og:site_name" content="EasyKarma"/>
<meta property="og:type" content="website"/>
<meta itemprop="name" content="EasyKarma">
<meta itemprop="description" content="Easy Karma is a service that will help you to reach the ultimate spiritual goals with minimum effort. Doing good karma in the Buddhist way is easier than ever before.">
<meta itemprop="image" content="http://easykarma.biz/wp-content/uploads/2013/05/avatar.jpg">


	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/style.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.lightbox_me.js"></script>
 
  <script src="<?php bloginfo('template_directory');?>/dist/raphael-min.js"></script>
  <script src="<?php bloginfo('template_directory');?>/dist/jquery.qtip-1.0.0.min.js"></script>

  <script type="text/javascript" src="<?php bloginfo('template_directory');?>/dist/modernizr.custom.79639.js"></script> 
 
<script type="text/javascript">
      
      function DropDown(el) {
        this.dd = el;
        this.opts = this.dd.find('ul.dropdown > li');
        this.val = [];
        this.index = [];
        this.initEvents();
      }
      DropDown.prototype = {
        initEvents : function() {
          var obj = this;

          obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            event.stopPropagation();
          });

          obj.opts.children('label').on('click',function(event){
            var opt = $(this).parent(),
              chbox = opt.children('input'),
              val = chbox.val(),
              idx = opt.index();

            ($.inArray(val, obj.val) !== -1) ? obj.val.splice( $.inArray(val, obj.val), 1 ) : obj.val.push( val );
            ($.inArray(idx, obj.index) !== -1) ? obj.index.splice( $.inArray(idx, obj.index), 1 ) : obj.index.push( idx );
          });
        },
        getValue : function() {
          return this.val;
        },
        getIndex : function() {
          return this.index;
        }
      }

      $(function() {

        var dd = new DropDown( $('#dd') );

        $(document).click(function() {
          // all dropdowns
          $('.wrapper-dropdown-4').removeClass('active');
        });

      });

    </script>

<script type="text/javascript">
$(document).ready(function() {
  $('a.login-window').click(function() {
    
    // Getting the variable's value from a link 
    var loginBox = $(this).attr('href');

    //Fade in the Popup and add close button
    $(loginBox).fadeIn(300);
    
    //Set the center alignment padding + border
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
      'margin-top' : -popMargTop,
      'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);
    
    return false;
  });
  
  // When clicking on the button close or the mask layer the popup closed
  $('a.close, #mask').live('click', function() { 
    $('#mask , .login-popup').fadeOut(300 , function() {
    $('#mask').remove();  
  }); 
  return false;
  });
});
</script>
<script>



$(document).ready(function(){
	
	$('.slide').click(function(){
	
		var el = $(this).attr('href');
		var elWrapped = $(el);
		
		scrollToDiv(elWrapped,10);
		
		return false;
	
	});
	
	


 $(document).ready(function(){
      resizeDiv();
  });

  window.onresize = function(event) {
      resizeDiv();
  }

  function resizeDiv() {
      vpw = $(window).width(); 
      vph = $(window).height(); 
      $('.resize_window').css({'height': vph + 'px'});
  }


$(window).scroll(function(e) {   
    if($(window).scrollTop() >=4000) {
       $(window).scrollTop(0);
    }
});

$(window).scrollTop(3020);





</script>


<script type="text/javascript">$(function(){





    
     var paper = Raphael('coffee', 1200, 1200)
    
       ,path = 'M418.605,424.145c0,0,1.604,89.894-49.99,91.84c0,0-59.674-89.648,52.497-171.39l2.289,0.103c104.613,91.206,37.354,175.31,37.354,175.31c-51.233-6.437-41.798-95.85-41.798-95.85L418.605,424.145z M531.646,639.596c2.951-67.531-49.402-124.667-116.937-127.617c-67.531-2.946-124.664,49.405-127.617,116.935M267.839,478.379c0,0,56.553,69.89,97.331,38.222c0,0-11.91-107.032-150.377-97.552l-1.692,1.545c-21.517,137.11,84.072,158.312,84.072,158.312c35.109-37.859-29.593-100.288-29.593-100.288L267.839,478.379z M291.144,673.918c-1.941-51.604-91.838-49.996-91.838-49.996l0.018-0.35c0,0,89.408,9.434,95.845-41.795c0,0-84.102-67.259-175.311,37.354l-0.1,2.287 M291.368,677.508 M698.357,648.809l0.1-2.287c-81.74-112.168-171.385-52.493-171.385-52.493c1.943,51.596,91.838,49.989,91.838,49.989l-0.016,0.352c0,0-89.414-9.436-95.846,41.793 M564.926,492.712c0,0-69.893,56.555-38.223,97.327c0,0,107.031-11.913,97.557-150.377l-1.551-1.687C485.598,416.457,464.4,522.042,464.4,522.042c37.859,35.111,100.291-29.59,100.291-29.59L564.926,492.712z M701.338,645.287c7.059-161.669-118.275-298.455-279.936-305.515c-161.671-7.062-298.453,118.274-305.515,279.944 M365.275,514.304 M358.688,419.917 M365.663,513.585c-31.068-67.291,2.388-113.034,2.388-113.034s-16.63-29.219-58.532-40.486l-0.468-0.221c-25.297,35.253-18.554,68.386-18.554,68.386S343.936,440.627,365.663,513.585 M507.682,599.172c-19.604-54.929-80.02-83.563-134.944-63.962c-54.926,19.606-83.562,80.019-63.959,134.945 M392.961,589.968c-24.178,8.629-36.785,35.227-28.155,59.405c8.628,24.18,35.229,36.789,59.405,28.16c24.182-8.629,36.787-35.227,28.154-59.41C443.736,593.945,417.145,581.339,392.961,589.968z M729.834,648.262c7.73-176.991-129.48-326.743-306.463-334.475C246.382,306.058,96.632,443.273,88.906,620.26 M293.715,578.581c-69.73-25.107-79.227-80.324-79.227-80.324s-32.456-8.708-69.615,12.741l-0.482,0.173c7.658,42.216,36.051,60.56,36.051,60.56S226.419,543,293.715,578.581 M288.698,677.961 M288.698,677.961 M288.698,677.961 M288.698,677.961 M530.037,590.552c67.297-31.07,113.035,2.387,113.035,2.387s29.221-16.633,40.486-58.534l0.221-0.467c-35.256-25.298-68.387-18.555-68.387-18.555S602.998,568.822,530.037,590.552 M463.789,518.029c25.617-69.557,81.615-78.244,81.615-78.244s8.908-32.418-12.76-70.015l-0.174-0.487c-42.816,7.039-61.477,35.236-61.477,35.236S500.018,451.07,463.789,518.029 M289.084,426.556c-3.34-16.97,5.989-41.39,5.989-41.39s-16.512-9.255-37.705-3.661c-13.306,17.414-10.859,35.97-10.859,35.97s27.366-1.07,41.751,8.531h0.824V426.556z M176.861,569.293c-14.132-8.636-25.705-30.68-25.705-30.68s-17.271,5.522-27.122,23.905c3.61,20.524,18.282,30.813,18.282,30.813s17.891-17.349,34.014-21.164l0.841-1.524L176.861,569.293z M671.996,674.711M214.292,495.576c-8.403-15.114-6.05-40.973-6.05-40.973s-19.848-5.169-38.283,6.682c-7.297,20.667,0.749,37.564,0.749,37.564s25.219-6.809,41.857-2.103l0.902-1.446L214.292,495.576z M644.629,594.84c16.225,6.052,32.119,23.794,32.119,23.794s16.244-9.844,21.396-29.395c-9.258-17.797-27.096-23.154-27.096-23.154s-12.396,17.483-26.695,27.383l0.275,0.824V594.84zM548.389,438.929c15.674-6.6,41.521-5.983,41.521-5.983s3.721-18.565-8.125-37.004c-20.668-7.296-37.566,0.75-37.566,0.75s5.543,25.189,2.102,41.86l1.781,0.171L548.389,438.929z M367.705,399.449c9.098-19.639,26.62-34.696,26.62-34.696s-10.494-15.758-31.912-20.419c-19.771,9.455-26.029,27.092-26.029,27.092s22.645,13.018,31.084,28.114l1.379-1.136L367.705,399.449z M615.963,513.998c17.01-3.779,39.178,3.326,39.178,3.326s9.939-14.815,5-35.381c-16.963-12.494-35.994-7.595-35.994-7.595s-0.967,25.626-8.184,39.237V513.998L615.963,513.998z M471.182,403.224c9.223-13.824,30.521-25.517,30.521-25.517s-3.58-16.579-21.684-27.174c-20.777,2.819-30.621,18.739-30.621,18.739s15.119,16.036,21.086,32.161l-0.59,0.516L471.182,403.224zM376.253,600.068c8.958-8.65,29.127-13.142,29.127-13.142s-31.789-39.757-67.188-27.95l-1.05,1.017c-13.026,34.964,23.906,68.986,23.906,68.986S367.44,608.58,376.253,600.068z M402.748,682.572c0,0-19.355-6.873-27.87-15.686c-8.65-8.959-14.187-28.646-14.187-28.646s-39.753,31.791-27.946,67.186 M479.408,709.402l1.051-1.012c13.027-34.969-23.904-68.99-23.904-68.99s-7.137,19.518-15.957,28.033c-8.955,8.652-28.374,14.025-28.374,14.025 M442.248,601.99c8.65,8.955,13.607,28.768,13.607,28.768s39.752-31.793,27.943-67.187l-1.014-1.051c-34.967-13.024-68.988,23.903-68.988,23.903S433.734,593.171,442.248,601.99z M409.85,529.803c-18.661,7.137-26.345,37.734-26.345,37.734s19.188,15.86,21.05,19.389l11.33-0.045c1.862-3.525,21.406-18.933,21.406-18.933s-7.547-31.147-26.208-38.282L409.85,529.803z M303.239,631.75c7.137,18.664,37.734,26.346,37.734,26.346s15.86-19.186,19.388-21.049l-0.042-11.332c-3.527-1.863-18.935-21.406-18.935-21.406s-31.147,7.547-38.282,26.211L303.239,631.75z M412.276,682.561l-11.333,0.039 M511.795,638.066c-7.133-18.664-37.043-25.844-37.043-25.844s-15.506,17.877-19.031,19.74l-0.275,9.074c4.482-0.961,21.133,23.51,21.133,23.51s28.219-6.586,35.355-25.25L511.795,638.066z'
        ,icon = paper.path(path).attr({ stroke: '#ffffff', 'stroke-width': '2','fill-opacity': 0 })
        ;
    
    // zoom out
    paper.setViewBox(0, 0, 1200, 1200, true);
    
   
    $(icon.node).css({
        'stroke-dasharray': '9999px',
        'stroke-dashoffset': '9999px'
    });
    
    $('#coffee').on('hover', function(e){
        e.preventDefault();
        
        // the path length
        var len = Raphael.getTotalLength(path)
            ,glow
            ;

        $(icon.node).animate({
            // animate to final value
            'stroke-dashoffset': (9999 - len)+'px'
        },{
            duration: 70000, // 5 sec
            easing: 'linear',
            complete: function(){
                // fill in the path... for style points
                icon.animate({"fill-opacity": .9}, 1000);
                
                icon.attr({'cursor': 'pointer'});
                
                icon.hover(function(){
                    // on hover
                    glow = icon.glow({
                        width: 10,
                        color: '#eee'
                    });
                    
                },
                function(){
                    // on hover exit
                    glow.remove();
                    
                }).click(function(){
                    
                    // click
                    $('#msg a:first').click();
                });
            }
        });
    });
});</script>



 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41121789-1', 'easykarma.biz');
  ga('send', 'pageview');

</script>
<style type="text/css">
#content{
	max-width: 100%!important;
}
</style>

 <?php wp_head(); ?> 

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=557750137576961";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>





<script type="text/javascript">

      $(document).ready(function()
{
   // Use the each() method to gain access to each of the elements attributes
   $('#charity li').each(function()
   {
      $(this).qtip(
      {
         content: '<a href="#">Edit</a> | <a href="#">Delete</a>', // Give it some content
         position: 'topRight', // Set its position
         hide: {
            fixed: true // Make it fixed so it can be hovered over
         },
         style: {
            padding: '5px 15px', // Give it some extra padding
            name: 'dark' // And style it with the preset dark theme
         }
      });
   });
});
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=468861013189337";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<div id="wrappr">
<div id="header">





	<div id="logo_q"></div>
	


</div>
<div id="content">	


  <div id="login-box" class="login-popup">
        <a href="#" class="close"><img src="<?php bloginfo('template_directory');?>/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
       <h1></h1>
      <div class="left">
       
          <p class="copy">This website was designed and developed by <a href="http://pathum.la-ulu.com/">Pathum Egodawatta</a> as partial fulfillment of Final year Proffesional Collaboration module of the Bachelor of Arts Graphic Design degree programme at Nothumbria Unversity, UK. All rights reserved. © Pathum Egodawatta</p>
<div class="fb-like-box" data-href="https://www.facebook.com/easykarmasl" data-width="292" data-show-faces="true" data-colorscheme="light" data-stream="false" data-show-border="false" data-header="false"></div>
        </div></div>
	












<div class="forum_section_bg">
	<div id="single_pakagecard" class="forum_content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				
			<?php endwhile; // end of the loop. ?>
<a class="slide center_margin" href="#charity"></a> 
	</div>



</div>


<div class="forum_section">
	<div id="charity">
		<div id="charitybg" class="charitybg">
<ul>

<li>
  <a href="http://www.sarvodaya.org/donate">
  <div id='one'>
	
<img src="http://easykarma.biz/wp-content/uploads/2013/05/money.jpg">
<img class="forum_icon" src="<?php bloginfo('template_directory');?>/images/pakage_basic.png">
<div id="two">Donate Money</div>

</div>	

</a> 			
</li>



<li>
  <a href="http://www.helpagesl.org/" target="_blank">
  <div id='one'>
  
<img src="http://easykarma.biz/wp-content/uploads/2013/05/old.jpg">
<img class="forum_icon" src="<?php bloginfo('template_directory');?>/images/pakage_super.png">

<div id="two">Donate Time</div>
</div>  

</a>      
</li>

<li>
  <a href="http://www.eyedonation.slt.lk/" target="_blank">
  <div id='one'>
  
<img src="http://easykarma.biz/wp-content/uploads/2013/05/eye.jpg">
<img class="forum_icon" src="<?php bloginfo('template_directory');?>/images/pakage_prime.png">
<div id="two">Donate Organs</div>

</div>  

</a>      
</li>
</ul>
</div>
</div>

</div>



<div class="forum_section_bg">
	<div id="disqus_wraper">	
		<p class="copy"></a>
</p>

<div id="subfooterwrap">
		
	<ul>
		<li>
<a id="karma" class="mykarmalink login-window" href="#login-box"><div>Who Made this?</div></a>
</li><li>
<fb:like href="http://easykarma.biz/" layout="button_count" show-faces="false" width="450" action="like" colorscheme="light" /></li>
<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="medium" data-href="easykarma.biz"></div>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</li>
	</ul>	

	</div>








<h2> Share and discuss what you think...</h2>

	<?php comments_template(); ?>

</div>

<?php get_footer(); ?>