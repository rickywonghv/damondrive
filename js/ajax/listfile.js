$(document).ready(function() {
  listfile(0);
});
function listfile(dirid){
  //alert(dirid);
  $.ajax({
    url:"models/list.php",
    data:'folder='+dirid,
    success:function(response){
      $("#filelistall").html(response);
      parentdir(dirid);
    }
  })
}
