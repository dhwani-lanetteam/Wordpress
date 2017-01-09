<?php
/* 
	 * Template Name: template4
*/

get_header();
	//echo "Hello";
	do_shortcode('[price-criteria bookprice=400 bookpage=444 ]');

	//$templateDir = get_template_directory_uri();
	echo wp_upload_dir();
	// do_shortcode('[display-img 
	// 	img_url1="http://localhost/wordpress_intro/wp-content/uploads/2016/12/rose.jpg" 
	// 	img_url2="" 
	// 	img_url3=""]')

get_footer();


?>
