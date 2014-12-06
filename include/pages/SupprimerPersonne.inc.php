<h1>Supprimer des personnes enregistr&eacute;es</h1>
<?php
$pdo = new Mypdo ();
$personneManager = new PersonneManager ( $pdo );
$listePersonnes = $personneManager->getAllPersonnes ();

// var_dump ( $listePersonnes );
if ($listePersonnes == null) { // Pas de personnes enregistrées
	?>
<p>
	D&eacute;sol&eacute;, aucune personne n'est enregistr&eacute;e. <br />
	<strong><a href='index.php?page=1'>Ajouter une personne ?</a></strong>
<?php
} else { // Des personnes sont enregistrées
	
	if (empty ( $_POST ['per_num'] )) {
		?>



<form action="#" method="POST">
	Personne &agrave; supprimer : <select class='champ' name="per_num"
		id="per_num">
	<?php
		
		foreach ( $listePersonnes as $personne ) {
			?>
		<option value="<?php echo $personne->getPerNum(); ?>"><?php echo $personne->getNomPersonne()." ".$personne->getPrenomPersonne(); ?></option>
		<?php
		}
		?>
	</select> <input type='submit' value='Supprimer' />
</form>
<?php
	} else {
		$personneManager->supprimerPersonne ( $_POST ['per_num'] );
		if (! empty ( $_SESSION ['per_login_connecte'] )) {
			// une personne est connectée.
			if (($_SESSION ["per_num_connecte"] == $_POST ['per_num'])) {
				// Alors, la personne supprimée est la personne connectée.
				session_destroy ();
				// on quitte la session.
			}
		}
		// TOOD img a afficher
		?>

<p>
	<img src="image/valid.png" alt='valid' /> Personne supprim&eacute;e
</p>
<?php
	}
}
?>
