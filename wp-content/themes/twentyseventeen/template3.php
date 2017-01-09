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
    			<?php echo get_the_post_thumbnail( null, $size = 'post-thumbnail', $attr = ''  );?>
    			<br/>
    			<P><?php echo get_the_excerpt();  ?></P><a href="<?php echo get_permalink()?>">Read more...</a>
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