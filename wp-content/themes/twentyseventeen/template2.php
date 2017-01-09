
<?php
/* 
 * Template Name: template2
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
		include("header.php");
	?>
	
		<!-- <link rel="stylesheet" href="assets/css/mycss.css" type="text/css"> -->
	<H1>Subscription Form</H1>

	<form>
		<ul class="form-style-1">
		    <li><label>Full Name <span class="required">*</span></label><input type="text" name="field1" class="field-divided" placeholder="First" />&nbsp;<input type="text" name="field2" class="field-divided" placeholder="Last" /></li>
		    <li>
		        <label>Email <span class="required">*</span></label>
		        <input type="email" name="field3" class="field-long" />
		    </li>
		    <li>
		        <label>Subject</label>
		        <select name="field4" class="field-select">
		        <option value="Advertise">Advertise</option>
		        <option value="Partnership">Partnership</option>
		        <option value="General Question">General</option>
		        </select>
		    </li>
		    <li>
		        <label>Your Message <span class="required">*</span></label>
		        <textarea name="field5" id="field5" class="field-long field-textarea"></textarea>
		    </li>
		    <li>
		        <input type="submit" value="Submit" />
		    </li>
		</ul>
	</form>
	
	
	<?php
		include("footer.php");
	?>