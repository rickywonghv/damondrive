function logout(){
  $.ajax({
    url:"models/?act=logout",
    dataType:"json",
    success:function(response){
      stat=response.status;
      if(stat=="true"){
          window.location="login.php";
      }

    }
  })
}
