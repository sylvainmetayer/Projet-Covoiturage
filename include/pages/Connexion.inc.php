<h1>Pour vous connecter</h1>

<?php
$pdo = new Mypdo ();
$personneManager = new PersonneManager ( $pdo );

$nb1 = rand ( 1, 9 );
$nb2 = rand ( 1, 9 );

if (empty ( $_POST ['reponse'] )) {
	?>

<form action="#" method="post">
	Login : <input type="text" name="per_login" id="per_login"> <br /> Mot
	de passe : <input type="password" name="per_pwd" id="per_pwd"> <br />

	<p class="captcha">
		Merci de résoudre le calcul suivant pour confirmer que vous n'êtes pas
		un robot <br /> <img src="image/nb/<?php echo $nb1 ?>.jpg" /> + <img
			src="image/nb/<?php echo $nb2 ?>.jpg" /> =
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
	
	// var_dump($connexionOK);
	// var_dump($login);
	// var_dump($reponse);
	
	if ($reponse != $resultat) { // si le captcha est incorrect
		echo "Le captcha est incorrect";
		?>
<a href="index.php?page=11">Reessayer ? </a>
<?php
	}
	
	if ($connexionOK == false) { // mauvais mot de passe/identifiant
		echo "Erreur d'identifiant / mot de passe";
		?>
<a href="index.php?page=11">Reessayer ? </a>
<?php
	}
	
	if (($connexionOK == $resultat) && ($connexionOK == true)) { // le captcha est bon et les id/mdp aussi
		$_SESSION ['per_login_connecte'] = $_POST ['per_login'];
		$personneConnectee = $personneManager->getPersonneParLogin ( $_SESSION ['per_login'] );
		$_SESSION ["per_num_connecte"] = ($personneConnectee->getPerNum ());
		$_SESSION ["per_prenom_connecte"] = ($personneConnectee->getPrenomPersonne ());
		
		var_dump ( $personneConnectee );
		echo "<p>Bienvenue " . $personneConnectee->getPrenomPersonne () . " !</p>";
		/*
		 * Au final, on dispose de 3 variable de sessions : 1 pour les conditions si on est connecte :
		 * per_login_connecte
		 * et deux autres, qui contiennent le numero et le prenom de la personne connnecte
		 */
	}
}
?>