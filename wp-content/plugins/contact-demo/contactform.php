<?php
/*
	Plugin Name: Contact Form
	Description: Full featured contact form
	Author: Trainee_41
	Version: 1.0
*/

register_activation_hook( __FILE__, 'active_contact_form');

function active_contact_form()
{
	//echo "pugin activated";
	global $wpdb;
	$table_name = $wpdb->prefix."CONTACTS";
	$qry = "CREATE TABLE IF NOT EXISTS ".$table_name."(ID int NOT NULL AUTO_INCREMENT,LastName varchar(255) NOT NULL,FirstName varchar(255),Email varchar(255),Mobile varchar(255),Message varchar(255),PRIMARY KEY (ID))";
	$wpdb->query($qry);

}


function display_contact_form($params)
{
	if(isset($_POST['btn_submit']))
	{
		//echo "pressed<br/>";
		if(isset($_POST['txt_fnm']) && isset($_POST['txt_lnm']) && isset($_POST['txt_eml']) && isset($_POST['txt_mbl']) && isset($_POST['txt_msg']))
		{
			if($_POST['txt_fnm'] != "" && $_POST['txt_lnm'] != "" && $_POST['txt_eml'] != "" && $_POST['txt_mbl'] != "" && $_POST['txt_msg'] != "") {
				// echo "First name : ".$_POST['txt_fnm'];
				// echo "Last name : ".$_POST['txt_lnm'];
				// echo "Email : ".$_POST['txt_eml'];
				// echo "Mobile : ".$_POST['txt_mbl'];
				// echo "Message : ".$_POST['txt_msg'];
				cf_insert_data($_POST['txt_fnm'],$_POST['txt_lnm'],$_POST['txt_eml'],$_POST['txt_mbl'],$_POST['txt_msg']);
			}
			else {
				echo "Empty Values";
			}


		}
		else
		{
			echo "something missing";
		}
	}
	// else
	// {
	// 	echo "not set";
	// }

	?>
		<h1>Contact Form</h1>
		<form method="post" action="#">
		<ul class="form-style-1">
		    <li>
		    	<label>Full Name <span class="required">*</span></label>
		    	<input type="text" name="txt_fnm" id="txt_fnm" class="field-divided" placeholder="First" />
		    	&nbsp;
		    	<input type="text" name="txt_lnm" id="txt_lnm" class="field-divided" placeholder="Last" />
		    </li>
		    <li>
		        <label>Email <span class="required">*</span></label>
		        <input type="email" name="txt_eml" id="txt_eml" class="field-long" />
		    </li>
		    <li>
		        <label>Mobile <span class="required">*</span></label>
		        <input type="text" name="txt_mbl" id="txt_mbl" class="field-long" />
		    </li>
		    <li>
		        <label>Your Message <span class="required">*</span></label>
		        <textarea name="txt_msg" id="txt_msg" class="field-long field-textarea"></textarea>
		    </li>
		    <li>
		        <input type="submit" id="btn_submit" name="btn_submit" id="btn_submit" value="Submit" />
		    </li>
		</ul>
	</form>

	<h1>Contacts</h1>




<table class="responstable">

  <tr>
    <th data-th="Driver details"><span>First name</span></th>
    <th>Last Name</th>
    <th>Email</th>
		<th>Mobile</th>
		<th>Message</th>
  </tr>
	<?php

		$qry = "SELECT * FROM `wp_CONTACTS`";
		global $wpdb;
		$results = $wpdb->get_results($qry, ARRAY_A);
		// print_r($results);
		foreach($results as $row)
		{
			// print_r($row[]);
			//echo $row["FirstName"]."<br/>";
	?>
  <tr>
    <td><?php echo $row['FirstName']  ?></td>
    <td><?php echo $row['LastName']  ?></td>
    <td><?php echo $row['Email']  ?></td>
    <td><?php echo $row['Mobile']  ?></td>
		  <td><?php echo $row['Message']  ?></td>
  </tr>
<?php
 	}
?>

</table>

	<?php

}

add_shortcode('display-contact-form','display_contact_form');

function cf_insert_data($fnm,$lnm,$eml,$mbl,$msg)
{
		global $wpdb;
		$qry = "INSERT INTO `wp_CONTACTS`(`LastName`, `FirstName`, `Email`, `Mobile`, `Message`) VALUES ('$lnm','$fnm','$eml' , '$mbl','$msg')";
		//echo $qry;
		$wpdb->query($qry);
		//die("Inserted");
}

?>
