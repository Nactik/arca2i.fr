<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
?>


<form action="controleur.php" method="GET">
    <input type="text" placeholder="Entrez une adresse mail" name="maildest"> 
    <textarea name="contenue_mail"></textarea>

    <input type="submit" name="action" value="envoyer"/>
</form>