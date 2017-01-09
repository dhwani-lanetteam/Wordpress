<?php
	/*
 * Template Name: template3
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
	get_header();
	//get_sidebar();
?>
<center>
	<h2>Custom Post Listing</h2>
</center>
<?php
	// $post_types = get_post_types();
	// print_r($post_types);
	// foreach ( get_post_types( '', 'names' ) as $post_type )
	// {
 //  		echo '<p>' . $post_type . '</p>';
	// }

	$post_type = 'books';
	// the query
	$wpb_all_query = new WP_Query(array('post_type'=>$post_type, 'post_status'=>'publish', 'posts_per_page'=>-1));
	//echo '<pre>';
	//print_r($wpb_all_query);
	if($wpb_all_query->have_posts())
	{
		// echo "it has posts";
		while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
    		?>
    		<center>
    		<div>
    			<a href="<?php echo get_permalink()?>"><?php echo the_title();?></a>
    			<br/>
    			<?php
    				if(has_post_thumbnail()) {
    					echo get_the_post_thumbnail( null, $size = 'post-thumbnail', $attr = ''  );
    				}	else {
    					//echo "No Thumbnail";
    					?>
    						<img src="<?php echo get_template_directory_uri() ?>/assets/images/book-image.png" alt="<?php the_title(); ?>" />
    					<?php
    				}
    			?>
    			<br/>
					<br/>
    			<P><?php echo get_the_excerpt();  ?></P>
					<br/>
					<!-- <a href="<?php echo get_post_type_archive_link( 'books' ); ?>">Movies Archive</a> -->
					<a href="<?php echo get_permalink()?>">Read more...</a>
    			<?php
    				$post_id = get_the_ID();
    				$arr = get_post_meta($post_id,'_price_metabox_id', true );
    			?>
    			<p>Price : <?php echo $arr?> </p>
    		</div>
    		<div style="background:#000000; height: 5px; width:100%"></div>
    		</center>

    		<?php
		endwhile;
	}
	else
	{
		// echo "No post available";
	}

?>
<?php
	get_footer();
?>
