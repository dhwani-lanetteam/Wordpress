jQuery(document).ready(function($){
  // $( "#btn_submit" ).click(function() {
  //   //alert( "Handler for .click() called." );
  //   //insert_data();
  // });
});

function insert_data()
{
  //alert("hello");
  var fnm = jQuery('#txt_fnm').val();
  var lnm = jQuery('#txt_lnm').val();
  var eml = jQuery('#txt_eml').val();
  var mbl = jQuery('#txt_mbl').val();
  var msg = jQuery('#txt_msg').val();
  //alert(txtfname);

  var request = $.ajax({
  url: "",
  method: "POST",
  data: {
    action : 'insert_data',
    firstName : fnm,
    lastName : lnm,
    email : eml,
    mobile : mbl,
    message : msg
  },
  dataType: "html"
});

request.done(function( msg ) {
  alert("success");
});

request.fail(function( jqXHR, textStatus ) {
  alert( "Request failed: " + textStatus );
});


}
