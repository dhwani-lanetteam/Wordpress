<!DOCTYPE html>
<html>
<head>
<title>Quickly a Blogging Category Flat Bootstarp Resposive Website Template | Home :: w3layouts</title>
<!-- for-mobile-apps -->
<?php wp_head(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Quickly Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="<?php echo get_template_directory_uri()?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo get_template_directory_uri()?>/assets/css/style.css" rel="stylesheet" type="text/css" media="all" />

<!-- js -->
	<script src="<?php echo get_template_directory_uri()?>/assets/js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/assets/js/move-top.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/assets/js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
</head>

<body>
<!-- banner-body -->
	<div class="banner-body">
		<div class="container">
<!-- header -->
	<?php //do_shortcode('[google-translator]');
	  echo do_shortcode('[google-translator]');  ?>
			<div class="header">
				<div class="header-nav">
					<nav class="navbar navbar-default">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						   <a class="navbar-brand" href="index.php"><span>Q</span>uickly</a>
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
						 <?php wp_nav_menu(array(
							 												'menu'=>'primary',
						 												  'menu_class'=>array('nav','navbar-nav'),
																			'container'=> '',
																			'items_wrap'=>'<ul>%3$s</ul>'
																		)); ?>
						 <!-- <ul class="nav navbar-nav">
							<li class="hvr-bounce-to-bottom active"><a href="index.html">Home</a></li>
							<li class="hvr-bounce-to-bottom"><a href="about.html">About</a></li>
							<li class="hvr-bounce-to-bottom"><a href="Portfolio.html">Portfolio</a></li>
							<li class="hvr-bounce-to-bottom"><a href="Pages.html">Pages</a></li>
							<li class="hvr-bounce-to-bottom"><a href="contact.html">Contact Us</a></li>
						  </ul> -->
						  <!-- <div class="sign-in">
							<ul>
								<li><a href="login.html">Sign In </a>/</li>
								<li><a href="register.html">Register</a></li>
							</ul>
							</div> -->
						</div><!-- /.navbar-collapse -->
					</nav>
				</div>

			<!-- search-scripts -->
			<!-- <script src="<?php echo get_template_directory_uri()?>/assets/js/classie.js"></script>
			<script src="<?php echo get_template_directory_uri()?>/assets/js/uisearch.js"></script> -->
				<script>
					//new UISearch( document.getElementById( 'sb-search' ) );
				</script>
			<!-- //search-scripts -->
			</div>
<!-- //header -->
<!-- header-bottom -->
	<div class="header-bottom">
		<div class="header-bottom-top">
			<ul>
				<li><a href="#" class="g"> </a></li>
				<li><a href="#" class="p"> </a></li>
				<li><a href="#" class="facebook"> </a></li>
				<li><a href="#" class="twitter"> </a></li>
			</ul>
		</div>
		<div class="clearfix"> </div>
