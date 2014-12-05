<h1>Modification personne</h1>

<?php
$pdo = new Mypdo (); //
$personneManager = new PersonneManager ( $pdo );
?>

<?php
// test des vardump
// var_dump($_POST['per_num']);
// var_dump($_POST['per_tel']);
?>

<?php
if (empty ( $_POST ['per_num'] ) && empty ( $_POST ['per_tel'] )) {
	?>
<form action="#" method="POST">
	Personne &agrave; modifier : <select class='champ' name="per_num" id="per_num">
				<?php
	$listePersonnes = $personneManager->getAllPersonnes ();
	foreach ( $listePersonnes as $personne ) {
		?>
					<option value="<?php echo $personne->getPerNum(); ?>"><?php echo $personne->getNomPersonne()." ".$personne->getPrenomPersonne(); ?></option>
					<?php
	}
	?>
			</select> <input type='submit' value='Modifier' />
</form>
<?php
} else if (empty ( $_POST ['per_tel'] )) {
	$personne = $personneManager->getPersonneParId ( $_POST ['per_num'] );
	// var_dump($personne);
	$_SESSION ['per_num'] = $_POST ['per_num'];
	?>
<form action="#" method="POST">
	<label for ='per_nom'>Nom :</label> <input name='per_nom' class='champ' id='per_nom' type='text'
		value="<?php echo $personne->getNomPersonne();?>" required />
	<label for='per_prenom'>Prenom : </label><input name='per_prenom' class='champ' id='per_prenom' type='text'
		value='<?php echo $personne->getPrenomPersonne(); ?>' required /> <br />
	<label for='per_tel'>T&eacute;l&eacute;phone : </label><input class='champ' name='per_tel' id='per_tel' type='text'
		value='<?php echo $personne->getPerTel(); ?>' required /> <label for='per_mail'> Mail :</label>
	 <input name='per_mail' class='champ' id='per_mail' type='text'
		value='<?php echo $personne->getPerMail(); ?>' required /> <br />
	<label for='per_login'>Login :</label> <input name='per_login' class='champ' id='per_login' type='text'
		value='<?php echo $personne->getPerLogin(); ?>' required />  <label for='per_mdp'>Mot
	de passe actuel :</label> <input name='per_mdp' class='champ' id='per_mdp' type='password'
		value='' /> <br />
	<!-- On saisie deux fois afin d'être sur que la personne saississe le bon mdp-->
	<label for='per_nouveau'>Nouveau mot de passe : </label><input name='per_nouveau' class='champ' id='per_nouveau'
		type='password' value='' />  <label for='per_confirmation'>Retaper le mot de passe :</label> <input
		name='per_confirmation' class='champ' id='per_confirmation' type='password' value='' />
	<br /> <input type='submit' value='Modifier' />
</form>
<?php
} else {
	$personne = $personneManager->getPersonneParId ( $_SESSION ['per_num'] );
	$PersonneModifie = new Personne ( $_POST );
	// permet de recuperer tout les champs
	
	$PersonneModifie->setPerNum ( $_SESSION ['per_num'] );
	$PersonneModifie->setPerPwd ( $personne->getPerPwd() );
	
	var_dump($PersonneModifie);
	var_dump($personne->getPerPwd());
	
	if (! empty ( $_POST ['per_mdp'] )) {
		// Il a voulu changer de mdp
		$mdp = $_POST ['per_mdp'];
		$nouveau_pass_1 = $_POST ['per_nouveau'];
		$nouveau_pass_2 = $_POST ['per_confirmation'];
		
		
		if (sha1 ( sha1 ( $mdp ) . SEL ) == $PersonneModifie->getPerPwd ()) {
			//On s'assure que le mot de passe saisi est egal au mot de passe dans la BD
			if ($nouveau_pass_1 == $nouveau_pass_2) {
				// Alors tout est bon
				$nouvMdp = sha1 ( sha1 ( $nouveau_pass_1 ) . SEL );
				$PersonneModifie->setPerPwd ( $nouvMdp );
				
				$personneManager->modifierPersonne( $PersonneModifie );
				echo " <img src=\"image/valid.png\" alt='erreur' /> Personne mise à jour";
			} else {
				echo "<img src=\"image/erreur.png\" alt='erreur' /> Les mots de passe saisis ne correspondent pas";
			}
		} else {
			echo "<img src=\"image/erreur.png\" alt='erreur' /> Mot de passe incorrect.";
		}
	}
}
?>