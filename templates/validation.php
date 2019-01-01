<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
?>


        <div id="validation">
            <?php  
                $state = valider('state');
                switch($state){
                    case 'toConfirm':
                        $mail = valider('mail');
                        $pseudo = valider('pseudo');
                        $decryptedmail = urldecode($mail);
                        $decryptedpseudo = urldecode($decryptedpseudo);
                        echo " <h2> Bonjour $decryptedpseudo </h2>, <br> Un mail à l'adresse : $decryptedmail, a été envoyé afin de valider ton compte.";

                    break;
                    case 'success':
                        echo " <h2> Bravo, </h2> </br> Ton compte a bien été confirmé, tu peux desormais te connecté. ";
                    break;
                    case 'alreadyConfirm':
                        echo " <h2> Mince, </h2> </br> Il semble que ton compte ait déjâ été confirmer.";
                    break;
                    case 'oups':
                        echo " <h2> Oups, </h2></br> Une erreur est survenue, veuillez réessayer !";
                    break;
                }
            ?>
        </div>
    </body>
</html>