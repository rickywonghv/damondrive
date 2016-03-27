<?php
/**
 * Damon Disk Class
 */
class main {
  private $dbhost="localhost";
  private $dbuser="root";
  private $dbpwd="basa3aTR";
  private $dbname="damon_disk";

  protected function connect(){
    return new mysqli($this->dbhost,$this->dbuser, $this->dbpwd, $this->dbname);
  }

  public function login(){ //login
    session_start();
    $username=$_POST['username'];
    $conn=$this->connect();
    $sql="select * from login where username=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($uid,$reuser,$dbrepwd,$lv);
    $stmt->fetch();
    if($uid==""){
      $arrayName = array('status'=>'Wrong username or password');
      return json_encode($arrayName);
    }else{
      $pwd=hash('sha512',$_POST['pwd']);
      if($pwd==$dbrepwd){
        $_SESSION['username']=$reuser;
        $_SESSION['status']="logined";
        $arrayName = array('status'=>'true');
        return json_encode($arrayName);
      }else{
        $arrayName = array('status'=>'Wrong username or password');
        return json_encode($arrayName);
      }

    }
  }
  //end login

  public function logout(){
    session_start();
    $_SESSION['username']="";
    $_SESSION['status']="logout";
    session_unset();
    session_destroy();
    $arrayName = array('status' =>'true' );
    return json_encode($arrayName);
  }

  public function uploadint($realname,$hash,$parent){
    $size=$_FILES['files']['size'];
    session_start();
    $fileid=rand();
    $dir=$parent;
    $share=0;
    $owner=$_SESSION['username'];
    $conn=$this->connect();
    mysqli_query($conn,"INSERT INTO files (fileid,realname,size,hash,dir,owner,share) VALUES (".$fileid.",'".$realname."',".$size.",'".$hash."',".$dir.",'".$owner."',".$share.")");
    mysqli_close($conn);
  }

  public function listfile(){
    session_start();
    $owner=$_SESSION['username'];
    $parent=$_GET['folder'];
    $conn=$this->connect();
    $sql="select * from files where owner=? and dir=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("si",$owner,$parent);
    $stmt->execute();
    $stmt->bind_result($fileid,$realname,$size,$hash,$dir,$owner,$share);
    $array= array();
      while ($stmt->fetch()) {
        echo "<li class='fileitem col-xs-12 list-group-item'><a href='models/dl.php?fileid=$fileid'><span class='estimatename'>".$realname."</span></a><button class='btn btn-danger pull-right' class='delfilebtn' onclick=del($fileid)>Delete</button></li>";
      }

  }

  public function download(){
    session_start();
    $fileid=$_GET['fileid'];
    $owner=$_SESSION['username'];
    $conn=$this->connect();
    $sql="select realname,size,hash from files where fileid=? and owner=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("is",$fileid,$owner);
    $stmt->execute();
    $stmt->bind_result($realname,$size,$hash);
    $stmt->fetch();
    $arrayName = array('realname'=>$realname , 'size'=>$size,'hash'=>$hash);
    return $arrayName;
  }

  public function delete(){
    session_start();
    $fileid=$_GET['fileid'];
    $owner=$_SESSION['username'];
    $ck=$this->ckowner($owner,$fileid);
    if($ck){
      $conn=$this->connect();
      $sql="select hash from files where fileid=?";
      $stmt=$conn->prepare($sql);
      $stmt->bind_param("i",$fileid);
      $stmt->execute();
      $stmt->bind_result($hash);
      $stmt->fetch();
      if (!unlink("../files/".$hash.".data")){
        echo ("Error deleting $hash");
      }else{
        $conn=$this->connect();
        $sql="delete from files where fileid=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("i",$fileid);
        $stmt->execute();
        echo "Deleted!";
      }
    }else{
      echo "This is not your file.";
    }
  }

  private function ckowner($owner,$fileid){
    $conn=$this->connect();
    $sql="select owner from files where fileid=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$fileid);
    $stmt->execute();
    $stmt->bind_result($reowner);
    $stmt->fetch();
    if($reowner==$_SESSION['username']){
      return true;
    }else{
      return false;
    }
  }

  public function chpwd(){
    $username=$_SESSION['username'];
    $opwd=hash('sha512',$_POST['opwd']);
    $npwd=hash('sha512',$_POST['npwd']);
    $connpwd=hash('sha512',$_POST['cnpwd']);

    if($opwd==""){
      echo "<div class='alert alert-danger'>Error</div>";
    }elseif($npwd==""){
      echo "<div class='alert alert-danger'>Error</div>";
    }elseif($connpwd==""){
      echo "<div class='alert alert-danger'>Error</div>";
    }elseif($npwd!=$connpwd){
      echo "<div class='alert alert-danger'>Error</div>";
    }elseif($npwd==$connpwd){
      $conn=$this->connect();
      $sql="select password from login where username=?";
      $stmt=$conn->prepare($sql);
      $stmt->bind_param("s",$username);
      $stmt->execute();
      $stmt->bind_result($repwd);
      $stmt->fetch();
      if($opwd==$repwd){
        $conn=$this->connect();
        $sql="update login set password=? where username=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("ss",$npwd,$username);
        $stmt->execute();
        echo "<div class='alert alert-success'> Password has been change! </div>";
      }else{
        echo "<div class='alert alert-danger'>Wrong old password</div>";
      }
    }
  }//end chpwd

  public function mkdir(){
    $username=$_SESSION['username'];
    $name=$_POST['dirname'];
    $parent=$_POST['pardir'];
    if($name==""){
      echo "<div class='alert alert-danger'>Error! No name</div>";
    }elseif($name!=""){
      $conn=$this->connect();
      $sql="select name,parent from directory where name=? and owner=?";
      $stmt=$conn->prepare($sql);
      $stmt->bind_param("ss",$name,$username);
      $stmt->execute();
      $stmt->bind_result($foldername,$reparent);
      $stmt->fetch();
      if($reparent==$parent&&$name==$foldername){
          echo "<div class='alert alert-warning'>Directory name used already, please choose another name.</div>";
      }else{
        $dirid=rand();
        $share='0';
        $conn=$this->connect();
        $sql="insert into directory (dirId,parent,owner,name,share) values (?,?,?,?,?)";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("iissi",$dirid,$parent,$username,$name,$share);
        $stmt->execute();
        echo "<div class='alert alert-success'>Directory created.</div>";
      }
    }
  }

  public function listdir(){
    $username=$_SESSION['username'];
    $listdir=$_POST['listdir'];
    if($listdir==""){
      echo "<div class='alert alert-danger'>Error</div>";
    }else{
      $conn=$this->connect();
      $sql="select dirId,name,share,parent from directory where parent=? and owner=?";
      $stmt=$conn->prepare($sql);
      $stmt->bind_param("is",$listdir,$username);
      $stmt->execute();
      $stmt->bind_result($dirId,$name,$share,$parent);
      while($stmt->fetch()){
        echo "<div class='directories col-xs-12 col-sm-4' dir-id='$dirId' data-dirname='$name' data-dirparent='$parent' onclick='listfile($dirId); lisrdir($dirId);'><i class='fa fa-folder-o'></i> $name</div>";
      }

    }
  }

  public function parentdir(){
    $username=$_SESSION['username'];
    $dirid=$_POST['dirid'];
    if($dirid==""){
      echo "<div class='alert alert-danger'>Error</div>";
    }else{
      $conn=$this->connect();
      $sql="select parent from directory where dirId=? and owner=?";
      $stmt=$conn->prepare($sql);
      $stmt->bind_param("is",$dirid,$username);
      $stmt->execute();
      $stmt->bind_result($parent);
      $stmt->fetch();
      echo $parent;


    }
  }

}

 ?>
