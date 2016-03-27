$(document).ready(function() {
  $("#chpwdform").submit(function(event){
    chpwd();
    return false;
  })
});
function chpwd(){
  var opwd=$("#opwd").val();
  var opwdtag=$("#opwdtag");

  var npwd=$("#npwd").val();
  var npwdtag=$("#npwdtag");

  var cnpwd=$("#connpwd").val();
  var conpwdtag=$("#nconpwdtag");

  var res=$(".respon");
  var errtag="color:#a94442; background:#f2dede";
  var tag="style";

  var err1="Please enter old password!";
  var err2="Please enter new password!";
  var err3="Please confirm new password!";
  var err4="Password are not match!";

  var danger="<div class='alert alert-danger'>";
  var end="</div>";

  var data="opwd="+opwd+"&npwd="+npwd+"&cnpwd="+cnpwd+"&act=chpwd";

  opwdtag.attr(tag,"");
  npwdtag.attr(tag,"");
  conpwdtag.attr(tag,"");

  if(opwd==""){
    res.html(danger+err1+end);
    opwdtag.attr(tag,errtag);
    return false;
  }else if(npwd==""){
    res.html(danger+err2+end);
    npwdtag.attr(tag,errtag);
    return false;
  }else if(cnpwd==""){
    res.html(danger+err3+end);
    conpwdtag.attr(tag,errtag);
    return false;
  }else if(npwd!=cnpwd){
    res.html(danger+err4+end);
    return false;
  }else{
    $.ajax({
      url:"models/chpwd.php",
      data:data,
      type:'post',
      success:function(response){
        res.html(response);

      }
    }); //end ajax
  }//end else

}//end function
