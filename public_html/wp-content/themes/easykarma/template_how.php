<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/Organization">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta property="og:image" content="http://easykarma.biz/wp-content/uploads/2013/05/avatar.jpg"/>
<meta property="og:title" content="EasyKarma - Doing good Karma the Buddhist way"/>
<meta property="og:description" content="Easy Karma is a service that will help you to reach the ultimate spiritual goals with minimum effort."/>

<meta property="og:site_name" content="EasyKarma"/>
<meta property="og:type" content="website"/>
<meta itemprop="name" content="EasyKarma">
<meta itemprop="description" content="Easy Karma is a service that will help you to reach the ultimate spiritual goals with minimum effort. Doing good karma in the Buddhist way is easier than ever before.">
<meta itemprop="image" content="http://easykarma.biz/wp-content/uploads/2013/05/avatar.jpg">

	<title>
<?php bloginfo('name'); ?>
<?php wp_title(); ?>
</title>
	<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/style.css">
	<script src="<?php bloginfo('template_directory');?>/dist/jquery.min.js"></script>
	<script src="<?php bloginfo('template_directory');?>/dist/raphael-min.js"></script>
	<script type="text/javascript">$(function(){

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41121789-1', 'easykarma.biz');
  ga('send', 'pageview');

</script>



<script>
    
     var paper = Raphael('small_lotus', 1500, 2000)
    
       ,path = 'M500.992,538.469 c-3.138,71.778-63.863,127.428-135.645,124.291c-71.776-3.138-127.421-63.867-124.289-135.645 c3.139-71.776,63.864-127.421,135.643-124.289C448.482,405.962,504.129,466.69,500.992,538.469z M332.09,427.517 c-58.379,20.839-88.815,85.051-67.981,143.431c20.836,58.38,85.05,88.817,143.431,67.979c58.38-20.83,88.814-85.05,67.979-143.428 C454.686,437.119,390.47,406.685,332.09,427.517z M353.586,485.72c-25.698,9.173-39.099,37.44-29.927,63.141 c9.171,25.701,37.444,39.104,63.143,29.932c25.701-9.173,39.1-37.444,29.924-63.147C407.554,489.945,379.29,476.548,353.586,485.72z M335.827,496.452c9.521-9.19,30.957-13.967,30.957-13.967s-33.786-42.256-71.412-29.707l-1.116,1.081 c-13.846,37.164,25.41,73.326,25.41,73.326S326.46,505.505,335.827,496.452z M334.364,567.476 c-9.194-9.521-15.078-30.447-15.078-30.447s-42.253,33.79-29.704,71.41l1.081,1.116c37.161,13.848,73.324-25.406,73.324-25.406 S343.415,576.843,334.364,567.476z M404.218,568.058c-9.519,9.196-30.157,14.905-30.157,14.905s33.784,42.252,71.408,29.702 l1.116-1.075c13.848-37.168-25.406-73.33-25.406-73.33S413.592,559.006,404.218,568.058z M405.972,498.499 c9.196,9.519,14.464,30.573,14.464,30.573s42.251-33.788,29.701-71.41l-1.078-1.116c-37.165-13.844-73.327,25.408-73.327,25.408 S396.923,489.125,405.972,498.499z M371.536,421.771c-19.834,7.585-28.001,40.107-28.001,40.107s20.395,16.857,22.374,20.606 l12.042-0.045c1.979-3.747,22.753-20.125,22.753-20.125s-8.021-33.106-27.856-40.689L371.536,421.771z M258.221,530.131 c7.584,19.836,40.107,28.001,40.107,28.001s16.858-20.395,20.606-22.374l-0.044-12.044c-3.749-1.979-20.126-22.751-20.126-22.751 s-33.106,8.021-40.689,27.855L258.221,530.131z M368.486,644.847c19.836-7.583,28.001-40.107,28.001-40.107 s-20.393-16.857-22.372-20.604l-12.046,0.041c-1.979,3.747-22.751,20.125-22.751,20.125s8.021,33.106,27.856,40.689L368.486,644.847 z M479.894,536.84c-7.583-19.834-39.374-27.467-39.374-27.467s-16.481,19.002-20.229,20.982L420,540 c4.765-1.021,22.462,24.988,22.462,24.988s29.992-7,37.579-26.836L479.894,536.84z'
       ,icon = paper.path(path).attr({ stroke: '#ffffff', 'stroke-width': '2','fill-opacity': 0 })
        ;
    
    // zoom out
    paper.setViewBox(0, 0, 1200, 1200, true);
    
   
    $(icon.node).css({
        'stroke-dasharray': '9999px',
        'stroke-dashoffset': '9999px'
    });
    
    $('#small_lotus').on('hover', function(e){
        e.preventDefault();
        
        // the path length
        var len = Raphael.getTotalLength(path)
            ,glow
            ;

        $(icon.node).animate({
            // animate to final value
            'stroke-dashoffset': (9999 - len)+'px'
        },{
            duration: 150000, // 5 sec
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


<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=557750137576961";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</head>

<body>
	<div id="wrapper">
		<div id="header">
			<a class="mykarmalink" href="<?php echo home_url(); ?>/?page_id=60">my karma</a>

			<a href="<?php echo home_url(); ?>"><div id="logo"></div></a>
	
	<nav>
	<ul>
      <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
     </ul>
    </nav>

</div>
<div id="content">	
	<h1>Karma made Easy</h1>
	<h2>Scroll to see the path to an ultimate happiness</h2>


		<div id="how_1" data-50="opacity:0;top:1%;transform-origin:0 0;" data-150="opacity:1;top:-5%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
			<img src="<?php bloginfo('template_directory');?>/images/how/people_bfore.png">
		</div>

    <div id="how_1" data-50="opacity:0;top:2%;left:30%;transform-origin:0 0;" data-150="opacity:1;top:-3%;left:30%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
     <h3 class="how_title">Happy but feeling incomplete?</h3>
    </div>

		<div id="how_2" data-550="opacity:0;top:1%;transform-origin:0 0;" data-600="opacity:1;top:-5%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
			<img src="<?php bloginfo('template_directory');?>/images/how/coins.png">
		</div>

    <div id="how_2" data-550="opacity:0;top:1%;transform-origin:0 0;" data-600="opacity:1;top:-5%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
       <h3 class="how_title">Differen plans to suit your pocket.</h3>
    </div>

		<div id="how_3" data-1300="opacity:0;top:1%;transform-origin:0 0;" data-1350="opacity:1;top:-10%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
			<img src="<?php bloginfo('template_directory');?>/images/how/temple.png">
		</div>

    <div id="how_3" data-1300="opacity:0;left:600px;top:1%;transform-origin:0 0;" data-1350="opacity:1;top:-10%;left:600px;" class="skrollable unrendered" style="left:600px; opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
      <h3 class="how_title">Agents will carry out rituals and provide you with good karma.</h3>
    </div>


		<div id="how_4" data-2150="opacity:0;top:3%;transform-origin:0 0;" data-2250="opacity:1;top:-10%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
			<img src="<?php bloginfo('template_directory');?>/images/how/karma_agents.png">
		</div>

    <div id="how_4" data-2150="opacity:0;top:3%;transform-origin:0 0;" data-2250="opacity:1;top:-10%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
     <h3 class="how_title">Your offering will be brought right to your doorstep.</h3>
         </div>

		<div id="how_5" data-2850="opacity:0;top:3%;transform-origin:0 0;" data-2900="opacity:1;top:-10%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;">
			<img src="<?php bloginfo('template_directory');?>/images/how/people_after.png">
			  <div id="how_big_btn">
      <a class="big_btn" href="http://easykarma.biz/plans/"> Get EasyKarma</a>
    </div>
		</div>
		<div id="how_5_halo" data-2650="opacity:0;top:3%;transform-origin:0 0;" data-2900="opacity:1;top:-10%;" class="skrollable unrendered" style="opacity: 1; top: 3%; -webkit-transform-origin: 0px 0px;"></div>





	<svg class="draw" xmlns="http://www.w3.org/2000/svg" version="1.1" width="900px" height="3000px">
		<path
			style="fill:none;stroke:#ccc;stroke-width:8;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:6400;stroke-dashoffset:0"
			data-0="stroke-dashoffset:6400;" data-end="stroke-dashoffset:0;"

			 d="M155.547,159.68c0,0,33.346,89.049,104.666,59.333c56-23.333,108.001-54.666,157.334-22.333c59.34,38.892,178,99.333,205.333,41 c20.636-44.041-21.307-85.335-73.333-88.667c-54.227-3.473-134,52-137.333,121.333c-5.174,107.619,45.999,95.333,103.333,132.333 c38.601,24.911,77.999,56.999,70.666,171.666c-4.599,71.911-105.666,189.334-224.666,114.334c-118.994-74.996-354.459-12.763-238,92 c89.254,80.29,261.457,152.985,382,291c128.429,147.044-176,206-282,202c-134.136-5.062-191.396-34.947-171.896-85.944 c15.094-39.478,107.622-26.161,127.494,44.998c29.34,105.066,4.432,196.966,134.992,224.988 c72.229,15.503,175.495,31.641,227.471,188.609c43.271,130.68-131.551,153.975-210.78,150.984 c-100.26-3.783-136.684,63.89-109.685,126.887c0,0,46.97,168.989,313.956,227.486s220.488,275.983,70.495,295.482 s-356.983,196.491-307.485,364.482s506.976,314.984,520.475,74.996S569.595,2609.165,478.1,2738.158s-6,304.483,131.993,425.978"/></svg>
	


	<script type="text/javascript" src="<?php bloginfo('template_directory');?>/dist/skrollr.min.js"></script>
	<script type="text/javascript">
	skrollr.init({
		forceHeight: false
	});
	</script>
</div>
<?php get_footer(); ?>
