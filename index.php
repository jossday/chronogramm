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
                    <a href="#" id="registerLink" class="loginLink">Register</a>
                  </div>';
        }
        ?>
      </div>

      <form action="" method="post" id="loginForm">
        <div class="form-group">
          <label class="fa fa-user" for="login__username"><span>Login</span></label>
          <input type="text" placeholder="Login" id="login" class="form-control" required/>
        </div>
        <div class="form-group">
          <label class="fa fa-lock" for="login__password"><span>Password</span></label>
          <input type="password" placeholder="Password" id="mdp" class="form-control" required />
          <a href="recuperation.php" id="oubliMdp">Forget ?</a>
        </div>
        <div class="form-group">
          <button type="submit" class="submit btn btn-success" id="btnConnect">Connect</button>
        </div>
        <div id="resultLogin"></div>
      </form>

      <form action="" method="post" id="registerForm">
        <div class="form-group">
          <label class="fa fa-user" for="register__username"><span>Login</span></label>
          <input type="text" placeholder="Login" id="loginRegister" class="form-control" required/>
        </div>
        <div class="form-group">
          <label class="fa fa-lock" for="register__password"><span>Password</span></label>
          <input type="password" placeholder="Password" id="mdpRegister" class="form-control" required />
        </div>
        <div class="form-group">
          <label class="fa fa-lock" for="register__password__confirmation"><span>Password Confirmation</span></label>
          <input type="password" placeholder="Password Confirmation" id="mdpConfirm" class="form-control" required />
        </div>
        <div class="form-group">
          <label class="fa fa-lock" for="register__email"><span>Email</span></label>
          <input type="email" placeholder="Email" id="email" class="form-control" required />
        </div>
        <div class="form-group">
          <label class="fa fa-lock" for="register__birth"><span>Birth Date</span></label>
          <input type="date" placeholder="Birth Date" id="birth" class="form-control" required />
        </div>
        <div class="form-group">
          <button type="submit" class="submit btn btn-success" id="btnRegister">Register</button>
        </div>
        <div id="resultRegister"></div>
      </form>

      <form id="search" name="search" method="get" action="">
        <input type="text" class="form-control input-lg" name="q" id="q" placeholder="Search an event" />
      </form>

      <div id='timeline-embed' style="width: 100%; height: 800px"></div>
      <?php
      $expireTime = time()-1800; //Expiration fixée à 30 minutes
      $cacheFile = "traitements/timeline.json";
      if(filemtime($cacheFile) < $expireTime){ //Si le cache est expiré on recharge les données
        require('traitements/getEvents.php');
      }
      ?>
      <script type="text/javascript">
        //Initialisation de la timeline
        var additionalOptions = {
            start_at_slide: 0,
            debug:true
        }
        timeline = new TL.Timeline('timeline-embed',
          'traitements/timeline.json', additionalOptions);

        //Lien artificiel du titre vers page d'accueil
        $("#title").click(function(){
          window.location = "index.php";
        });

        //Affichage du formulaire de connexion
        $("#loginLink").click(function(){
          $("#loginForm").fadeIn(700);
          //Overlay noir
          $('body').append('<div id="fade"></div>');
          $('#fade').show();
        });

        //Affichage du formulaire d'inscription
        $('#registerLink').click(function(){
          $("#registerForm").fadeIn(700);
          //Overlay noir
          $('body').append('<div id="fade"></div>');
          $('#fade').show();
        });

        /*$('body').click(function(e){
          var target = $(e.target);
          if ((target.not('#loginLink')) && (target.not('#registerLink'))){
              $("#fade").remove();
              $("#loginForm").hide();
              $("#registerForm").hide();
          }
        });*/
        //Connexion
        $("#btnConnect").click(function(){
                var login = $('#login').val();
                var pass = $("#mdp").val();
                $.ajax({
                type: "POST",
                url: "traitements/connect.php",
                data: {login:login, pass:pass},
                dataType: "html",
                success: function(msg){
                  console.log($.trim(msg));
                    if($.trim(msg) == 0){
                        $("#resultLogin").html("<span class='alert-danger'>Cet identifiant n'existe pas.</span>");
                    }
                    else if($.trim(msg) == 2){
                        $("#resultLogin").html("<span class='alert-danger'>Vous avez essayé de vous connecter 3 fois sans succès. Veuillez réessayer plus tard ou contacter le support.</span>");
                    }
                    else if($.trim(msg) == 3){
                        $("#resultLogin").html("<span class='alert-danger'>Mot de passe incorrect.</span>");
                    }
                    else if($.trim(msg) == 4){
                        $("#resultLogin").html("<span class='alert-danger'>Veuillez remplir tous les champs.</span>");
                    }
                    else{
                      location.reload();
                    }
                }
            });
        return false;
        });
        //Inscription
        $("#btnRegister").click(function(){
          var login = $('#loginRegister').val();
          var pass = $('#mdpRegister').val();
          var confirm = $("#mdpConfirm").val();
          var email = $("#email").val();
          var birth = $("#birth").val();
          $.ajax({
          type: "POST",
          url: "traitements/register.php",
          data: {login:login, pass:pass, confirm:confirm, email:email, birth:birth},
          dataType: "html",
            success: function(msg){
              console.log($.trim(msg));
                if($.trim(msg) == 0){
                    $("#resultRegister").html("<span class='alert-danger'>Please fill all the fields.</span>");
                }
                else if($.trim(msg) == 2){
                    $("#resultRegister").html("<span class='alert-danger'>This login is already in use.</span>");
                }
                else if($.trim(msg) == 3){
                    $("#resultRegister").html("<span class='alert-danger'>Password is not valid.</span>");
                }
                else if($.trim(msg) == 4){
                    $("#resultRegister").html("<span class='alert-danger'>Password and confirmation don't match.</span>");
                }
                else{
                  location.reload();
                  // TODO: Connexion automatique
                }
            }
          });
         return false;
        });
        //Barre de recherche
        $('#q').val('');
        $('#q').keyup( function(){
          $field = $(this);
          $('#ajax-loader').remove();
          $('.user').html("");
          if($field.val().length > 0)
          {
            $.ajax({
            type : 'GET',
            url : 'traitements/ajax-search.php',
            data : 'q='+$(this).val(),
            success : function(data){
              //S'il y a des résultats on affiche la timeline correspondante
              if(data != "No result"){
                $('#ajax-loader').remove();
                timeline = new TL.Timeline('timeline-embed',
                'traitements/search.json', additionalOptions);
              }
              else{
                $('#timeline-embed').html("<div id='no-result'>No result</div>");
              }
            }
            });
            $('#clean').show();
          }
          //On affiche la timeline par défaut
          else{
            timeline = new TL.Timeline('timeline-embed',
              'traitements/timeline.json', additionalOptions);
          }
        });
      </script>
  </body>
</html>
