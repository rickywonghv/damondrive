<?php
session_start();
if(isset($_SESSION['status'])){
  if($_SESSION['status']!="logined"){
    header("Location:login.php?act=nologin");
  }
}
if(empty($_SESSION['username'])){
  header("Location:login.php?act=nologin");
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Damon Drive</title>
    <!--link rel="stylesheet" href="css/bootstrap-theme.min.css" media="screen" title="no title" charset="utf-8"-->
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <!--Top Nav Bar-->
    <div class="hidden-md hidden-lg hidden-xlg">

    </div>
    <!--End Top Nav Bar-->

    <!--Main Content-->
    <div class='ind'>
      <div class="indheader"><i class="fa fa-hdd-o"></i> Damon Drive</div>
      <div class="hidden-md hidden-lg">
        <ul class="nav nav-pills">
          <li role="presentation" class="topmenuitem"><a class="topmenuitem" href="#files-tab" data-toggle="tab"><i class="fa fa-file-o"></i> Files</a></li>
          <li role="presentation" class="topmenuitem"><a class="topmenuitem" href="#upload-tab" data-toggle="tab" ><i class="fa fa-cloud-upload"></i> Upload</a></li>
          <li role="presentation" class="topmenuitem"><a class="topmenuitem" href="#admin-tab" data-toggle="tab">Admin</a></li>
          <li role="presentation" class="topmenuitem"><a class="topmenuitem" data-toggle="modal" data-target="#chpwdmodal">Change Password</a></li>
          <li role="presentation" class="topmenuitem"><a class="topmenuitem" href="" onclick="logout();"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-3 hidden-xs hidden-sm">
          <ul class="nav nav-pills nav-stacked">
            <li><h4>Your Account</h4></li>
            <li>Username: <?php echo $_SESSION['username']; ?></li>
            <li><button type='button' class='btn btn-success' data-toggle="modal" data-target="#chpwdmodal">Change Password</button> <button type='button' class='btn btn-warning' data-toggle="modal" data-target="#newdirmodal"><i class="fa fa-folder"></i> Create Directory</button></li>
          </ul>
          <hr></hr>
          <ul class="nav nav-pills nav-stacked">
            <li onclick="lisrdir(0); listfile(0);"><a href="#files-tab" data-toggle="tab"><i class="fa fa-file-o"></i> Files</a></li>
            <li><a href="#upload-tab" data-toggle="tab" ><i class="fa fa-cloud-upload"></i> Upload</a></li>
            <li><hr></hr></li>
            <li><a href="#admin-tab" data-toggle="tab">Admin</a></li>
            <li><a href="" onclick="logout();"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </div>

        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane active" id="files-tab">
                <div class="tabheader"> Files <button type='button' class='btn btn-warning pull-right hidden-md hidden-lg' data-toggle="modal" data-target="#newdirmodal"><i class="fa fa-folder"></i> Create Directory</button></div>
                  <button type='button' class='btn btn-danger' id="backdir"><i class="fa fa-arrow-left"></i></button>

                <div class="tabconn">
                  <div class="col-xs-12">
                    <div id="dirlist" data-parentdir="">

                    </div>
                  </div>

                  <div id="filelist" class="col-xs-12">
                    <div class="">
                      <span id="showpath">/</span>
                    </div>

                    <div class=''>
                      <ul class="list-group" id="filelistall">

                      </ul>
                    </div>
                  </div>
                </div>
            </div>

            <div class="tab-pane" id="upload-tab">
                <div class="tabheader"> Upload</div>
                <div id="upload" class="tabconn">
                  <form id="uploadform"  method="post" enctype="multipart/form-data">
                    <input type="hidden" id="uploadparentdir" name="parentdirupload" value="">
                    <input type="file" id="uploadfiles" class="form-control" name="files" value="">
                    <button type='submit' class='form-control btn-flat btn btn-info' id="uploadbtn"><i class="fa fa-upload"></i> Upload</button>
                  </form>
                  <div class="upload-result">
                    <div class="upload-progress" id="">
                      <div class="upload-bar"></div>
                      <div class="upload-percent">0%</div>
                    </div>
                    <div class="" id="upload-status"></div>
                  </div>
                </div>
            </div>


            <div class="tab-pane" id="admin-tab">
                <div class="tabheader"> Admin</div>
                <div id="" class="tabconn">


                </div>
            </div>

          </div>
        </div>


        <div class="clearfix visible-lg"></div>
      </div>
    </div>
    <!--End Main Content-->

    <div class="modal fade" id="chpwdmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Change Password</h4>
          </div>
          <div class="modal-body">
            <form class="form" method="post" id="chpwdform">
              <div class="input-group chpwdinput">
                <span class="input-group-addon" id="opwdtag"><i class="fa fa-key"></i> Old Password</span>
                <input type="password" class="form-control inputerror" id="opwd" placeholder="Enter Old Password">

              </div>
              <div class="input-group chpwdinput">
                <span class="input-group-addon" id="npwdtag"><i class="fa fa-key"></i> New Password</span>
                <input type="password" class="form-control inputerror" id="npwd" placeholder="Enter New Password">
              </div>

              <div class="input-group chpwdinput">
                <span class="input-group-addon" id="nconpwdtag"><i class="fa fa-key"></i> Confirm New Password</span>
                <input type="password" class="form-control inputerror" id="connpwd" placeholder="Confirm New Password">
              </div>
              <div class="respon">

              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Change</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="newdirmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""><i class="fa fa-folder"></i> Create New Directory</h4>
          </div>
          <div class="modal-body">
            <div class="input-group">
              <span class="input-group-addon">Directory Name</span>
              <input type="text" name="" class="form-control" id="newdirname" value="" placeholder="Enter new directory name">
            </div>
            <div class="dirresult">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type='button' class='btn btn-flat btn-warning' id="dircreatebtn" onclick="">Create</button>
          </div>
        </div>
      </div>
    </div>

<!--Plugins-->
    <script src="js/jquery-2.2.2.min.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery.form.js" charset="utf-8"></script>
    <script src="js/slimScroll/jquery.slimscroll.min.js" charset="utf-8"></script>
    <script src="js/fastclick/fastclick.min.js" charset="utf-8"></script>
<!--Ajax JS-->
    <script src="js/ajax/logout.js" charset="utf-8"></script>
    <script src="js/ajax/upload.js" charset="utf-8"></script>
    <script src="js/ajax/listfile.js" charset="utf-8"></script>
    <script src="js/ajax/chpwd.js" charset="utf-8"></script>
    <script src="js/ajax/del.js" charset="utf-8"></script>
    <script src="js/ajax/directory.js" charset="utf-8"></script>
  </body>
</html>
