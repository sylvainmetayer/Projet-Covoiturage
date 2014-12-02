<h1>Modification personne</h1>

<?php
$pdo=new Mypdo();
$personneManager=new PersonneManager($pdo);

if(empty($_POST['per_num']) && empty($_POST['per_tel']))
{
?>
<form action="#" method="POST">
		<label for='per_num'>Personne à modifier :</label>
			<select name="per_num" id="per_num">
				<?php
				$listePersonnes = $personneManager->getAllPersonnes();
				foreach($listePersonnes as $personne)
				{
					?>
					<option value="<?php echo $personne->getPerNum(); ?>"><?php echo $personne->getNomPersonne()." ".$personne->getPrenomPersonne(); ?></option>
					<?php
				}
				?>
			</select>
			<input type='submit' value='Modifier'/>
</form>
<?php
}
else if(empty($_POST['per_tel']))
{
$personne=$personneManager->getPersonneById($_POST['per_num']);
$_SESSION['per_num']=$_POST['per_num'];
?>
	<form action="#" method="POST">
		<label for='per_nom'>Nom :</label>
		<input name='per_nom' id='per_nom' type='text' value='<?php echo $personne->getNom(); ?>'/>
		<br />
		<label for='per_prenom'>Prenom :</label>
		<input name='per_prenom' id='per_prenom' type='text' value='<?php echo $personne->getPrenom(); ?>'/>
		<br />
		<label for='per_tel'>Téléphone :</label>
		<input name='per_tel' id='per_tel' type='text' value='<?php echo $personne->getTel(); ?>'/>
		<br />
		<label for='per_mail'>Mail :</label>
		<input name='per_mail' id='per_mail' type='text' value='<?php echo $personne->getMail(); ?>'/>
		<br />
		<label for='per_login'>Login :</label>
		<input name='per_login' id='per_login' type='text' value='<?php echo $personne->getLogin(); ?>'/>
		<br />
		<label for='per_mdp'>Mot de passe actuel :</label>
		<input name='per_mdp' id='per_mdp' type='password' value=''/>
		<br />
		<label for='per_nouv'>Nouveau mot de passe :</label>
		<input name='per_nouv' id='per_nouv' type='password' value=''/>
		<br />
		<label for='per_retaper'>Retaper mot de passe :</label>
		<input name='per_retaper' id='per_retaper' type='password' value=''/>
		<br />
		<input type='submit' value='Modifier'/>
</form>
<?php
}
else {
	$personne=$personneManager->getPersonneById($_SESSION['per_num']);	
	$nouvPersonne=new Personne($_POST);
	$nouvPersonne->setNum($_SESSION['per_num']);
	$nouvPersonne->setPwd($personne->getPwd());
	
	if (!empty($_POST['per_mdp'])) {
		// Il a voulu changer de mdp
		$mdp = $_POST['per_mdp'];
		$nouv1 = $_POST['per_nouv'];
		$nouv2 = $_POST['per_retaper'];
		
		if (sha1( sha1( $mdp) . SEL) == $personne->getPwd()) {
			if ($nouv1 == $nouv2) {
				// Alors tout est bon
				$nouvMdp = sha1( sha1 ($nouv1) . SEL);
				$nouvPersonne->setPwd($nouvMdp);
				
				$personneManager->updatePersonne($nouvPersonne);
				afficherValide("Personne mise à jour");
			}
			else {
				afficherErreur("Les mots de passes ne correspondent pas");
			}
		}
		else {
			afficherErreur("Mot de passe incorrect.");
		}
	}
	
}
?>