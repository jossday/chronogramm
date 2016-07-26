<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ChronoGramm</title>
    <meta name="description" content="">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1,width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
	   <link rel="shortcut icon" href="https://cdn.knightlab.com/libs/blueline/latest/assets/logos/favicon.ico">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
     <link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
     <link title="timeline-styles" rel="stylesheet" href="css/style.css">
     <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
     <script src="js/jquery.js"></script>
  </head>
  <body>
      <div id="header">
        <div id="title">
          <h1>ChronoGramm</h1>
          <h3>L'actualité d'un coup d'oeil</h3>
        </div>
        <?php
        if((isset($_SESSION['login'])) && ($_SESSION['login'] != '')){
          echo '  <div id="loginZone">
                    <span id="loginName">'.$_SESSION['login'].'</span>
                    <a href="#" id="myAccount" class="loginLink">My Account</a>
                    <a href="#" id="addEvent" class="loginLink">Add a new Event</a>
                    <a href="traitements/logout.php" class="btn btn-danger">Logout</a>
                  </div>';
        }
        else{
          echo '  <div id="loginZone">
                    <a href="#" id="loginLink" class="loginLink">Login</a>
                    <a href="#" id="register" class="loginLink">Register</a>
                  </div>';
        }
        ?>
      </div>

      <form action="" method="post" id="loginForm">
        <div class="form-group">
          <label class="fa fa-user" for="login__username"><span>Login</span></label>
          <input type="text" placeholder="Identifiant" id="login" class="form-control" required/>
        </div>
        <div class="form-group">
          <label class="fa fa-lock" for="login__password"><span>Password</span></label>
          <input type="password" placeholder="Password" id="mdp" class="form-control" required />
          <a href="recuperation.php" id="oubliMdp">Forget ?</a>
        </div>
        <div class="form-group">
          <button type="submit" class="submit btn btn-success" id="btnConnect">Connect</button>
        </div>
      </form>

      <div id='timeline-embed' style="width: 100%; height: 800px"></div>
      <?php
      require('traitements/getEvents.php');
      ?>
      <script type="text/javascript">
        var additionalOptions = {
            start_at_slide: 0,
            debug:true
        }
        var data = $("#data").html();
        console.log(data);
        timeline = new TL.Timeline('timeline-embed',
          'traitements/timeline.json', additionalOptions);

        $("#title").click(function(){
          window.location = "index.php";
        });
        $("#loginLink").click(function(){
          $("#loginForm").fadeIn(700);
        });
        //Connexion
        $("#btnConnect").click(function(){
                var login = $('#login').val();
                var pass = $("#mdp").val();
                $.ajax({
                type: "POST",
                url: "traitements/connect.php",
                data: {login:login, pass:pass}, //your form data to post goes here as a json object
                dataType: "html",
                success: function(msg){
                  console.log($.trim(msg));
                    if($.trim(msg) == 0){
                        $("#result").html("<span class='alert-danger'>Cet identifiant n'existe pas.</span>");
                    }
                    else if($.trim(msg) == 2){
                        $("#result").html("<span class='alert-danger'>Vous avez essayé de vous connecter 3 fois sans succès. Veuillez réessayer plus tard ou contacter le support.</span>");
                    }
                    else if($.trim(msg) == 3){
                        $("#result").html("<span class='alert-danger'>Mot de passe incorrect.</span>");
                    }
                    else if($.trim(msg) == 4){
                        $("#result").html("<span class='alert-danger'>Veuillez remplir tous les champs.</span>");
                    }
                    else{
                      window.location = "index.php";
                    }
                }
            });
        return false;
        });
      </script>
  </body>
</html>
