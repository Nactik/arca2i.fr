<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* PARTIE 1 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");


function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès
	$SQL="SELECT id FROM users WHERE pseudo='$login' AND mdp='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}


function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT admin FROM users WHERE id='$idUser'";
	return SQLGetChamp($SQL); 
}

/********* PARTIE 2 *********/

function mkUser($pseudo,$passe,$mail,$token)
{
	// Cette fonction crée un nouvel utilisateur et renvoie l'identifiant de l'utilisateur créé
	$SQL = "INSERT INTO users(pseudo,mail,mdp,tokenToConfirm) VALUES ('$pseudo','$mail','$passe','$token')";
	return SQLInsert($SQL);
}


function changerPasse($idUser,$passe)
{
	// cette fonction modifie le mot de passe d'un utilisateur
}

function changerPseudo($idUser,$pseudo)
{
	// cette fonction modifie le pseudo d'un utilisateur
}
function validerMail($mail){
	return preg_match(" /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $mail);
}

function createRandomToken($length=20){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for($i=0; $i<$length; $i++){
        $string .= $chars[rand(0, strlen($chars)-1)];
    }
	return $string;
}
function isConfirmed($pseudo,$mdp){
	$SQL ="SELECT confirmed FROM users WHERE pseudo='$pseudo' AND mdp='$mdp'";
	return SQLGetChamp($SQL); 
}
function confirmUser($id,$token){
	$SQL = "UPDATE users SET confirmed=1 WHERE id='$id' AND tokenToConfirm='$token'";
	echo "$SQL";
	return SQLUpdate($SQL);
}

function getHighScore($id,$game,$difficulty){
	$SQL = "SELECT highscore FROM score WHERE id='$id' AND id_game ='$game' AND id_difficulty='$difficulty'";
	return SQLGetChamp($SQL);
}

function setHighScore($id,$game,$difficulty,$score){
	$SQL = "INSERT INTO score VALUES ('$id','$game','$difficulty','$score')";
	return SQLInsert($SQL);
}

function updateHighScore($id,$game,$difficulty,$score){
	$SQL = "UPDATE score SET highscore='$score' WHERE id='$id' AND id_game='$game' AND id_difficulty='$difficulty'";
	return SQLUpdate($SQL);
}
function listerHighScores($game,$difficulty = "EAS"){
	// liste les 5 joueurs ayant les meilleures scores
	$SQL="SELECT pseudo, highscore FROM users INNER JOIN score ON users.id = score.id WHERE id_game='$game' AND id_difficulty='$difficulty' ORDER BY highscore DESC LIMIT 5" ;
	return parcoursRs(SQLSelect($SQL));
}
function listerHighScoresDem(){
	$SQL="SELECT pseudo, nom_difficulty, highscore FROM score INNER JOIN users ON users.id = score.id INNER JOIN difficulty ON score.id_difficulty = difficulty.id_difficulty WHERE id_game='3' ORDER BY nom_difficulty,highscore ASC LIMIT 15"  ;
	return parcoursRs(SQLSelect($SQL));
}
function envoyerMail($pseudo,$passe,$mail,$token){
	$maildest = $mail; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $maildest)) // On filtre les serveurs qui rencontrent des vabogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	$encryptpseudo = urlencode($pseudo);
	$encryptmail = urlencode($mail);
	$encryptoken = urlencode($token);
	$encryptpasse = urlencode($passe);
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = "Salut à toi $pseudo ! Ton compte a bien été créé, cependant il faut le valider en cliquant sur ce lien : .";
	$message_html = "<html><head></head><body><b>Salut à toi $pseudo</b>, <br/> Ton compte a bien été créé, cependant, il faut le valider en cliquant sur ce lien : <a href=\"arca2i.fr/controleur.php?action=Confirmer&pseudo=$encryptpseudo&passe=$encryptpasse&mail=$encryptmail&token=$encryptoken\">validation</a>.</body></html>";
	//==========
	
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	
	//=====Définition du sujet.
	$sujet = "Arca2i | Validation du compte";
	//=========
	
	//=====Création du header de l'e-mail.
	$header = "From: \"Arca2i\"<arca2i-mail@gmail.com>".$passage_ligne;
	$header.= "Reply-to: \"$pseudo\" <$maildest>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	
	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========
	
	//=====Envoi de l'e-mail.
	mail($maildest,$sujet,$message,$header);
	//==========

}

function envoyerMailTest($mail){
	$maildest = $mail; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $maildest)) // On filtre les serveurs qui rencontrent des vabogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}

	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = "Bonjour Mesdames, Messieurs,
 
	Je représente un groupe d'étudiants de Centrale Lille (formation IG2I) qui, dans le cadre de leur formation, doivent réaliser un projet Informatique pour une entreprise, un particulier ou une association. Ce projet doit porter sur la conception web (principalement) ou logiciel en télétravail. Je viens donc vers vous pour vous proposez nos services ! 

	Nous sommes une équipe de quatre personnes, nommée \"Code name : Emilia\", possédant une bonne maitrise des technologies suivantes :

	- Front-end : HTML / CSS / JS & Stack Web (Bootstrap / Foundation Zurb)
	- Back-end : PHP / SQL / J2EE + Base en NodeJS
	- Développement logiciel
	- VCS (Git)
	- Base en développement Android

	Cependant, nous pourrons nous adapter à votre Stack (Angular JS, Vue) et à votre workflow (Docker ...). 
	Nous restons à votre entière disponibilité pour tout complément d'information.

	Cordialement,
	Nathan Capiaux || Chargé de Communication de Code name : Emilia.";
	$message_html = "Bonjour Mesdames, Messieurs,
	<br>
	<br>
	Je représente un groupe d'étudiants de Centrale Lille (formation IG2I) qui, dans le cadre de leur formation, doivent réaliser un projet Informatique pour une entreprise, un particulier ou une association. Ce projet doit porter sur la conception web (principalement) ou logiciel en télétravail. Je viens donc vers vous pour vous proposez nos services ! 
	<br>
	<br>
	Nous sommes une équipe de quatre personnes, nommée \"Code name : Emilia\", possédant une bonne maitrise des technologies suivantes :
	<br>
	<br>
	- Front-end : HTML / CSS / JS & Stack Web (Bootstrap / Foundation Zurb) <br>
	- Back-end : PHP / SQL / J2EE + Base en NodeJS <br>
	- Développement logiciel <br>
	- VCS (Git) <br>
	- Base en développement Android <br> <br>

	Cependant, nous pourrons nous adapter à votre Stack (Angular JS, Vue) et à votre workflow (Docker ...). 
	Nous restons à votre entière disponibilité pour tout complément d'information.
	<br><br>
	Cordialement, <br>
	Nathan Capiaux || Chargé de Communication de Code name : Emilia.";
	//==========
	
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	
	//=====Définition du sujet.
	$sujet = "Projet Informatique || Centrale Lille IG2I";
	//=========
	
	//=====Création du header de l'e-mail.
	$header = "From: \"Capiaux Nathan\"<nathan.capiaux@ig2i.centralelille.fr>".$passage_ligne;
	$header.= "Reply-to: <$maildest>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	
	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========
	
	//=====Envoi de l'e-mail.
	mail($maildest,$sujet,$message,$header);
	//==========
}
?>