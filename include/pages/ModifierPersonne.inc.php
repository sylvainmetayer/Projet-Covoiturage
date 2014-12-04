<h1>Modification personne</h1>

<?php
$pdo = new Mypdo (); //
$personneManager = new PersonneManager ( $pdo );
?>

<?php 
//test des vardump
var_dump($_POST['per_num']);
var_dump($_POST['per_tel']);
?>

<?php 
if (empty ( $_POST ['per_num'] ) && empty ( $_POST ['per_tel'] )) 
{
?>
<form action="#" method="POST">
	Personne à modifier : <select name="per_num" id="per_num">
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
} else if (empty ( $_POST ['per_tel'] )) 
{
	$personne = $personneManager->getPersonneParId ( $_POST ['per_num'] );
	var_dump($personne);
	$_SESSION ['per_num'] = $_POST ['per_num'];
	?>
	<form action="#" method="POST">
			Nom : <input name='per_nom' id='per_nom' type='text' value="<?php echo $personne->per_nom;?>" required /> 
			<br /> 
			Prenom : <input name='per_prenom' id='per_prenom' type='text' value='<?php echo $personne->per_prenom; ?>' required /> 
			<br />
			Téléphone : <input name='per_tel' id='per_tel' type='text' value='<?php echo $personne->per_tel; ?>' required/> 
			<br /> 
			Mail : <input name='per_mail' id='per_mail' type='text' value='<?php echo $personne->per_mail; ?>' required/> 
			<br /> 
			Login : <input name='per_login' id='per_login' type='text' value='<?php echo $personne->per_login; ?>' required/> 
			<br /> 
			Mot de passe actuel : <input name='per_mdp' id='per_mdp' type='password' value='' required/>
			<br />
			<!-- On saisie deux fois afin d'être sur que la saisie du nouveau mot de passe est correcte --> 
			Nouveau mot de passe : <input name='per_nouveau' id='per_nouveau' type='password' value='' required />
			<br /> 
			Retaper mot de passe : <input name='per_confirmation' id='per_confirmation' type='password' value='' required/>
			<br />
			<input type='submit' value='Modifier' />
	</form>
<?php
} else 
{
	// TODO Gestion des mots de passe
	$personne = $personneManager->getPersonneParId ( $_SESSION ['per_num'] );
	$nouvPersonne = new Personne ( $_POST );
	$nouvPersonne->setPerNum ( $_SESSION ['per_num'] );
	$nouvPersonne->setPerPwd ( $personne->per_pwd );
	
	if (! empty ( $_POST ['per_mdp'] )) 
	{
		// Il a voulu changer de mdp
		$mdp = $_POST ['per_mdp'];
		$nouv1 = $_POST ['per_nouveau'];
		$nouv2 = $_POST ['per_confirmation'];
		
		if (sha1 ( sha1 ( $mdp ) . SEL ) == $personne->getPerPwd()) 
		{
			if ($nouv1 == $nouv2)
			{
				// Alors tout est bon
				$nouvMdp = sha1 ( sha1 ( $nouv1 ) . SEL );
				$nouvPersonne->setPwd ( $nouvMdp );
				
				$personneManager->updatePersonne ( $nouvPersonne );
				afficherValide ( "Personne mise à jour" );
			} else 
			{
				afficherErreur ( "Les mots de passes ne correspondent pas" );
			}
		} else 
		{
			afficherErreur ( "Mot de passe incorrect." );
		}
	}
}
?>