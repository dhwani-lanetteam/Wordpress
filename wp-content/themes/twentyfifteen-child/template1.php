<?php 

/* 
 * Template Name: template1
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
	get_header();
?>
<div class="banner">
<!-- Slider-starts-Here -->
				<script src="<?php echo get_template_directory_uri()?>/assets/js/responsiveslides.min.js"></script>
				 <script>
				    // You can also use "$(window).load(function() {"
				    $(function () {
				      // Slideshow 4
				      $("#slider3").responsiveSlides({
				        auto: true,
				        pager: false,
				        nav: true,
				        speed: 500,
				        namespace: "callbacks",
				        before: function () {
				          $('.events').append("<li>before event fired.</li>");
				        },
				        after: function () {
				          $('.events').append("<li>after event fired.</li>");
				        }
				      });
				
				    });
				  </script>
			<!--//End-slider-script -->
				<div  id="top" class="callbacks_container wow fadeInUp" data-wow-delay="0.5s">
					<ul class="rslides" id="slider3">
						<li>
							<div class="banner-inf">
								<h3>soluta nobis est eligendi cumque</h3>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In lobortis, ante interdum vehicula pretium, dui enim porta
								lectus, non euismod tortor ante eu libero</p>
								<a href="single.html">See More</a>
							</div>
						</li>
						<li>
							<div class="banner-inf">
								<h3>euismod nobis est eligendi cumque</h3>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In lobortis, ante interdum vehicula pretium, dui enim porta
								lectus, non euismod tortor ante eu libero</p>
								<a href="single.html">See More</a>
							</div>
						</li>
						<li>
							<div class="banner-inf">
								<h3>tortor nobis est eligendi cumque</h3>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In lobortis, ante interdum vehicula pretium, dui enim porta
								lectus, non euismod tortor ante eu libero</p>
								<a href="single.html">See More</a>
							</div>
						</li>
					</ul>
				</div>
		</div>
<!-- //banner -->
<!-- banner-bottom -->

			<div class="banner-bottom">
			<?php 
			// the query
			$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>

			<?php if ( $wpb_all_query->have_posts() ) : ?>
				<ul id="flexiselDemo1">	
				<!-- the loop goes here -->	
				<?php
					while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
					// echo  get_the_date();
				?>	
					<li>
						<div class="banner-bottom-grid">
							<img src="<?php echo the_post_thumbnail_url( 'thumbnail' ); ?>" alt=" " class="img-responsive" />
							<!-- content of the post -->
							<p><?php echo get_the_excerpt();?></p>
							<!-- Read more button -->
							<div class="more">
								<a href="<?php echo get_permalink();?>" class="hvr-bounce-to-bottom sint">Read More</a>
							</div>
						</div>
					</li>
				<?php endwhile; ?>
					<!-- <li>
						<div class="banner-bottom-grid">
							<img src="<?php echo get_template_directory_uri()?>/assets/images/2.jpg" alt=" " class="img-responsive" />
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus 
								qui blanditiis praesentium voluptatum deleniti atque corrupti 
								quos dolores et quas molestias excepturi sint occaecati
								cupiditate non provident</p>
							<div class="more">
								<a href="single.html" class="hvr-bounce-to-bottom sint">Read More</a>
							</div>
						</div>
					</li>
					<li>
						<div class="banner-bottom-grid">
							<img src="<?php echo get_template_directory_uri()?>/assets/images/3.jpg" alt=" " class="img-responsive" />
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus 
								qui blanditiis praesentium voluptatum deleniti atque corrupti 
								quos dolores et quas molestias excepturi sint occaecati
								cupiditate non provident</p>
							<div class="more">
								<a href="single.html" class="hvr-bounce-to-bottom sint">Read More</a>
							</div>
						</div>
					</li> -->
				</ul>
				<?php wp_reset_postdata(); ?>
				<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
				<script type="text/javascript">
							$(window).load(function() {
								$("#flexiselDemo1").flexisel({
									visibleItems: 3,
									animationSpeed: 1000,
									autoPlay: false,
									autoPlaySpeed: 3000,    		
									pauseOnHover: true,
									enableResponsiveBreakpoints: true,
									responsiveBreakpoints: { 
										portrait: { 
											changePoint:480,
											visibleItems: 1
										}, 
										landscape: { 
											changePoint:640,
											visibleItems:2
										},
										tablet: { 
											changePoint:768,
											visibleItems: 3
										}
									}
								});
								
							});
					</script>
					<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/assets/js/jquery.flexisel.js"></script>
			</div>
<!-- //banner-bottom -->
<?php 
// the query
//$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>

<?php //if ( $wpb_all_query->have_posts() ) : ?>
	<!-- the loop -->
	<?php //while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
		<!-- <h3><?php the_date('Y-m-d', '<h2>', '</h2>'); ?></h3> -->
		<?php //echo get_the_post_thumbnail( null, $size = 'post-thumbnail', $attr = ''  );?>
		<h3><?php //echo get_the_date(); ?></h3>
		<a href="<?php //the_permalink(); ?>"><?php the_title(); ?></a>
		<P><?php //echo get_the_content();  ?></P>
		<p><?php //$author = get_the_author(); echo $author;?></p>
	<?php //endwhile; ?>
	
	<!-- end of the loop -->




	<?php// wp_reset_postdata(); ?>

<?php //else : ?>
	<p><?php //_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php //endif; ?>

<?php
	get_footer();
?>