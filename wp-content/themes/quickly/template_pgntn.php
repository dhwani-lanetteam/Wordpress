<?php
/*
 * Template Name: pagination
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header();
?>
<h1>Pagination</h1>
<input type="button" name="btn_next" id="btn_next" value="NEXT">
<input type="hidden" name="hdn_offset" id="hdn_offset" value=1>
<input type="button" name="btn_prev" id="btn_prev" value="PREV">
<?php
$post_type = 'books';
// the query
$wpb_all_query = new WP_Query(array('post_type'=>$post_type, 'post_status'=>'publish','order' => 'ASC', 'posts_per_page'=>1 , 'offset' => 0));
if($wpb_all_query->have_posts())
{
  // echo "it has posts";
  while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
      ?>
      <center>
        <p id="post_title" name="post_title"><?php echo the_title();?></p>
        <br/>
        <br/>
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
