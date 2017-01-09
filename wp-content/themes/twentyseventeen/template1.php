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
<?php 
// the query
$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>

<?php if ( $wpb_all_query->have_posts() ) : ?>
<center>
	

	<!-- the loop -->
	<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
		<!-- <h3><?php the_date('Y-m-d', '<h2>', '</h2>'); ?></h3> -->
		<?php
			echo get_the_post_thumbnail( null, $size = 'post-thumbnail', $attr = ''  );
		?>
		<h3><?php echo get_the_date(); ?></h3>
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<P><?php echo get_the_content();  ?></P>
		<p><?php $author = get_the_author(); echo $author;?></p>
		<p>------------------------------------------------------------------</p>
	<?php endwhile; ?>
	<!-- end of the loop -->

		
</center>

<br/><br/><br/>



	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<?php
	get_footer();
?>