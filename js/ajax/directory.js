$(document).ready(function() {
  lisrdir(0);
  //
  $("body").on('click','.directories',function(){
    var dirname=$(this).data("dirname");
    $("#showpath").html(dirname);
  })
});

function dircreate(parentid){
  var name=$("#newdirname").val();
  var res=$(".dirresult");
  if(name==""){
    res.html("<div class='alert alert-danger'>Please enter name! </div>");
    return false;
  }else{
    $.ajax({
      url:"models/dir.php",
      type:"POST",
      data:"act=newdir&dirname="+name+"&pardir="+parentid,
      success:function(response){
        res.html(response);

        return false;
      }
    })
  }
  return false;
}

function lisrdir(folder){
  //alert(folder);
  var dirlist=$("#dirlist");
  //
  $.ajax({
    url:"models/dir.php",
    type:"POST",
    data:"act=dirlist&listdir="+folder,
    success:function(response){
      dirlist.html(response);
      $("#dircreatebtn").attr("onclick","dircreate("+folder+");");
      $("#uploadparentdir").val(folder);

      //window.location="?folder="+folder;
      return false;
    }
  })

}

function parentdir(dirid){
  //$("#backdir").attr("onclick","lisrdir("+parentdir+"); listfile("+parentdir+"); parentdir("+parentdir+")");

  $.ajax({
    url:"models/dir.php",
    type:"POST",
    data:"act=parentdir&dirid="+dirid,
    success:function(response){
      $("#backdir").attr("onclick","lisrdir("+response+"); listfile("+response+");");
      return false;
    }
  })
  

}
