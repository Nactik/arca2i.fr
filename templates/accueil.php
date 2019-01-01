<?php

  //C'est la propriété php_self qui nous l'indique : 
  // Quand on vient de index : 
  // [PHP_SELF] => /chatISIG/index.php 
  // Quand on vient directement par le répertoire templates
  // [PHP_SELF] => /chatISIG/templates/accueil.php

  // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
  // Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
  if (basename($_SERVER["PHP_SELF"]) != "index.php")
  {
    header("Location:../index.php?view=accueil");
    die("");
  }

  $error = valider("error");
  switch($error){
      case 'nomatch': 
          echo '<div class="alert alert-danger alert-dismissible fade out show">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Erreur !</strong> Pseudo ou Mot de passe incorrect(s).</div>';
      break;
      case 'notConfirmed':
          echo '<div class="alert alert-danger alert-dismissible fade out show">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Attention !</strong> Veuillez confirmez votre compte grâce au lien envoyé à votre adresse email afin de vous connecter.</div>';
      break;

      case 'notConnected':
          echo '<div class="alert alert-danger alert-dismissible fade out show">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Attention !</strong> Veuillez vous connecter afin d\'enregistrer un score.</div>';
      break;
      case '':
      break;
      default :
              echo '<div class="alert alert-danger alert-dismissible fade out show">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Oups!</strong> Une erreur s\'est produite lors de l\'enregistrement des scores.</div>';
      break;
  }
?>



   <div id="main">
      <a class="game" href="index.php?view=snake"><h1 class="align">Snake</h1></a>
      <a class="game" href="index.php?view=space"><h1 class="align">Space Invaders</h1></a>
      <a class="game" href="index.php?view=demineur"><h1 class="align">Démineur</h1></a>
    </div>
    
    
    
  </body>
</html>

