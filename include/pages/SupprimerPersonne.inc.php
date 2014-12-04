<h1>Supprimer des personnes enregistrées</h1>
<?php
$pdo = new Mypdo ();
$personneManager = new PersonneManager ( $pdo );

if (empty ( $_POST ['per_num'] )) {
	?>
<form action="#" method="POST">
	Personne à supprimer : <select name="per_num" id="per_num">
	<?php
	$listePersonnes = $personneManager->getAllPersonnes ();
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
	$retour = $personneManager->supprimerPersonne ( $_POST ['per_num'] );
	// TOOD img a afficher
	if ($retour != 0) {
		?>
<img src='../../image/valid.png' alt='OK' />
<p>Personne supprimée</p>
	<?php
	} else {
		?>
<img src='../../image/erreur.png' alt='KO' />
<p>Erreur lors de la suppression de la personne</p>
	<?php
	}
}
?>
