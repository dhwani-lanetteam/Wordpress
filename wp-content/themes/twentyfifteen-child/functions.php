<?php
function my_theme_enqueue_styles() {

	 $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

	 wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	 wp_enqueue_style( 'child-style',
			 get_stylesheet_directory_uri() . '/style.css',
			 array( $parent_style ),
			 wp_get_theme()->get('Version')
	 );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

add_action('wp_enqueue_scripts','custom_css');
function custom_css() {
	wp_enqueue_style('myCss',get_template_directory_uri().'/css/mycss.css');
	wp_enqueue_style('myTableCss',get_template_directory_uri().'/css/mytable.css');
	// wp_enqueue_style('myCss');
//	wp_enqueue_scripts('jquery','https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');
}

add_action( 'wp_ajax_insert_contact_data', 'insert_contact_data' );
add_action( 'wp_ajax_nopriv_insert_contact_data', 'insert_contact_data' );
function insert_contact_data()
{
	//echo "Success to ajax call";
	if ( isset($_REQUEST) ) {
		$Json = array();
			$fnm = $_REQUEST['firstName'];
			$lnm = $_REQUEST['lastName'];
			$mbl = $_REQUEST['mobile'];
			$eml = $_REQUEST['email'];
			$msg = $_REQUEST['message'];

			//echo $fnm."\t".$lnm."\t".$mbl."\t".$eml."\t".$msg;

			if($fnm != "" && $lnm != "" && $mbl != "" && $eml != "" && $msg != "") {
					//echo "All data is set";
					 global $wpdb;
					 $data = array('LastName' => $lnm,
					 'FirstName' => $fnm,
					 'Email' => $eml,
					 'Mobile' => $mbl,
						'Message' => $msg);

					 $wpdb->insert( 'wp_CONTACTS', $data);

					 $Json['status']=true;
					 $Json['message']="Inserted successfully";
					 $Json['id']=$wpdb->insert_id;

					 //echo "Inserted successfully";
			}
			else {
				$Json['message']="Missing Data";
			}

	} else {
		 $Json['message']= "No data found";
	}
	echo json_encode($Json);
	wp_die();
}

add_action( 'wp_ajax_load_contact_data', 'load_contact_data' );
add_action( 'wp_ajax_nopriv_load_contact_data', 'load_contact_data' );
function load_contact_data()
{
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM wp_CONTACTS', ARRAY_A);
	//echo "sucess call";
	//print_r($results);
	$str = "";
	$str .= "<tr>
    <th data-th='Driver details'><span>First name</span></th>
    <th>Last Name</th>
    <th>Email</th>
		<th>Mobile</th>
		<th>Message</th>
		<th>Delete</th>
		<th>Update</th>
  </tr>";
	//die("hello");
	$admin_url = admin_url( 'admin-ajax.php' );
	foreach ($results as $row)
	{
		$del_link = "<a href='#' class='delete-contact' data-id='".$row['ID']."' >Delete</a>";
		$updt_link = "<a href='#' class='update-contact' data-id='".$row['ID']."'>Update</a>";
		$str .= "<tr>";
		$str .= "<td>".$row['FirstName']."</td>";
		$str .= "<td>".$row['LastName']."</td>";
		$str .= "<td>".$row['Email']."</td>";
		$str .= "<td>".$row['Mobile']."</td>";
		$str .= "<td>".$row['Message']."</td>";
		$str .= "<td>".$del_link."</td>";
		$str .= "<td>".$updt_link."</td>";
		$str .= "</tr>";
	}
	echo $str;
	wp_die();
}

add_action( 'wp_ajax_remove_contact_data', 'remove_contact_data' );
add_action( 'wp_ajax_nopriv_remove_contact_data', 'remove_contact_data' );
function remove_contact_data()
{
	$Json = array();
	$id = $_REQUEST['contact_id'];
	//echo "Id is : ".$id;
	global $wpdb;
	if($id != 0)
	{
		$wpdb->delete( 'wp_CONTACTS', array( 'ID' => $id ));
		$Json["status"] = true;
		$Json["message"] = "deleted successfully";
	}
	else {
		//echo "Invalid Data";
		$Json["status"] = false;
	  $Json["message"] = "Error in Delete";
	}
	echo json_encode($Json);
	wp_die();
}

add_action( 'wp_ajax_get_contact_data', 'get_contact_data' );
add_action( 'wp_ajax_nopriv_get_contact_data', 'get_contact_data' );
function get_contact_data()
{
	$Json = array();
	$id = $_REQUEST['contact_id'];
	//echo "Id is : ".$id;
	global $wpdb;
	if($id != 0)
	{
		$qry = "SELECT * FROM `wp_CONTACTS` WHERE `ID` = ".$id;
		$row= $wpdb->get_row($qry);
		$Json["status"] = true;
		$Json["message"] = "Data found";
		$user_data = array();
		$user_data["firstName"] = $row->FirstName;
		$user_data["lastName"] = $row->LastName;
		$user_data["email"] = $row->Email;
		$user_data["mobile"] = $row->Mobile;
		$user_data["message"] = $row->Message;
		$Json["data"] = $user_data;
	}
	else {
		$Json["status"] = false;
		$Json["message"] = "Invalid ID";
		$Json["data"] = array();
	}
	echo json_encode($Json);
	wp_die();

}

add_action( 'wp_ajax_update_contact_data', 'update_contact_data' );
add_action( 'wp_ajax_nopriv_update_contact_data', 'update_contact_data' );
function update_contact_data()
{
	$Json = array();
	//echo "update called";
	$id = $_REQUEST['contact_id'];
	$fnm = $_REQUEST['firstName'];
	$lnm = $_REQUEST['lastName'];
	$mbl = $_REQUEST['mobile'];
	$eml = $_REQUEST['email'];
	$msg = $_REQUEST['message'];

	if($fnm != "" && $lnm != "" && $mbl != "" && $eml != "" && $msg != "") {
		global $wpdb;
		$dataArr = array(
			'LastName'=>$lnm,
			'FirstName'=>$fnm,
			'Email'=>$eml,
			'Mobile'=>$mbl,
			'Message'=>$msg
		);

		$whereArr = array('ID'=>$id);
		$wpdb->update('wp_CONTACTS',$dataArr,$whereArr);
		$Json["status"] = true;
		$Json["message"] = "Updated successfully";
	}
	else {
		$Json["status"] = false;
		$Json["message"] = "Error in update";
	}

	echo json_encode($Json);
	wp_die();
}

add_action( 'wp_ajax_pgntn_get_post', 'pgntn_get_post' );
add_action( 'wp_ajax_nopriv_pgntn_get_post', 'pgntn_get_post' );

function pgntn_get_post() {
	// echo "call sucess to find_next_post";
		$new_offset = -1;
		$post_type = 'books';
		$Json = array();
		$total_post = wp_count_posts( $post_type )->publish;
		echo "TOTAL POST : " + $total_post;
		die("Died here");

	 	$old_offset = $_REQUEST["rowOffset"];
		$is_next = $_REQUEST["isNext"];

		//echo "is_next : ".$is_next;
		 if($is_next == "true") {
			$new_offset = $old_offset + 1;
			if($new_offset > $total_post)
			{
				$new_offset = $total_post;
			}
		}
		else {
			$new_offset = $old_offset - 1;
			if($new_offset <= 0) {
				$new_offset = 1;
			}
		}
		//
		 $Json["offset"] = $new_offset;
		//  $Json['post_title'] = $new_offset;
		//  $Json["have_post"] = true;

			$wpb_all_query = new WP_Query(array('post_type'=>$post_type, 'post_status'=>'publish','order' => 'ASC', 'posts_per_page'=>1 , 'offset' => $new_offset));
   	if($wpb_all_query->have_posts()) {
	  // echo "it has posts";
		$Json["have_post"] = true;

	  	while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
				 $Json['post_title'] = get_the_title();
			endwhile;
		}
		else {
			$Json['post_title'] = 'No Post Available';
			$Json["have_post"] = false;
		}
		echo json_encode($Json);
		wp_die();
}
//-----------------------------------------------------------------------------------------------//
//------------ example widget ----------------------------//
// Register and load the widget
function wpb_load_ex_widget()
{
	register_widget( 'example_widget' );
}
add_action( 'widgets_init', 'wpb_load_ex_widget' );
class example_widget extends WP_Widget
{
  /**
  * To create the example widget all four methods will be
  * nested inside this single instance of the WP_Widget class.
  **/

	public function __construct()
	{
	   $widget_options = array(
	    	'classname' => 'example_widget',
	    	'description' => 'This is an Example Widget',
	    );
	    parent::__construct( 'example_widget', 'Example Widget', $widget_options );
	}

	public function widget( $args, $instance )
	{
  		$title = apply_filters( 'widget_title', $instance[ 'title' ] );
  		$blog_title = get_bloginfo( 'name' );
  		$tagline = get_bloginfo( 'description' );
  		// print_r($args);
  		echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
  	?>
  		<p><strong>Site Name:</strong> <?php echo $blog_title ?></p>
  		<p><strong>Tagline:</strong> <?php echo $tagline ?></p>
  	<?php
  		echo $args['after_widget'];
	}


}

//------------ end example widget --------------------//
//----------------- add widget--------------------------------------//
// Creating the widget
class wpb_widget extends WP_Widget
{

	function __construct()
	{
		parent::__construct(
		// Base ID of your widget
		'wpb_widget',

		// Widget name will appear in UI
		__('Book Detail widget', 'wpb_widget_domain'),

		// Widget description
		array( 'description' => __( 'recent books details widget', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		//echo "instance[ 'no_of_post' ]".$instance[ 'no_of_post' ];
		$wpb_all_query = new WP_Query(array('post_type'=>'books', 'post_status'=>'publish', 'posts_per_page'=>$instance[ 'no_of_post' ],'orderby' => $instance[ 'show_post_by' ]));
		if($wpb_all_query->have_posts())
		{

			//echo "Books available";
			?>
				<ul class="resp-tabs-list"></ul>

			<?php
			while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
				$post_id = get_the_ID();
				$page = get_post_meta($post_id,'_page_metabox_id', true );
				$price = get_post_meta($post_id,'_price_metabox_id',true);

				?>

				<div class="resp-tabs-container">
						<h2 class="resp-accordion resp-tab-active" role="tab" aria-controls="tab_item-0">
							<span class="resp-arrow"></span>Popular
						</h2>
						<div class="tab-1 resp-tab-content resp-tab-content-active" aria-labelledby="tab_item-0" style="display:block">
							<div class="facts">
							  <div class="tab_list">
								<a href="images/7-.jpg" class="b-link-stripe b-animate-go   swipebox" title="">
									<img src="<?php echo get_template_directory_uri()  ?>/assets/images/7.jpg" alt=" " class="img-responsive">
									<?php //the_post_thumbnail('thumbnail', array('class' => ['img-responsive'])); ?>
								</a>
							  </div>
							  <div class="tab_list1">
								<a href="<?php echo get_permalink() ?>"><?php echo get_the_title(); ?></a>
								<p><?php echo get_the_date(); ?> <span><?php echo get_the_excerpt(); ?></span></p>
							  </div>
							  <div class="clearfix"> </div>
							</div>
						</div>
					</div>

				<?php
				// echo "<pre>";
				// echo "<br/>".the_title()."<br/>";
				// echo "Page : ".$page."<br/>";
				// echo "Price : ".$price."<br/>";
				// echo "</pre>";
			endwhile;
		}

		// This is where you run the code and display the output
		//echo __( 'Hello, World!', 'wpb_widget_domain' );
		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance )
	{

		if ( isset( $instance[ 'title' ] ) && isset($instance['no_of_post']) && isset($instance[ 'show_post_by' ])) {
			$title = $instance[ 'title' ];
			$no_of_post = $instance[ 'no_of_post' ];
			$show_post_by = $instance['show_post_by'];
		}	else {
			$title = __( 'New title', 'wpb_widget_domain' );
			$no_of_post = 3;
			$show_post_by = "date";
		}
// Widget admin form
?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		<label for="<?php echo $this->get_field_id( 'no_of_post' ); ?>">No of posts</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'no_of_post' ); ?>" name="<?php echo $this->get_field_name( 'no_of_post' ); ?>" type="text" value="<?php echo esc_attr( $no_of_post ); ?>" />


		<label for="<?php echo $this->get_field_id( 'show_post_by' ); ?>">Display By</label>
		<select class="widefat" name="<?php echo $this->get_field_name( 'show_post_by' ); ?>" id="<?php echo $this->get_field_id( 'show_post_by' ); ?>">
			<option value="date" <?php if($show_post_by == "date") echo "selected"; ?>>Date</option>
			<option value="title" <?php if($show_post_by == "title") echo "selected"; ?>>Title</option>
		</select>
	</p>
<?php
	}

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();

			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

			$instance['no_of_post'] = ( ! empty( $new_instance['no_of_post'] ) ) ? strip_tags( $new_instance['no_of_post'] ) : '';

			$instance['show_post_by'] = ( ! empty( $new_instance['show_post_by'] ) ) ? strip_tags( $new_instance['show_post_by'] ) : '';

		return $instance;
	}
} // Class wpb_widget ends here

/**
 * postTitle widget class
 */
class postTitle_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		// Base ID of your widget
		'postTitle_widget',

		// Widget name will appear in UI
		__('Post Title widget', 'wpb_widget_domain'),

		// Widget description
		array( 'description' => __( 'recent post title widget', 'wpb_widget_domain' ), )
		);
	}

	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		//echo "instance[ 'no_of_post' ]".$instance[ 'no_of_post' ];
		$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>$instance[ 'no_of_post' ]));
		if($wpb_all_query->have_posts())
		{

			//echo "Posts available";
			while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
				echo "<li>";
				echo the_title();
				echo "</li>";
			endwhile;
		}

		// This is where you run the code and display the output
		//echo __( 'Hello, World!', 'wpb_widget_domain' );
		echo $args['after_widget'];
	}
	public function form( $instance )
	{

		if ( isset( $instance[ 'title' ] ) && isset($instance['no_of_post'])) {
			$title = $instance[ 'title' ];
			$no_of_post = $instance[ 'no_of_post' ];
		}	else {
			$title = __( 'New title', 'wpb_widget_domain' );
			$no_of_post = 3;
		}
// Widget admin form
?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		<label for="<?php echo $this->get_field_id( 'no_of_post' ); ?>">No of posts</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'no_of_post' ); ?>" name="<?php echo $this->get_field_name( 'no_of_post' ); ?>" type="text" value="<?php echo esc_attr( $no_of_post ); ?>" />
	</p>
<?php
	}

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();

			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

			$instance['no_of_post'] = ( ! empty( $new_instance['no_of_post'] ) ) ? strip_tags( $new_instance['no_of_post'] ) : '';

		return $instance;
	}


}//--- postTile widget clss ends here ---//

// Register and load the widget
function wpb_load_widget()
{
	register_widget( 'wpb_widget' );
	register_widget('postTitle_widget');
}
add_action( 'widgets_init', 'wpb_load_widget' );
//----------------------------widget end-------------------------------//
//---------------- add side-bar-----------------------------//
function textdomain_register_sidebars()
{

    /* Register the primary sidebar. */
    register_sidebar(
        array(
            'id' => 'unique-sidebar-id',//--- used in dynamic_side bar ---//
            'name' => __( 'Book Detail Sidebar' ),//--- used in get_sidebar---//
            'description' => __( 'sidebar for recent book detail', 'quickly' ),
            'before_widget' => '<div style=" width: 500; padding-left: 750px;" class="pgs"><ul>',
            'after_widget' => '</ul></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );

		// register_sidebar(
    //     array(
    //         'id' => 'unique-sidebar-post_title',//--- used in dynamic_side bar ---//
    //         'name' => __( 'Post Title Sidebar' ),//--- used in get_sidebar---//
    //         'description' => __( 'sidebar for recent post title', 'quickly' ),
    //         'before_widget' => '<aside id="%1$s" style=" width: 500; padding-left: 900px; class="widget %2$s">',
    //         'after_widget' => '</aside>',
    //         'before_title' => '<h3 class="widget-title">',
    //         'after_title' => '</h3>'
    //     )
    // );

		register_sidebar(
        array(
            'id' => 'unique-sidebar-post_title',//--- used in dynamic_side bar ---//
            'name' => __( 'Post Title Sidebar' ),//--- used in get_sidebar---//
            'description' => __( 'sidebar for recent post title', 'quickly' ),
            'before_widget' => '<div style=" width: 500; padding-left: 750px;" class="pgs"><ul>',
            'after_widget' => '</ul></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );

    /* Repeat register_sidebar() code for additional sidebars. */
}
add_action( 'widgets_init', 'textdomain_register_sidebars' );
//-------------------------------------------------------------------------//
// short code : display book which based on price and page query //

function sc_price($params)
{
	//echo "hello world";
	//print_r($params);

	//_page_metabox_id
	//_price_metabox_id

	// $args = array(
	// 	'meta_key'     => 'price_metabox_id',
 //    	'meta_value'   => $params['bookprice'],
 //    	'meta_compare' => '=',
 //    	'post_type'    => 'books');

	$args = array(
    	'post_type' => 'books',
    	'meta_query' => array(
    			'relation' => 'AND',
    			array(
    					'key' => '_page_metabox_id',
    					'value' => $params['bookpage'],
    					'compare' => '='
    				),
    			array(
    					'key' => '_price_metabox_id',
    					'value' => $params['bookprice'],
    					'compare' => '='
    				)
    		)

    	);

	$wpb_all_query = new WP_Query($args);
	$str = "";
	if ($wpb_all_query->have_posts())
	{
		//$str = "match found";
		while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
			//echo the_title();
		?>
			<center>
				<h1><?php echo the_title(); ?></ h1>
				<?php

					if(has_post_thumbnail())
    				{
    					echo get_the_post_thumbnail( null, $size = 'post-thumbnail', $attr = ''  );
    				}
    				else
    				{
    					//echo "No Thumbnail";
    					?>
    						<img src="<?php echo get_template_directory_uri() ?>/assets/images/book-image.png" alt="<?php the_title(); ?>" />
    					<?php

    				}
				?>
				<P><?php echo get_the_excerpt();  ?></P>


			</center>

		<?php
		endwhile;
	}
	else
	{
		$str = "No match found";
	}
	wp_reset_query();

	return $str;
}
add_shortcode("price-criteria","sc_price");

//-----------------------------------------------------------------------//

//---- recent post short-code -------------//

function recent_post_function()
{
	$args = array('orderby'=>'date','order'=>'desc','showposts'=>1);
	query_posts($args);
	if(have_posts())
	{
		//echo "There are posts";
		while (have_posts()) : the_post();
			$return_string = get_the_excerpt();
			$return_string .= '<a href="'.get_permalink().'">'.get_the_title().'</a><br/>';
		endwhile;
	}
	// else
	// {
	// 	echo "No post available";
	// }
	wp_reset_query();
	return $return_string;
}

add_shortcode("recent-posts","recent_post_function");
//----------------------------------------------------//
//----------------- short-code demo -----------------------//
add_shortcode('lorem', 'lorem_function');
function lorem_function()
{
  echo 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec nulla vitae lacus mattis volutpat eu at sapien. Nunc interdum congue libero, quis laoreet elit sagittis ut. Pellentesque lacus erat, dictum condimentum pharetra vel, malesuada volutpat risus.';
}

add_shortcode('regi_form','regi_form_func');
function regi_form_func()
{
	$content = "<h3>Registration Form</h3>";
	$content .= '<form>';
	$content .= '<table>';
	$content .= '<tr>';
	$content .= '<td>';
	$content .= 'Name :';
	$content .= '</td>';
	$content .= '<td>';
	$content .= '<input type="text" name="txt_name" id="txt_name" />';
	$content .= '</td>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td>';
	$content .= 'Email :';
	$content .= '</td>';
	$content .= '<td>';
	$content .= '<input type="text" name="txt_eml" id="txt_eml" />';
	$content .= '</td>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td>';
	$content .= 'Mobile :';
	$content .= '</td>';
	$content .= '<td>';
	$content .= '<input type="text" name="txt_mbl" id="txt_mbl" />';
	$content .= '</td>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td>';
	$content .= 'Gender :';
	$content .= '</td>';
	$content .= '<td>';
	$content .= 'Female : <input type="radio" name="gender" id="rd_f" value="Female"/></td><td>';
	$content .= 'Male : <input type="radio" name="gender" id="rd_m" value="Male" />';
	$content .= '</td>';
	$content .= '</tr>';
	$content .= '<tr>';
	$content .= '<td>';
	$content .= '<input type="button" value="Submit" name="btn_submit" id="btn_submit" />';
	$content .= '</td>';
	$content .= '</tr>';
	$content .= '</table>';
	$content .= '</form>';

	$content .= '<p name="usr_data" id="usr_data" ></p><br/>';
?>
	<script type="text/javascript">

		jQuery(document).ready(function(){
    		jQuery("#btn_submit").click(function()
    		{
    			// debugger;
       //  		alert("hello");

        		var name = jQuery("#txt_name").val();
        		var eml = jQuery("#txt_eml").val();
        		var mbl = jQuery("#txt_mbl").val();
        		var gen = "";
        		if(jQuery("#rd_m").is(":checked"))
        		{
        			gen = "Male";
        		}
        		else
        		{
        			gen = "Female";
        		}


        		jQuery("#usr_data").html( name + " : " + eml + " : " + mbl + " : " + gen);

    		});
		});

	</script>
<?php
	return $content;
}

//--------------------------------------------------------------//
//--- add meta box ------------------------------//
add_action('add_meta_boxes','add_price_metabox');
function add_price_metabox()
{
    add_meta_box('price_metabox_id','Price metabox','price_metabox_callback','books','side','default');
}

function price_metabox_callback()
{
		$post_id = get_the_ID();
		$arr = get_post_meta($post_id,'_price_metabox_id', true );

    ?>
    <label for="price_metabox_id">Enter Price Of Book</label>
   <input type="text" name="price_metabox_id" value="<?php echo $arr;?>" id="price_metabox_id" />
   <?php
}
//----------------------------------------------------------------------//
//----- save data entered in meta box --------------------//

add_action('save_post','save_price_metabox');
function save_price_metabox($post_id)
{
    // if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

   if( isset( $_POST['price_metabox_id'] ) )
       update_post_meta( $post_id, '_price_metabox_id', $_POST['price_metabox_id'] );
}

//-----------------------------------------------------------//

//--------- save value - page metabox --------------------------//

add_action('save_post','save_page_metabox');
function save_page_metabox($post_id)
{
	if(isset($_POST['page_metabox_id']))
	{
		update_post_meta($post_id,'_page_metabox_id', $_POST['page_metabox_id']);
	}
}

//------------------ add page metabox ----------------------------//
add_action('add_meta_boxes','add_page_metabox');
function add_page_metabox()
{
	add_meta_box('page_metabox_id','Page metabox','page_metabox_callback','books','side','default');
}
function page_metabox_callback()
{

	$post_id = get_the_ID();
	$arr = get_post_meta($post_id,'_page_metabox_id', true );

	?>
		<label for='page_metabox_id'>Page metabox</label>
		<input type="text" name="page_metabox_id" value="<?php echo $arr; ?>" id="page_metabox_id" />
	<?php
}
//----------------------------------------------------------------//



 ?>
