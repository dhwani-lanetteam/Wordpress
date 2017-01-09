<?php
/*
* Template Name: template_ajax
*/

get_header();

?>

<h1> Ajax Demo </h1>
<form method="post" id="msg_form" action="#">
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
        <input type="hidden" id="hdn_contact_id" value="none" />
        <input type="submit" id="btn_submit" name="btn_submit" value="Submit" />
        <input type="button" id="btn_update" name="btn_update" value="Update" />
    </li>
</ul>
</form>

<h1>Contacts</h1>
<table id="tbl_contact" class="responstable">
<?php
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
?>


</table>

<?php


get_footer();


?>
