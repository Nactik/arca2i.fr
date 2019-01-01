<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
?>


    <div id="infoContainerSignup"> 
        <?php 
            $error = valider("error");
            switch($error){
                case 'nomatch': 
                    echo '<div class="alert alert-danger alert-dismissible fade out show">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Oups !</strong> Les mots de passes ne correspondent pas.</div>';
                break;
                case 'missingpwd':
                    echo '<div class="alert alert-danger alert-dismissible fade out show">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Oups !</strong> Veuillez entrer un mot de passe dans le champs correspondant.</div>';
                break;

                case 'missingloging':
                    echo '<div class="alert alert-danger alert-dismissible fade out show">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Oups !</strong> Veuillez entrer un pseudo.</div>';
                break;
                case 'invalidmail' :
                    echo '<div class="alert alert-danger alert-dismissible fade out show">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Oups !</strong> Veuillez entrer une adresse mail valide.</div>';

                break;
                case 'invalidmail':
                    echo '<div class="alert alert-danger alert-dismissible fade out show">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Oups !</strong> Veuillez renseigner une adresse mail.</div>';
                break;
                case '':
                break;
                default :
                        echo '<div class="alert alert-danger alert-dismissible fade out show">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Oups!</strong> Une erreur s\'est produite lors de l\'inscription.</div>';
                break;
            }
        ?>
        <form action="controleur.php" method="POST" id="signup">
            <div class="labelContainer"><label for="t1" class="Label"> Email : </label></div>
            <input style="margin-top : 1%;"type="text" name="mail" class="textAreaSignup" placeholder="Entrez votre adresse email !" id="t1">
            <br>
            <div class="labelContainer"><label for="t2" class="Label"> Pseudo : </label></div>
            <input type="text" name="pseudo" class="textAreaSignup" placeholder="Entrez votre pseudo !" id="t2">
            <br>
            <div class="labelContainer"><label for="t3" class="Label"> Mot de passe : </label></div>
            <input type="password" name="mdp1" class="textAreaSignup" placeholder="Entrez votre mot de passe !" id="t3">
            <br>
            <div class="labelContainer"><label for="t4" class="Label"> Confirmation : </label></div>
            <input type="password" name="mdp2" class="textAreaSignup" placeholder="Confirmez votre mot de passe !"id="t4"> 
            <br/>
            <div id='test'><input type="submit" value="Inscription" class="button2" name="action"></div>
        </form>
    </div>

  </body>
</html>