<?php
session_start();
if(isset($_SESSION['status'])){
  if($_SESSION['status']=="logined"&&!empty($_SESSION['username'])){
    header("Location:index.php");
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Damon Drive | Login</title>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div class='container'>
      <div class="login">
        <form class="" id="login-form" method="post">
          <div class="login-heading"> <i class="fa fa-hdd-o"></i> Damon Drive Login</div>
          <input type='text' class='form-control input logininput' id="loginusername" placeholder='Username'>
          <input type='password' class='form-control input logininput' id="loginpwd" placeholder='Password'>
          <button type='submit' class='btn btn-block loginbtn'>Login</button>
          <div class="loginmsg">
            <?php
              if(isset($_GET['act'])){
                if($_GET['act']=="nologin"){
                  echo "<div class='alert alert-warning'>Please login first! </div>";
                }
              }
             ?>
          </div>
        </form>
      </div>
    </div>
    <script src="js/jquery-2.2.2.min.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/ajax/login.js" charset="utf-8"></script>
  </body>
</html>
