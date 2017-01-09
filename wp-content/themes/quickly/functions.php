<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
//------------------- ajax example -------------------------------------------------------------//
add_action( 'wp_ajax_insert_contact_data', 'insert_contact_data' );
add_action( 'wp_ajax_nopriv_insert_contact_data', 'insert_contact_data' );
function insert_contact_data()
{
	echo "Success to ajax call";
	// if ( isset($_REQUEST) ) {
	// 	$Json = array();
	// 		$fnm = $_REQUEST['firstName'];
	// 		$lnm = $_REQUEST['lastName'];
	// 		$mbl = $_REQUEST['mobile'];
	// 		$eml = $_REQUEST['email'];
	// 		$msg = $_REQUEST['message'];
	//
	// 		//echo $fnm."\t".$lnm."\t".$mbl."\t".$eml."\t".$msg;
	//
	// 		if($fnm != "" && $lnm != "" && $mbl != "" && $eml != "" && $msg != "") {
	// 				//echo "All data is set";
	// 				 global $wpdb;
	// 				 $data = array('LastName' => $lnm,
	// 				 'FirstName' => $fnm,
	// 				 'Email' => $eml,
	// 				 'Mobile' => $mbl,
	// 					'Message' => $msg);
	//
	// 				 $wpdb->insert( 'wp_CONTACTS', $data);
	//
	// 				 $Json['status']=true;
	// 				 $Json['message']="Inserted successfully";
	// 				 $Json['id']=$wpdb->insert_id;
	//
	// 				 //echo "Inserted successfully";
	// 		}
	// 		else {
	// 			$Json['message']="Missing Data";
	// 		}
	//
	// } else {
	// 	 $Json['message']= "No data found";
	// }
	// echo json_encode($Json);
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
			<option value="date" <?php  selected( $show_post_by, 'date' ); //if($show_post_by == "date") echo "selected"; ?>>Date</option>
			<option value="title" <?php selected( $show_post_by, 'title' ); //if($show_post_by == "title") echo "selected"; ?>>Title</option>
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
//-------------- Hardbound and Paperbacks ---------------------------//
add_action('add_meta_boxes','add_cover_type_metabox');
function add_cover_type_metabox() {
	add_meta_box('cover_type_metabox_id','Cover type metabox','cover_type_metabox_callback','books','normal','default','high');
}
function cover_type_metabox_callback() {

	$post_id = get_the_ID();
	$type = get_post_meta($post_id,'_cover_type_metabox_id',true);
	?>
	<label for='cover_type_metabox_id'>Cover Type</label><br/>
	<input type="radio" name='cover_type_metabox_id' value="paperback" <?php checked( $type, 'paperback' ); ?> />Paperback
	<br/>
	<input type="radio" name="cover_type_metabox_id" value="hardbound" <?php checked( $type, 'hardbound' ); ?> />Hardbound
	<?php
}

//------------- save cover type ----------------------------//
add_action('save_post','save_cover_type_metabox');
function save_cover_type_metabox($post_id)
{
	if(isset($_POST['cover_type_metabox_id']))
	{
		update_post_meta($post_id,'_cover_type_metabox_id', $_POST['cover_type_metabox_id']);
	}
}


if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) )
{
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	add_theme_support( 'starter-content', array(
		'widgets' => array(
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			'sidebar-2' => array(
				'text_business_info',
			),

			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg',
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		'nav_menus' => array(
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'page_home',
					'page_about',
					'page_blog',
					'page_contact',
				),
			),
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	) );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = 700;

	if ( twentyseventeen_is_frontpage() ) {
		$content_width = 1120;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param $content_width integer
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'after_setup_theme', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

// //--------------------- custom post type --------------------------------//

// add_action( 'init', 'create_post_type' );
// function create_post_type()
// {
//   register_post_type( 'product',
//     array(
//       'labels' => array(
//         'name' => __( 'Products' ),
//         'singular_name' => __( 'Product' )
//       ),
//       'public' => true,
//       'has_archive' => true,
//        'rewrite' => array('slug' => 'products'),

//     )
//   );
// }

// function add_texonomy()
// {
//         register_taxonomy('electronics','product',
//             array(
//                     'label' => __( 'Electronics' ),


//                 ));
//         register_taxonomy('books','product',
//             array(
//                     'label' => __( 'Books' ),

//                 ));
//         register_taxonomy('lifestyle','product',array(
//         			'label' => __('Lifestyle'),

//         	));
// }
// add_action('init','add_texonomy');

// /*
// * Creating a function to create our CPT
// */

function custom_post_type() {

	 // Set UI labels for Custom Post Type
		$labels = array(
		'name'                => _x( 'Books', 'Post Type General Name', 'twentythirteen' ),
		'singular_name'       => _x( 'Book', 'Post Type Singular Name', 'twentythirteen' ),
		'menu_name'           => __( 'Books', 'twentythirteen' ),
		'parent_item_colon'   => __( 'Parent Books', 'twentythirteen' ),
		'all_items'           => __( 'All Books', 'twentythirteen' ),
		'view_item'           => __( 'View Books', 'twentythirteen' ),
		'add_new_item'        => __( 'Add New Books', 'twentythirteen' ),
		'add_new'             => __( 'Add New', 'twentythirteen' ),
		'edit_item'           => __( 'Edit Books', 'twentythirteen' ),
		'update_item'         => __( 'Update Books', 'twentythirteen' ),
		'search_items'        => __( 'Search Books', 'twentythirteen' ),
		'not_found'           => __( 'Not Found', 'twentythirteen' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
		);

		// Set other options for Custom Post Type

		$args = array(
		'label'               => __( 'books', 'twentythirteen' ),
		'description'         => __( 'Book news and reviews', 'twentythirteen' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		// You can associate this CPT with a taxonomy or custom taxonomy.
		'taxonomies'          => array( 'genres' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		);

		// Registering your Custom Post Type
		register_post_type( 'books', $args );

}

// /* Hook into the 'init' action so that the function
// * Containing our post type registration is not
// * unnecessarily executed.
// */

add_action( 'init', 'custom_post_type', 0 );

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_movies_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_movies_taxonomies()
 {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Genres', 'textdomain' ),
		'all_items'         => __( 'All Genres', 'textdomain' ),
		'parent_item'       => __( 'Parent Genre', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
		'edit_item'         => __( 'Edit Genre', 'textdomain' ),
		'update_item'       => __( 'Update Genre', 'textdomain' ),
		'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
		'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
		'menu_name'         => __( 'Genre', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);

	register_taxonomy( 'genre', array( 'books' ), $args );

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Writers', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Writer', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Writers', 'textdomain' ),
		'popular_items'              => __( 'Popular Writers', 'textdomain' ),
		'all_items'                  => __( 'All Writers', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Writer', 'textdomain' ),
		'update_item'                => __( 'Update Writer', 'textdomain' ),
		'add_new_item'               => __( 'Add New Writer', 'textdomain' ),
		'new_item_name'              => __( 'New Writer Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate writers with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove writers', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used writers', 'textdomain' ),
		'not_found'                  => __( 'No writers found.', 'textdomain' ),
		'menu_name'                  => __( 'Writers', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writer' ),
	);

	register_taxonomy( 'writer', 'books', $args );
}

function people_init() {
	// create a new taxonomy
	register_taxonomy(
		'people',
		'post',
		array(
			'label' => __( 'People' ),
			'rewrite' => array( 'slug' => 'person' ),
			'capabilities' => array(
				'assign_terms' => 'edit_guides',
				'edit_terms' => 'publish_guides'
			)
		)
	);
}
add_action( 'init', 'people_init' );
add_action('wp_enqueue_scripts','custom_css');
function custom_css() {
	wp_enqueue_style('myCss',get_template_directory_uri().'/css/mycss.css');
	wp_enqueue_style('myTableCss',get_template_directory_uri().'/css/mytable.css');
	wp_enqueue_script('crud_script',get_template_directory_uri().'/assets/js/crud_script.js');
	// wp_enqueue_style('myCss');
//	wp_enqueue_scripts('jquery','https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');
}

//--- add class to li tag in nav menu ---//
function add_classes_on_li($classes, $item, $args) {
  $classes[] = 'hvr-bounce-to-bottom';
  return $classes;
}
add_filter('nav_menu_css_class','add_classes_on_li',1,3);
