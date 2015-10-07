<?php
/**
 * Template Name: Home Page
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
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
  <meta name="description" content="Easy Karma is a service that will help you to reach the ultimate spiritual goals with a minimum effort.">
  <meta name="author" content="">
<meta property="og:image" content="http://easykarma.biz/wp-content/uploads/2013/05/avatar.jpg"/>
<meta property="og:title" content="EasyKarma - Doing good Karma the Buddhist way"/>
<meta property="og:description" content="Easy Karma is a service that will help you to reach the ultimate spiritual goals with a minimum effort."/>

<meta property="og:site_name" content="EasyKarma"/>
<meta property="og:type" content="website"/>
<meta itemprop="name" content="EasyKarma">
<meta itemprop="description" content="Easy Karma is a service that will help you to reach the ultimate spiritual goals with minimum effort. Doing good karma in the Buddhist way is easier than ever before.">
<meta itemprop="image" content="http://easykarma.biz/wp-content/uploads/2013/05/avatar.jpg">


  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="<?php bloginfo('template_directory');?>/dist/jquery.min.js"></script>
<script src="<?php bloginfo('template_directory');?>/dist/raphael-min.js"></script>

<script type="text/javascript">
  
  $(document).ready( function() {
  
    // When site loaded, load the Popupbox First
    loadPopupBox();
  
    $('#popupBoxClose').click( function() {     
      unloadPopupBox();
    });
    
    $('#container').click( function() {
      unloadPopupBox();
    });

    function unloadPopupBox() { // TO Unload the Popupbox
      $('#popup_box').fadeOut("slow");
      $("#container").css({ // this is just for style   
        "opacity": "1"  
      }); 
    } 
    
    function loadPopupBox() { // To Load the Popupbox
      $('#popup_box').fadeIn("slow");
      $("#container").css({ // this is just for style
        "opacity": "0.3"  
      });     
    }
    /**********************************************************/
    
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
	
	function scrollToDiv(element,navheight){
	
		
	
		var offset = element.offset();
		var offsetTop = offset.top;
		var totalScroll = offsetTop-navheight;
		
		$('body,html').animate({
				scrollTop: totalScroll
		}, 4000);
	
	}
	
	
	
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
    if($(window).scrollTop() >=5000) {
       $(window).scrollTop(0);
    }
});

$(window).scrollTop(10000);





</script>
<script type="text/javascript">$(function(){





    
     var paper = Raphael('coffee', 1200, 1200)
    
       ,path = 'M87.524,641.045 M395.308,458.17 M492.356,462.412 M443.856,453.953c-71.125-3.103-131.301,52.036-134.409,123.16c-3.104,71.129,52.036,131.306,123.161,134.412c71.134,3.111,131.305-52.036,134.413-123.157C570.132,517.235,514.986,457.062,443.856,453.953z M391.684,458.82 M320.064,524.443 M217.004,571.49 c0,0,94.168,9.932,100.949-44.026c0,0-88.581-70.838-184.644,39.344l-0.108,2.41c86.089,118.144,180.513,55.294,180.513,55.294 c-2.046-54.348-96.727-52.653-96.727-52.653L217.004,571.49z M273.689,730.802c0,0,73.614-59.567,40.259-102.508 c0,0-112.726,12.542-102.748,158.379l1.633,1.78c144.412,22.664,166.74-88.541,166.74-88.541 c-39.878-36.98-105.632,31.16-105.632,31.16L273.689,730.802z M426.43,803.372c0,0,9.938-94.176-44.019-100.953 c0,0-70.838,88.579,39.34,184.641l2.413,0.11C542.3,801.078,479.45,706.66,479.45,706.66c-54.345,2.048-52.651,96.726-52.651,96.726 L426.43,803.372z M586.166,746.53c0,0-59.565-73.614-102.515-40.257c0,0,12.548,112.726,158.386,102.746l1.777-1.628 c22.657-144.415-88.542-166.742-88.542-166.742c-36.989,39.878,31.155,105.63,31.155,105.63L586.166,746.53z M658.915,593.389 c0,0-94.173-9.937-100.945,44.018c0,0,88.581,70.841,184.644-39.335l0.099-2.414c-86.088-118.138-180.507-55.289-180.507-55.289 c2.051,54.343,96.725,52.654,96.725,52.654L658.915,593.389z M561.812,536.168c-33.352-42.941,40.264-102.509,40.264-102.509 l-0.251-0.274c0,0-65.755,68.146-105.626,31.167 M129.126,567.424C121.688,737.695,253.699,881.758,423.975,889.2 c170.271,7.434,314.331-124.57,321.773-294.838 M391.791,456.404 M392.198,455.642 M392.198,455.642 M399.651,478.418 c-57.849,20.654-88.011,84.284-67.362,142.132c20.646,57.85,84.278,88.013,142.129,67.361 c57.849-20.644,88.01-84.275,67.363-142.127C521.139,487.933,457.5,457.774,399.651,478.418z M420.952,536.093 c-25.464,9.09-38.746,37.102-29.656,62.569c9.088,25.471,37.106,38.745,62.571,29.658c25.471-9.09,38.746-37.101,29.65-62.571 C474.429,540.279,446.425,527.003,420.952,536.093z M100.707,567.999c-8.142,186.407,136.376,344.122,322.787,352.269 c186.41,8.144,344.129-136.376,352.271-322.778 M316.422,524.102c-73.441-26.446-83.446-84.601-83.446-84.601 s-34.183-9.174-73.319,13.421l-0.505,0.179c8.064,44.464,37.968,63.785,37.968,63.785S245.543,486.626,316.422,524.102 M311.139,628.774c-70.875,32.724-119.054-2.515-119.054-2.515s-30.777,17.508-42.642,61.649l-0.234,0.492 c37.132,26.644,72.029,19.542,72.029,19.542S234.296,651.658,311.139,628.774 M311.139,628.774 c-70.875,32.724-119.054-2.515-119.054-2.515s-30.777,17.508-42.642,61.649l-0.234,0.492c37.132,26.644,72.029,19.542,72.029,19.542 S234.296,651.658,311.139,628.774 M380.626,704.293c-26.981,73.253-85.962,82.401-85.962,82.401s-9.375,34.146,13.44,73.744 l0.182,0.516c45.092-7.419,64.079-35.616,64.079-35.616S342.472,774.808,380.626,704.293 M484.266,709.827 c32.732,70.889-2.514,119.063-2.514,119.063s17.514,30.768,61.649,42.639l0.491,0.232c26.646-37.134,19.542-72.03,19.542-72.03 S507.154,786.677,484.266,709.827 M559.49,640.639c73.257,26.98,82.407,85.959,82.407,85.959s34.146,9.379,73.744-13.435 l0.513-0.185c-7.414-45.098-37.111-64.75-37.111-64.75S630.016,678.793,559.49,640.639 M565.327,536.711 c70.879-32.724,119.052,2.51,119.052,2.51s30.775-17.514,42.643-61.645l0.234-0.497c-37.136-26.644-72.034-19.542-72.034-19.542 S642.17,513.823,565.327,536.711 M495.551,460.327 M495.551,460.327 M193.348,514.317c-14.886-9.095-27.077-32.312-27.077-32.312 s-18.191,5.818-28.562,25.179c3.8,21.619,19.252,32.454,19.252,32.454s18.843-18.271,35.824-22.293l0.888-1.601L193.348,514.317z M216.92,708.617c-16.683,4.092-39.951-4.287-39.951-4.287s-8.491,16.775-2.078,37.5c17.812,12.371,36.104,9.097,36.104,9.097 s1.208-24.922,9.123-40.562l-1.651-0.625L216.92,708.617z M370.097,829.663c-9.917,14.487-30.403,23.506-30.403,23.506 s3.064,14.741,22.699,25.964c22.46-2.867,33.878-14.601,33.878-14.601s-16.955-18.626-23.329-34.56l-1.446-2.028L370.097,829.663z M564.41,803.311c3.224,17.303-6.195,42.549-6.195,42.549s14.532,5.278,36.426-0.709c13.916-17.973,14.347-34.292,14.347-34.292 s-24.329-1.443-41.888-9.266l-1.271,0.579L564.41,803.311z M679.646,648.678c15.34,9.827,27.229,31.563,27.229,31.563 s17.33-3.452,28.894-22.458c-3.274-21.929-20.927-32.438-20.927-32.438s-17.954,18.578-34.905,23.041l0,0L679.646,648.678z M186.866,440.126c0,0,26.561-7.176,44.087-2.216l0.95-1.524l0.87,0.29 M189.018,622.053c-17.521-5.003-34.601-26.709-34.601-26.709 s-16.593,11.059-21.501,33.616c9.958,20.822,28.536,27.418,28.536,27.418s13.713-23.848,29.61-32.739l-1.201-1.454L189.018,622.053z M290.693,787.694c-11.872,6.948-41.127,4.049-41.127,4.049s-6.158,16.896,6.318,36.315c21.77,7.685,39.567-0.787,39.567-0.787 s-6.295-21.959-1.574-37.84l0.582-3.191L290.693,787.694z M482.785,825.82c-5.005,17.514-28.658,36.602-28.658,36.602 s9.899,16.792,32.457,21.698c20.827-9.959,23.672-26.897,23.672-26.897s-19.877-15.412-28.761-31.311l0.989-0.587L482.785,825.82z M642.288,730.631c6.374,12.166,6.006,41.877,6.006,41.877s18.754,3.736,37.393-8.266c7.4-20.91-0.706-37.992-0.706-37.992 s-25.486,6.92-42.294,2.185l-0.174,1.798L642.288,730.631z M686.021,541.225c17.084,6.375,33.832,25.062,33.832,25.062 s17.108-10.367,22.536-30.962c-9.753-18.741-28.547-24.382-28.547-24.382s-13.05,18.412-28.112,28.837l0.291,0.869V541.225z M655.83,456.078c17.911-3.977,41.263,3.504,41.263,3.504s10.463-15.604,5.268-37.265c-17.866-13.157-37.91-7.998-37.91-7.998 s-1.021,26.988-8.62,41.322V456.078L655.83,456.078z M403.354,546.73c9.436-9.111,30.679-13.841,30.679-13.841 s-33.482-41.875-70.765-29.439l-1.106,1.071c-13.721,36.829,25.176,72.661,25.176,72.661S394.072,555.7,403.354,546.73z M401.904,617.106c-9.106-9.433-14.938-30.169-14.938-30.169s-41.872,33.482-29.437,70.76l1.071,1.109 c36.823,13.722,72.659-25.178,72.659-25.178S410.874,626.391,401.904,617.106z M471.125,617.684 c-9.434,9.115-29.883,14.769-29.883,14.769s33.475,41.872,70.756,29.437l1.105-1.069c13.727-36.829-25.173-72.664-25.173-72.664 S480.415,608.717,471.125,617.684z M472.862,548.759c9.114,9.429,14.337,30.294,14.337,30.294s41.866-33.48,29.43-70.763 l-1.071-1.106c-36.826-13.719-72.661,25.179-72.661,25.179S463.896,539.466,472.862,548.759z M438.739,472.729 c-19.654,7.515-27.746,39.741-27.746,39.741s20.209,16.707,22.171,20.419l11.932-0.046c1.962-3.712,22.543-19.94,22.543-19.94 s-7.945-32.806-27.597-40.321L438.739,472.729z M326.452,580.101c7.519,19.657,39.744,27.747,39.744,27.747 s16.705-20.207,20.421-22.169l-0.045-11.933c-3.712-1.961-19.942-22.546-19.942-22.546s-32.807,7.948-40.32,27.603L326.452,580.101z M435.717,693.775c19.656-7.516,27.748-39.744,27.748-39.744s-20.21-16.704-22.169-20.416l-11.937,0.045c-1.961,3.713-22.547,19.941-22.547,19.941s7.95,32.806,27.606,40.32L435.717,693.775z M546.116,586.753 c-7.516-19.657-39.017-27.22-39.017-27.22s-16.331,18.828-20.045,20.79l-0.292,9.558c4.728-1.01,22.258,24.762,22.258,24.762s29.728-6.938,37.24-26.59L546.116,586.753z'
        ,icon = paper.path(path).attr({ stroke: '#ffffff', 'stroke-width': '2','fill-opacity': 0 })
        ;
    
    // zoom out
    paper.setViewBox(0, 0, 1200, 1200, true);
    
   
    $(icon.node).css({
        'stroke-dasharray': '9999px',
        'stroke-dashoffset': '9999px'
    });
    
    $('#block4').on('hover', function(e){
        e.preventDefault();
        
        // the path length
        var len = Raphael.getTotalLength(path)
            ,glow
            ;

        $(icon.node).animate({
            // animate to final value
            'stroke-dashoffset': (9999 - len)+'px'
        },{
            duration: 180000, // 5 sec
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
<?php wp_head(); ?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=557750137576961";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41121789-1', 'easykarma.biz');
  ga('send', 'pageview');

</script>
</head>
<body>

<div id="popup_box">  <!-- OUR PopupBox DIV-->
  <h1>Hi,this site is best viewd with Google Chrome or Safari browsers.</h1>
  <a id="popupBoxClose">Close</a> 
</div>


<div id="content_home">
<!--  block 1 starts -->
  <div id="block1" class="resize_window">
    <div id="chakra" class="resize_windo"  data-0="background-position:50% 0px;" data-89000="background-position:50% -50000px;"></div>
    <div class="box">
      <h1 class="center_text">“However many holy words you read, however many you speak,<br>
        what good will they do you if you do not act on upon them?”</h1>
      <br>
      <h2 class="center_text">- Gautama Buddha - </h2>
      <div id="logo"></div>
      <p class="center_text">Sometimes being a perfect Buddhist gets in the way of your busy schedule.<br> Turn to EASY KARMA where we attend to all your spiritual needs for you.
       </p>
      <a class="slide" href="#block2"></a> </div>
  </div>
  <img class="bg" src="<?php bloginfo('template_directory');?>/images/flag_line.png">
<!--  block 2 starts -->
  <div id="block2" class="resize_window">
    <div id="verse_wrapper_b2" data-600="opacity:0;top:1%;transform-origin:0 0;" data-800="opacity:1;top:%5;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      <div class="versediv2">
        <p class="verse2">"Whomsoever in this world<br>
this wretched clinging craving routs<br>
for such a one do sorrows grow<br>
as grass well-soaked with rain."</p>
        Do you feel sad and dissatisfied? Do you feel like the happiness you’ve achieved is in complete? We will guide you towards a complete spiritual happyness and you don’t have to change your day.<br>
Does the feel of incomplete happiness haunt you, All you have to do is click.

        <br>
        <a class="slide center" href="#block3"><b></b></a> </div>
    </div>

    <!--  responsive verse for short browser window -->
    <div id="verse_wrapper_b2_short" data-500="opacity:0;top:1%;transform-origin:0 0;" data-600="opacity:1;top:%5;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      <div class="versediv2">
        <p class="verse2">"Whomsoever in this world<br>
this wretched clinging craving routs<br>
for such a one do sorrows grow<br>
as grass well-soaked with rain."</p>
        Do you feel sad and dissatisfied? Do you feel like the happiness you’ve achieved is in complete? We will guide you towards a complete nirvana and you don’t have to change your day.<br>
Does the feel of incomplete happiness haunt you have to do is click.
        <br>
        <a class="slide center" href="#block3"><b></b></a> </div>
    </div>

    <div id="man"></div>
    <div id="man_small"></div>
    <div class="resize_window" id="halo1"data-1000="opacity:0;top:3%;transform-origin:0 0;" data-1200="opacity:1;top:-10%;"></div>
    <div id="" data-0="background-position:50% 0px; opacity:1;" data-end="background-position:50% -44000px; opacity:0;"></div>
  </div>
  <img class="bg" src="<?php bloginfo('template_directory');?>/images/flag_line.png">

<!--  block 3 starts -->
  <div id="block3" class="resize_window">
    <div id="gradient"></div>
    <div id="verse_wrapper_b2" data-1400="opacity:0;top:1%;transform-origin:0 0;" data-1600="opacity:1;top:%6;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      <div class="versediv2">
        <p class="verse2">"What should be done is left undone <br>
          and done is what should not be done, <br>
          ever the pollutions grow<br>
          of those ones proud and heedless"</p>
        The karma agents employed at EASY KARMA are qualified to provide you with a complete set of Buddhist rituals with care and passion.<br> And you can attract all the good karma that your pockets can hold.<br>
        <br>
        <a class="slide center" href="#block5"><b></b></a> </div>
    </div>

    <!--  responsive verse for short browser window -->
  <div id="verse_wrapper_b2_short" data-1300="opacity:0;top:1%;transform-origin:0 0;" data-1500="opacity:1;top:6%;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      <div class="versediv2">
        <p class="verse2">"What should be done is left undone <br>
          and done is what should not be done, <br>
          ever the pollutions grow<br>
          of those ones proud and heedless"</p>
       The karma agents employed at EASY KARMA are qualified to provide you with a complete set of Buddhist rituals with care and passion.<br> And you can attract all the good karma that your pockets can hold.<br>
        <br>
        <a class="slide center" href="#block5"><b></b></a> </div>
    </div>

    <DIV id="box_content">
  

      <div class="resize_window" id="box_front"></div>
      <div class="resize_window" id="box_back"></div>
      <div id="flower_1" data-0="background-position:50% 0px; opacity:1;" data-end="background-position:50% -50000px; opacity:0;"></div>
      <div id="flower_2" data-0="background-position:50% 0px; opacity:1;" data-end="background-position:50% -63000px; opacity:0;"></div>
      <div id="flower_3" class="resize_window" data-0="background-position:50% 0px; opacity:1;" data-end="background-position:50% -63000px; opacity:0;"></div>
      <div id="halo" class="resize_window" data-1200="opacity:0;transform-origin:0 0;" data-1700="opacity:1;"></div>
    </div>
  </div>
  <img class="bg" src="<?php bloginfo('template_directory');?>/images/flag_line.png">

<!--  block 5 starts -->
  <div id="block5" class="resize_window">
    
    <div id="verse_wrapper_b2" data-2300="opacity:0;top:1%;transform-origin:0 0;" data-2500="opacity:1;top:%6;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      <div class="versediv2">
        <p class="verse2">"There’s no fire like lust,<br>
no evil like aversion,<br>
no dukkha like the aggregates,<br>
no higher bliss than Peace."</p>
        Place your trust in EASY KARMA. Our Karma agents are qualified to ensure your satisfaction using cutting edge business experiences and services.<br> You will receive all offerings made during the ceremony to your doorstep.<br>
        <br>
        <a class="slide center" href="#block4"><b></b></a> </div>
    </div>

    <!--  responsive verse for short browser window -->
  <div id="verse_wrapper_b2_short" data-2200="opacity:0;top:1%;transform-origin:0 0;" data-2400="opacity:1;top:6%;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      <div class="versediv2">
        <p class="verse2">"What should be done is left undone <br>
          and done is what should not be done, <br>
          ever the pollutions grow<br>
          of those ones proud and heedless"</p>
        Place your trust in EASY KARMA. Our Karma agents are qualified to ensure your satisfaction using cutting edge business experiences and services.<br> You will receive all offerings made during the ceremony to your doorstep.<br>
        <br>
        <a class="slide center" href="#block4"><b></b></a> </div>
    </div>

<div id="icons">
	<H2></h2>
<ul>
	<li><img src="<?php bloginfo('template_directory');?>/images/icon_agent.png"><p>An experienced dedicated<br> team of Karma Agents</p></a></li>
	<li><img src="<?php bloginfo('template_directory');?>/images/icon_del.png"><p> Offerings <br>deliverd to your doorstep</p></a></li>
	<li><img src="<?php bloginfo('template_directory');?>/images/icon_pay.png"><p>Mange your Karma <br>and Payments Online</p></a></li>
	
	<li><img src="<?php bloginfo('template_directory');?>/images/icon_temp.png"><p>More than 150 temples<br> and venues to select from</p></a></li>
  
</ul>
</div>



  </div>
  <img class="bg" src="<?php bloginfo('template_directory');?>/images/flag_line.png">
<!--  block 4 starts -->
  <div id="block4" class="resize_window">

    <div id="verse_wrapper_b4" data-2800="opacity:0;top:1%;transform-origin:0 0;" data-3000="opacity:1;top:6%;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      
      <div class="versediv2">
        <p class="verse2">"This is the path, no other’s there <br>
for purity of insight and mind" <br>
          
        <br>
      </div>
    </div>


<div id="verse_wrapper_b4" data-2900="opacity:0;top:1%;transform-origin:0 0;" data-3150="opacity:1;top:6%;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      
        <div id="home_big_btn">
      
      <a class="big_btn" href="http://easykarma.biz/plans/"> Get EasyKarma</a>
    </div>
     
   </div>

    
       
   
  	

    <div id="verse_wrapper_b4" data-3000="opacity:0;top:1%;transform-origin:0 0;" data-3100="opacity:1;top:2%;"  class="skrollable unrendered" style="opacity: 1; top: -5%; -webkit-transform-origin: 0px 0px;">
      
        <nav class="home_nav">
      
        <?php wp_nav_menu( array( 'theme_location' => 'home-menu' ) ); ?>
      
        </nav>
     
   </div>
    
    
    <div class="resize_window" id="container">
      <div id="coffee"></div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
<script type="text/javascript">
	if(location.search === '?debug') {
		document.write('<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"><' + '/script>');
	}
	</script> 
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/dist/skrollr.min.js"></script> 
<script type="text/javascript">
	//http://detectmobilebrowsers.com/ + tablets
	(function(a) {
		if(/android|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(ad|hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|playbook|silk/i.test(a)
		||
		/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))
		{
			//Add skrollr mobile on mobile devices.
			document.write('<script type="text/javascript" src="<?php bloginfo('template_directory');?>/dist/skrollr.mobile.min.js"><\/script>');
		}
	})(navigator.userAgent||navigator.vendor||window.opera);
	</script> 

<!--[if lt IE 9]>
	<script type="text/javascript" src="dist/skrollr.ie.min.js"></script>
	<![endif]--> 

<script type="text/javascript">
	var s = skrollr.init({
		beforerender: function(data) {
			//console.log('beforerender');
		},
		render: function() {
			//console.log('render');
		},
		
	});
	</script> 
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/dist/skrollr.min.js"></script> 
<script type="text/javascript">
	skrollr.init({
		forceHeight: false
	});
	</script>
</body>
</html>
