<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arca2i</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleDemineur.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" integrity="sha384-p2jx59pefphTFIpeqCcISO9MdVfIm4pNnsL08A6v5vaQc4owkQqxMV8kg4Yvhaw/" crossorigin="anonymous">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    
		<!-- Minesweeper's script-->
		<script src="js/scriptDemineur.js" charset="utf-8"></script>

    <!-- Snake's script-->
    <!--<script src="js/snake.js" charset="utf-8"></script>-->


    <link href="favicon.ico" rel="shortcut icon">

    <link href="css/all.css" rel="stylesheet" type="text/css" />
    
    <?php 



    ?>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function(){
        
        $('#switch').click(function(){
          $('#main_nav').toggleClass('appear');
        });

        $('#connect').click(function(){
          $('#login_page').addClass('appear');
          $('body').addClass("overflow");
        });

        $(document).on('click', function(e){
          var $this = $(e.target);
          if( $this[0].id == "login_page"){
              $('#login_page').removeClass('appear');
              $('body').removeClass("overflow");
          }
        });

        $('.game').css("height", $('.game').width());
        $(window).resize(function(){
          $('.game').css("height", $('.game').width());
        });

        $("#t1").keypress(function(){
          var content = $("#t1").val();
          if (content.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
            $('#t1').css("border", "1px solid");
            $('#t1').css("border-color", "#00FF00");
          }
          else{
            $('#t1').css("border", "1px solid");
            $('#t1').css("border-color", "#FF0000");
          } 
        });
      });
    </script>
  </head>


  <body onload="init()">
    <div id="login_page" >
      <div id="infoContainer">
        <h2>Se Connecter</h2>
        <form action="controleur.php" method="POST" id="login">
          <input type="text" placeholder="Pseudo" class="textAreaLogin" name="login">
          <input type="password" placeholder="Mot de passe" class="textAreaLogin" name="mdp">
          <h4><a href="index.php?view=inscription">S'inscrire ?</a></h4>
          <input type="submit" value="Connexion" name="action" class="button">
        </form>
      </div>
    </div>

    <nav id="wrap">
      <i class="fas fa-bars" id="switch"></i>
    </nav>
    <nav id="main_nav">
	  	<ul>
		  	<?php
			//TODO: Si l'utilisateur n'est pas connecte, on affiche un lien de connexion
			if (!valider("connecte", "SESSION")) {
        echo '<li id="connect">Se connecter</li>';
			}
			else {
        echo '<a href="#"><li>'.$_SESSION["pseudo"].'</li></a>';
        echo '<a href="index.php?view=highscore"><li>Highscores</li></a>';
        echo '<a href="controleur.php?action=Logout"><li>Se déconnecter</li></a>';
			}
			?>
		</ul>
    </nav>
    <a href="index.php?view=accueil" id="home">Arca 2i</a>
