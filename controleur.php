<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$addArgs = "";

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($pseudo = valider("login")){
					if ($mdp = valider("mdp"))
					{
						// On verifie l'utilisateur, 
						// et on crée des variables de session si tout est OK
						// Cf. maLibSecurisation
						$protectedPass = sha1($mdp);
						if(isConfirmed($pseudo,$protectedPass)){
							if (verifUser($pseudo,$protectedPass)) {
								// tout s'est bien passé, doit-on se souvenir de la personne ? 
								if (valider("remember")) {
									setcookie("login",$pseudo , time()+60*60*24*30);
									setcookie("mdp",$mdp, time()+60*60*24*30);
									setcookie("remember",true, time()+60*60*24*30);
								} else {
									setcookie("login","", time()-3600);
									setcookie("mdp","", time()-3600);
									setcookie("remember",false, time()-3600);
								}
							}
							else $addArgs = "?view=accueil&error=nomatch";
						}
						else $addArgs = "?view=accueil&error=notConfirmed";
					} 
				} 
				// On redirigera vers la page index automatiquement
			break;
		
			case 'Inscription' : 
				if ($mail = valider("mail")){
					if (validerMail($mail)){
						if ($pseudo = valider("pseudo")){
							if ($passe1 = valider("mdp1")){
								if($passe2 = valider("mdp2")){
									if($passe1 == $passe2){
										$passe = sha1($passe1);
										$token  = createRandomToken();
										mkUser($pseudo,$passe,$mail,$token);
										envoyerMail($pseudo,$passe,$mail,$token);
										$encryptmail = urlencode($mail);
										$encryptpseudo = urlencode($pseudo);
										$addArgs= "?view=validation&state=toConfirm&pseudo='$encryptpseudo'&mail='$encryptmail'";
									}
									else $addArgs = "?view=inscription&error=nomatch";
								}
								else $addArgs = "?view=inscription&error=missingpwd";
							}
							else $addArgs = "?view=inscription&error=missingpwd";
						}
						else $addArgs = "?view=inscription&error=missingloging";
					}
					else $addArgs = "?view=inscription&error=invalidmail";
				}
				else $addArgs = "?view=inscription&error=invalidmail";
			break;

			case 'Logout':
				// traitement métier
				// Suppression des variables de session par session_destroy(); 
				session_destroy();

				// On voudrait réafficher la vue de connexion 
				$addArgs = "?view=accueil";
			break;

			case 'Confirmer':
				if($mail = valider('mail')){
					if($pseudo = valider('pseudo')){
						if($passe = valider('passe')){
							if($token = valider('token')){
								$decryptmail = urldecode($mail);
								$decryptpseudo = urldecode($pseudo);
								$decryptpasse = urldecode($passe);
								$decrypttoken = urldecode($token);
								if(isConfirmed($decryptpseudo,$decryptpasse)){
									$addArgs="?view=validation&state=alreadyConfirm";
								}
								else{
									if($id = verifUserBdd($decryptpseudo,$decryptpasse)){
										if($check  = confirmUser($id,$decrypttoken)){
											$addArgs="?view=validation&state=success";
										}
										else $addArgs="?view=validation&state=oups";
									}
									else $addArgs="?view=validation&state=oups";
								} 
							}
						}
					}
					else $addArgs = "?view=validation&state=oups";
				}
			break;

			case 'upload':
				if(valider("connecte","SESSION")){
					if($score = valider("score")){
						if($game = valider("game")){
							switch($game){
								case "1":
									$gameName = "snake";
								break;
								case "2":
									$gameName = "space";
								break;
								case "3":
									$gameName = "demineur";
								break;

							}
							if($difficulty = valider("difficulty")){
								$id = $_SESSION["id"];
								$currentScore = getHighScore($id,$game,$difficulty);
								if ($currentScore == 0 || $currentScore == NULL){
									setHighScore($id,$game,$difficulty,$score);
									$addArgs = "?view=$gameName";
								}
								else if ($score > $currentScore){
									updateHighScore($id,$game,$difficulty,$score);
									$addArgs = "?view=$gameName";
								}
								else {
									setcookie("highScore", $currentScore, time()+60*60*24*30*10000);
									$addArgs = "?view=$gameName";
								}
							}
							else $addArgs = "?view=accueil&error=oups";
						}
						else $addArgs = "?view=accueil&error=oups";
					}
					else $addArgs = "?view=accueil&error=oups";
				}
				else $addArgs = "?view=accueil&error=notConnected";
			break;

			case "envoyer" :
					if($mail = valider('maildest')){
						envoyerMailTest($mail);
						$addArgs = "?view=mail";
					}
					else {
						$addArgs = "?view=mail&error=oups";
					}
			break;
			
			default : 
				$addArgs = "?view=accueil";
			break;
		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["SERVER_NAME"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $addArgs);

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










