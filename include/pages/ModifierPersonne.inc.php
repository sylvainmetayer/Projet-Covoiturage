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
	Personne � modifier : <select name="per_num" id="per_num">
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
	Nom : <input name='per_nom' id='per_nom' type='text'
		value="<?php echo $personne->getNomPersonne();?>" required /> <br />
	Prenom : <input name='per_prenom' id='per_prenom' type='text'
		value='<?php echo $personne->getPrenomPersonne(); ?>' required /> <br />
	T�l�phone : <input name='per_tel' id='per_tel' type='text'
		value='<?php echo $personne->getPerTel(); ?>' required /> <br /> Mail
	: <input name='per_mail' id='per_mail' type='text'
		value='<?php echo $personne->getPerMail(); ?>' required /> <br />
	Login : <input name='per_login' id='per_login' type='text'
		value='<?php echo $personne->getPerLogin(); ?>' required /> <br /> Mot
	de passe actuel : <input name='per_mdp' id='per_mdp' type='password'
		value='' /> <br />
	<!-- On saisie deux fois afin d'être sur que la personne saississe le bon mdp-->
	Nouveau mot de passe : <input name='per_nouveau' id='per_nouveau'
		type='password' value='' /> <br /> Retaper mot de passe : <input
		name='per_confirmation' id='per_confirmation' type='password' value='' />
	<br /> <input type='submit' value='Modifier' />
</form>
<?php
} else {
	// TODO Gestion des mots de passe
	$personne = $personneManager->getPersonneParId ( $_SESSION ['per_num'] );
	$PersonneModifie = new Personne ( $_POST );
	// permet de recuperer tout les champs
	
	$PersonneModifie->setPerNum ( $_SESSION ['per_num'] );
	$PersonneModifie->setPerPwd ( $personne->setPerPwd ( $_POST ['per_mdp'] ) );
	
	if (! empty ( $_POST ['per_mdp'] )) {
		// Il a voulu changer de mdp
		$mdp = $_POST ['per_mdp'];
		$nouveau_pass_1 = $_POST ['per_nouveau'];
		$nouveau_pass_2 = $_POST ['per_confirmation'];
		
		if (sha1 ( sha1 ( $mdp ) . SEL ) == $personne->getPerPwd ()) {
			//On s'assure que le mot de passe saisi est egal au mot de passe dans la BD
			if ($nouveau_pass_1 == $nouveau_pass_2) {
				// Alors tout est bon
				$nouvMdp = sha1 ( sha1 ( $nouveau_pass_1 ) . SEL );
				$PersonneModifie->setPwd ( $nouvMdp );
				
				$personneManager->updatePersonne ( $PersonneModifie );
				echo "Personne mise � jour";
			} else {
				echo "Les mots de passes ne correspondent pas";
			}
		} else {
			echo "Mot de passe incorrect.";
		}
	}
}
?>