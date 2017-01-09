<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="footer-grids">
				<div class="col-md-3 footer-grid">
					<h3>cumque nihil impedit</h3>
					<div class="footer-grd-left">
						<img src="<?php echo get_template_directory_uri()?>/assets/images/11.jpg" class="img-responsive" alt=" " />
					</div>
					<div class="footer-grd-left">
						<p>Nam libero tempore, cum
							soluta nobis est eligendi optio cumque nihil impedit quo minus
							id quod maxime placeat facere possimus, omnis voluptas assumenda
							est, omnis dolor repellendus</p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-3 footer-grid">
					<h3>voluptas assumenda</h3>
					<ul>
						<li><a href="#">doloribus asperiores</a></li>
						<li><a href="#">Itaque earum rerum</a></li>
						<li><a href="#">deserunt mollitia</a></li>
						<li><a href="#">facilis est et expedita</a></li>
						<li><a href="#">occaecati cupiditate</a></li>
						<li><a href="#">deserunt mollitia laborum</a></li>
					</ul>
				</div>
				<div class="col-md-3 footer-grid">
					<h3>deserunt mollitia</h3>
					<ul>
						<li><a href="#">doloribus asperiores</a></li>
						<li><a href="#">Itaque earum rerum</a></li>
						<li><a href="#">deserunt mollitia</a></li>
						<li><a href="#">facilis est et expedita</a></li>
						<li><a href="#">occaecati cupiditate</a></li>
						<li><a href="#">deserunt mollitia laborum</a></li>
					</ul>
				</div>
				<div class="col-md-3 footer-grid">
					<h3>Flckr Posts</h3>
					<div class="footer-grd">
						<img src="<?php echo get_template_directory_uri()?>/assets/images/7.jpg" class="img-responsive" alt=" " />
					</div>
					<div class="footer-grd">
						<img src="<?php echo get_template_directory_uri()?>/assets/images/8.jpg" class="img-responsive" alt=" " />
					</div>
					<div class="footer-grd">
						<img src="<?php echo get_template_directory_uri()?>/assets/images/9.jpg" class="img-responsive" alt=" " />
					</div>
					<div class="clearfix"> </div>
					<div class="footer-grd">
						<img src="<?php echo get_template_directory_uri()?>/assets/images/10.jpg" class="img-responsive" alt=" " />
					</div>
					<div class="footer-grd">
						<img src="<?php echo get_template_directory_uri()?>/assets/images/7.jpg" class="img-responsive" alt=" " />
					</div>
					<div class="footer-grd">
						<img src="<?php echo get_template_directory_uri()?>/assets/images/8.jpg" class="img-responsive" alt=" " />
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<!-- <div class="container">
			<p>© 2015 Quickly. All rights reserved | Design by <a href="http://w3layouts.com/"> W3layouts</a></p>
		</div> -->
	</div>
<!-- //footer -->
<!-- for bootstrap working -->
		<script src="<?php echo get_template_directory_uri()?>/assets/js/bootstrap.js"> </script>
<!-- //for bootstrap working -->
<?php wp_footer();
//echo admin_url( 'admin-ajax.php' );
?>
<script type="text/javascript">
jQuery(document).ready(function($){

//--- hide update button on page load ---//
 jQuery( "#btn_update" ).hide();

//--- ajax call to insert_contact_data ---//
	jQuery("#msg_form").submit(function(e){
		e.preventDefault();
		//alert(jQuery("#hdn_contact_id").attr("value"));
		insert_contact_data();
	});

//--- ajax call to update_contact_data
	jQuery("#btn_update").click(function(){
			alert("Update btn clicked");
			var id = jQuery("#hdn_contact_id").attr("value");
			alert("Update id : " + id);
			update_contact_data(id);
	});

//--- ajax call on next btn click ---//
	jQuery("#btn_next").click(function (){
			pgntn_get_post(true,jQuery('#hdn_offset').val());

	});

	 jQuery("#btn_prev").click(function() {
			pgntn_get_post(false,jQuery('#hdn_offset').val());
	 });

});

setTimeout(function(){
		jQuery( ".delete-contact" ).click(function(e) {
			alert("Delete clicked");
			e.preventDefault();
			var id = jQuery(this).attr('data-id');
			delete_contact_data(id);
		});
},1000);

setTimeout(function(){
		jQuery( ".update-contact" ).click(function(e) {
			//alert("Update clicked");
			// e.preventDefault();
			// //update_contact_data(id);
			$( "#btn_update" ).show();
			$( "#btn_submit" ).hide();

			//--- get id
			 var id = jQuery(this).attr('data-id');
		  //--- set id to hidden field
			jQuery("#hdn_contact_id").val(id);

			 get_contact_data(id);

		});
},1000);

function insert_contact_data()
{
	//alert("hello");
	var fnm = jQuery('#txt_fnm').val();
	var lnm = jQuery('#txt_lnm').val();
	var eml = jQuery('#txt_eml').val();
	var mbl = jQuery('#txt_mbl').val();
	var msg = jQuery('#txt_msg').val();
	//alert(txtfname);

	var request = $.ajax({
	url: "<?php echo admin_url('admin-ajax.php') ?>",
	type : 'post',
	data: {
		action : "insert_contact_data",
		firstName : fnm,
		lastName : lnm,
		email : eml,
		mobile : mbl,
		message : msg
	}
	//dataType: "html"
	});

	request.done(function( res ) {
		//alert("success");
		var obj = jQuery.parseJSON(res);
		console.log(obj.id);
		console.log(obj.message);
		console.log(obj.status);
		jQuery("#msg_form").trigger('reset');
		jQuery('#tbl_contact tbody').append('<tr><td>'+fnm+'</td><td>'+lnm+'</td><td>'+eml+'</td><td>'+mbl+'</td><td>'+msg+'</td><td><a href="#" class="delete-contact" data-id="'+obj.id+'">Delete</a></td><td><a href="#" class="update-contact" data-id="'+obj.id+'">Update</a></td></tr>')
	//jQuery('#msg_form').reset();
	});

	request.fail(function( jqXHR, textStatus ) {
		alert( "Request failed: " + textStatus );
	});


}

function load_contact_data()
{	//debugger;
	$.ajax({
        url: "<?php echo admin_url('admin-ajax.php') ?>",
				dataType : 'html',
				data: {
					action : "load_contact_data"
				},
        success:function(data) {
            // This outputs the result of the ajax request
            console.log(data);
						jQuery('#tbl_contact').html(data);
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
}

function delete_contact_data(id)
{
	alert(id);
		$.ajax({
				url: "<?php echo admin_url('admin-ajax.php') ?>",
				dataType : 'html',
				data: {
					action : "remove_contact_data",
					contact_id : id
				},
				success:function(data) {
						// This outputs the result of the ajax request
						console.log(data);
						//load_contact_data();
						var obj = jQuery.parseJSON(data);
						if(obj.status == true) {
							jQuery('.delete-contact[data-id="'+id+'"]').parent().parent().remove();
						}
						else {
							alert(obj.message);
						}

				},
				error: function(errorThrown){
						console.log(errorThrown);
				}
		});
}

function get_contact_data(id) {
	//alert(id);
	$.ajax({
			url: "<?php echo admin_url('admin-ajax.php') ?>",
			dataType : 'html',
			data: {
				action : "get_contact_data",
				contact_id : id
			},
			success:function(res) {
					// This outputs the result of the ajax request
					console.log(res);
					var obj = jQuery.parseJSON(res);
					if(obj.status == true)
					{
							//obj.data.firstName);
							jQuery("#txt_fnm").val(obj.data.firstName);
							jQuery("#txt_lnm").val(obj.data.lastName);
							jQuery("#txt_eml").val(obj.data.email);
							jQuery("#txt_mbl").val(obj.data.mobile);
							jQuery("#txt_msg").val(obj.data.message);
					}
			},
			error: function(errorThrown){
					console.log(errorThrown);
			}
	});
}

function update_contact_data(id) {
	//alert("update_contact_data : " + id);
	$.ajax({
			url: "<?php echo admin_url('admin-ajax.php') ?>",
			dataType : 'html',
			data: {
				action : "update_contact_data",
				contact_id : id,
				firstName : jQuery('#txt_fnm').val(),
				lastName : jQuery('#txt_lnm').val(),
				email : jQuery('#txt_eml').val(),
				mobile : jQuery('#txt_mbl').val(),
				message : jQuery('#txt_msg').val()
			},
			success:function(res) {
					// This outputs the result of the ajax request
					console.log(res);
			},
			error: function(errorThrown){
					console.log(errorThrown);
			}
	});

}

function pgntn_get_post(is_next,off_val) {
	debugger;
	console.log("isNext : " + is_next);
	console.log("off_val : " + off_val);
	$.ajax({
			url: "<?php echo admin_url('admin-ajax.php') ?>",
			dataType : 'html',
			data: {
				action : "pgntn_get_post",
				rowOffset : off_val,
				isNext : is_next
			},
			success:function(res) {
					// This outputs the result of the ajax request
					console.log(res);
					var obj = jQuery.parseJSON(res);
					jQuery("#hdn_offset").val(obj.offset);
					if(obj.have_post == true)
					{
						//debugger;
						jQuery("#post_title").html(obj.post_title);
					}

			},
			error: function(errorThrown){
					console.log(errorThrown);
			}
	});
}


</script>
</body>
</html>
