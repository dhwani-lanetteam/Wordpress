<?php
/*
	Plugin Name: Image Tagging
	Description: Full featured contact form
	Author: Trainee_41
	Version: 1.0
*/

add_action( 'wp_ajax_insert_imagetag_data', 'insert_imagetag_data' );
add_action( 'wp_ajax_nopriv_insert_imagetag_data', 'insert_imagetag_data' );

function insert_imagetag_data()
{
  $img_arr = $_FILES['file-0'];
  $tagData = $_REQUEST['tagData'];
  $json_data = json_decode(stripslashes($tagData),true);
  //print_r($json_data);

  $json = array();

  $target_dir = wp_upload_dir()['path'];
  $timeStamp = time();
  $basename = basename($img_arr["name"]);
  $photo_id = $timeStamp.basename($img_arr["name"]);
  $target_file = $target_dir.$timeStamp.basename($img_arr["name"]);

  $target_file = $target_dir.$timeStamp.basename($img_arr["name"]);
  list($img_width, $img_height) = getimagesize($img_arr['tmp_name']);


  if (move_uploaded_file($img_arr['tmp_name'], $target_file))
  {
    //echo "File is valid, and was successfully uploaded.\n";
    $json['imageUploadStatus'] = "1";
    //print_r($json_data);
    foreach ($json_data as $key => $value) {
      $tag_key = $value['tag_key'];
      $tag_value = $value['tag_value'];

      echo "\n------------------------------------\n";

      global $wpdb;
      $data = array(
        'photo_id' => $photo_id,
        'tagged_id' => $tag_key,
        'tagged_name' => $tag_value,
        'height' => $img_height,
        'width' => $img_width
      );
      if($wpdb->insert( 'wp_bp_album_tags', $data) != false) {
          $json['insertQry'][$tag_key] = "1";
      }
      else {
        $json['insertQry'][$tag_key] = "0";
      }

    }
  } else {
     $json['imageUploadStatus'] = "0";
  }

  echo json_encode($json);
  wp_die();
}

register_activation_hook( __FILE__, 'active_image_tagging');

function active_image_tagging()
{
	echo "active_image_tagging";
}


function display_imgUpload_form($params)
{
  wp_register_style( 'IT-css1',plugin_dir_url(__FILE__).'/css/jquery.imagetag.css', array(),'20150510','all' );
  wp_enqueue_style( 'IT-css1' );

  wp_register_style( 'IT-css2',plugin_dir_url(__FILE__).'/css/jquerysctipttop.css', array(),'20150510','all' );
  wp_enqueue_style( 'IT-css2' );

  wp_enqueue_script( 'jquery-image-tag', plugin_dir_url(__FILE__).'/js/jquery-image-tag.js', false );

	?>

  <h4>With customization options</h4>
  <image src='<?php echo plugin_dir_url(__FILE__);?>/images/image1.jpg' id='image2'></image>

  <div style='display:none'>
    <form id='image2form'>
      <label>title</label>
      <input type='text' name='title'> </input>
      <label>Comment</label>
      <input type='textarea' name='comment'> </input>
      <input type='submit' value='Tag'></input>
    </form>
  </div>

  <script>
    jQuery(function($){
      $('#image1').imageTag();
      $('#image2').imageTag({tagForm: $("#image2form"), labelProperty:'title'});
    })
  </script>

	<?php

}

add_shortcode('image-tag','display_imgUpload_form');

?>
