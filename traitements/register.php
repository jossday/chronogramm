<?php
require('config.php');
if((isset($_POST['login'])) && ($_POST['login'] != '') && (isset($_POST['pass']))
&& ($_POST['pass'] != '') && (isset($_POST['confirm'])) && ($_POST['confirm'] != '') && (isset($_POST['email']))
&& ($_POST['email'] != '') && (isset($_POST['birth'])) && ($_POST['birth'] != '')){
  $login = htmlentities(addslashes($_POST['login']));
  $pass = htmlentities(addslashes($_POST['pass']));
  $confirm = htmlentities(addslashes($_POST['confirm']));
  $email = htmlentities(addslashes($_POST['email']));
  $birth = htmlentities(addslashes($_POST['birth']));

  if(ctype_digit($pass) || ctype_alpha($pass) || (strlen($pass) < 8)){
    echo 3;
  }
  else{
    if($pass == $confirm){
      $pass = password_hash($pass, PASSWORD_DEFAULT);
      $req = $bdd->prepare("SELECT * FROM users WHERE user='".$login."'");
      $req->execute();
      $req->setFetchMode(PDO::FETCH_OBJ);
      $res = $req->fetchAll();
      if(count($res)!=0){
        echo 2;
      }
      else{
        $req = $bdd->prepare("INSERT INTO users VALUES ('', '$login', '$pass', '$email', '$birth', '', '')");
        $req->execute();
        $data = $req->fetchAll();
      }
    }
    else{
      echo 4;
    }
  }

}












?>
