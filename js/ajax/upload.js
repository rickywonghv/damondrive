(function() {

var bar = $('.upload-bar');
var percent = $('.upload-percent');
var status = $('#upload-status');

$('#uploadform').ajaxForm({
  beforeSend: function() {
      status.empty();
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
  },
  uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
  //console.log(percentVal, position, total);
  },
  success: function() {
      var percentVal = '100%';
      bar.width(percentVal)
      percent.html(percentVal);
  },
complete: function(xhr) {
  status.html(xhr.responseText);
   lisrdir(0);
   listfile(0);
   window.location="index.php";
}
});

})();
$(document).ready(function() {
  $(".upload-progress").hide();
  $("#uploadbtn").click(function(){
    $(".upload-progress").show();
  })
  $("#uploadfiles").change(function(event) {
    /* Act on the event */
    $("#uploadform").attr("action","models/upload.php");
  });
});
