<?php
$pdo = new Mypdo ();
$personneManager = new PersonneManager ( $pdo );

$nb1 = rand ( 1, 9 );
$nb2 = rand ( 1, 9 );
// choix aléatoires des deux nombres pour le captcha

if (empty ( $_POST ['reponse'] )) {
	?>
<h1>Pour vous connecter</h1>

<form action="#" method="post">
	<label for=per_login'>Login : </label><input type="text"
		name="per_login" id="per_login"> <br /> <label for='per_pwd'>Mot de
		passe : </label><input type="password" name="per_pwd" id="per_pwd"> <br />

	<p class="captcha">
		Merci de r&eacute;soudre le calcul suivant pour confirmer que vous
		n'&ecirc;tes pas un robot <br /> <img
			src="image/nb/<?php echo $nb1 ?>.jpg" alt='numero' /> + <img
			src="image/nb/<?php echo $nb2 ?>.jpg" alt='numero' /> =
	</p>

	<input type="hidden" name="nb1" value="<?php echo $nb1; ?>" /> <input
		type="hidden" name="nb2" value="<?php echo $nb2; ?>" /> <br /> <input
		type="text" name="reponse" /> <br /> <input type="submit"
		value="Connexion" />
</form>
<?php
} else {
	
	$nb1_verif = $_POST ['nb1'];
	$nb2_verif = $_POST ['nb2'];
	$resultat = $nb1_verif + $nb2_verif; // resultat attendu.
	
	$reponse = $_POST ['reponse']; // réponse utilisateur
	
	$login = $_POST ['per_login'];
	$pass = $_POST ['per_pwd'];
	// détails de la connexion
	
	$connexionOK = $personneManager->testConnexion ( $login, $pass );
	
	if ($reponse != $resultat) { // si le captcha est incorrect
		echo "<img src=\"image/erreur.png\" alt='erreur' /> Le captcha est incorrect<br/>\n";
		$captcha = false;
		?>
<br />
<strong><a href="index.php?page=11">Reessayer ? </a>
		
<?php
		session_destroy ();
		// pour eviter des erreurs.
	} else {
		$captcha = true;
		// le captcha est correct
	}
	
	if ($connexionOK == false) { // mauvais mot de passe/identifiant
		echo "<img src=\"image/erreur.png\" alt='erreur' /> Erreur d'identifiant / mot de passe <br/>\n";
		?> <strong><a href="index.php?page=11">Reessayer ? </a> <?php
		session_destroy ();
		// pour eviter des erreurs.
		?>
<?php
	}
	
	if (($connexionOK == $resultat) && ($connexionOK == true) && $captcha == true) { // le captcha est bon et les id/mdp aussi
		$_SESSION ['per_login_connecte'] = $_POST ['per_login'];
		$personneConnectee = $personneManager->getPersonneParLogin ( $_SESSION ['per_login_connecte'] );
		$_SESSION ["per_num_connecte"] = ($personneConnectee->getPerNum ());
		$_SESSION ["per_prenom_connecte"] = ($personneConnectee->getPrenomPersonne ());
		// var_dump ( $personneConnectee );
		// echo "<script type='text/javascript'>document.location.replace('./index.php');</script>";
		?>
		<h3> Bienvenue <?php echo $_SESSION ["per_prenom_connecte"] ?> ! Vous serez redirig&eacute; dans 3 secondes...</h3>
		<META HTTP-EQUIV="Refresh" CONTENT="3;URL=index.php">
		<?php
		/*
		 * Au final, on dispose de 3 variable de sessions : 1 pour les conditions si on est connecte :
		 * per_login_connecte
		 * et deux autres, qui contiennent le numero et le prenom de la personne connnecte
		 */
	}
}
?>