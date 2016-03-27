function del(fileid){
  //alert(fileid)
  if(fileid==""){
    alert("Error");
  }else if(fileid!=""){
    $.ajax({
      url:"models/del.php?fileid="+fileid,
      success:function(response){
        alert(response);
        window.location="index.php";
      }
    })
  }
}
