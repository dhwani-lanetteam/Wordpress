<?php
/*
* Template Name: template_sb
*/

get_header();
/*
	it will find side bar with name specified. if not found then it will use default side bar
*/
get_sidebar( 'Book Detail Sidebar' ); //--- register_sidebar - name ----//
get_sidebar( 'Post Title Sidebar' ); //--- register_sidebar - name ----//

get_footer();


?>
