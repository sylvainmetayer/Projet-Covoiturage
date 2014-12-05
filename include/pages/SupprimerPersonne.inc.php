<h1>Supprimer des personnes enregistr&eacute;es</h1>
<?php
$pdo = new Mypdo ();
$personneManager = new PersonneManager ( $pdo );

if (empty ( $_POST ['per_num'] )) {
	?>
<form action="#" method="POST">
	Personne &agrave; supprimer : <select name="per_num" id="per_num">
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
	
	$personneManager->supprimerPersonne ( $_POST ['per_num'] );
	if (!empty($_SESSION ['per_login_connecte'])) {
		//une personne est connectée. 
		if ( ($_SESSION ["per_num_connecte"] == $_POST ['per_num'])) {
			//Alors, la personne supprimée est la personne connectée. 
			session_destroy();
			//on quitte la session.
		}
	}
	// TOOD img a afficher
	?>
<img src='../../image/valid.png' alt='OK' />
<p>Personne supprim&eacute;e</p>
<?php
}
?>
