$(document).ready(function() {
  $("#login-form").submit(function(event) {
    /* Act on the event */
    login();
    return false;
  });
});

function login(){
  var user=$("#loginusername").val();
  var pwd=$("#loginpwd").val();
  var msg=$(".loginmsg");
  var err1="Please enter Username";
  var err2="Please enter Password";
  var danger="<div class='alert alert-danger'>";

  var end="</div>";

  if(user==""){
    msg.html(danger+err1+end);
    return false;
  }else if(pwd==""){
    msg.html(danger+err2+end);
    return false;
  }else{
    $.ajax({
      url:"models/login.php",
      type:"POST",
      data:"act=login&username="+user+"&pwd="+pwd,
      dataType:"json",
      success:function(response){
        console.log(response);
        stat=response.status
        if(stat=="true"){
          window.location="index.php";
        }else{
          msg.html(danger+stat+end);
          return false;
        }
      }
    })
  }
  return false;
}
