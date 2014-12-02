<h1>Modification personne</h1>

<?php
$pdo=new Mypdo();
$personneManager=new PersonneManager($pdo);

if(empty($_POST['per_num']) && empty($_POST['per_tel']))
{
?>
<form action="#" method="POST">
		Personne à modifier :
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
		Nom :
		<input name='per_nom' id='per_nom' type='text' value='<?php echo $personne->getNomPersonne(); ?>'/>
		<br />
		Prenom :
		<input name='per_prenom' id='per_prenom' type='text' value='<?php echo $personne->getPrenomPersonne(); ?>'/>
		<br />
		Téléphone :
		<input name='per_tel' id='per_tel' type='text' value='<?php echo $personne->getPerTel(); ?>'/>
		<br />
		Mail :
		<input name='per_mail' id='per_mail' type='text' value='<?php echo $personne->getPerMail(); ?>'/>
		<br />
		Login :
		<input name='per_login' id='per_login' type='text' value='<?php echo $personne->getLogin(); ?>'/>
		<br />
		Mot de passe actuel :
		<input name='per_mdp' id='per_mdp' type='password' value=''/>
		<br />
		Nouveau mot de passe :
		<input name='per_nouv' id='per_nouv' type='password' value=''/>
		<br />
		Retaper mot de passe :
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