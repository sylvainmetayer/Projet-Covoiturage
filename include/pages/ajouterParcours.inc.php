<h1>Ajouter un Parcours</h1>
<?php
if (empty ( $_POST ['ville1'] ) or empty ( $_POST ['ville2'] ) or empty ( $_POST ['nbKm'] )) {
	?>

<div id='parcours'>
	<form name='crea_parcours' id='crea_parcours' action='#' method='post'>

		<p>
			Ville de d&eacute;part : <select name=ville1 class='champ'>
		<?php
	// Listage de toutes les villes
	$pdo = new MyPdo ();
	$villeManager = new VilleManager ( $pdo );
	$villes = $villeManager->getAllVille ();
	foreach ( $villes as $ville ) {
		?>
			<option value="<?php echo $ville->getNumVille(); ?>"> <?php echo $ville->getVilleNom();?> </option>
			<?php
	}
	?>
	</select>
		</p>

		<p>
			Ville d'arriv&eacute;e : <select name=ville2 class='champ'>
		<?php
	// Listage de toutes les villes
	$pdo = new MyPdo ();
	$villeManager = new VilleManager ( $pdo );
	$villes = $villeManager->getAllVille ();
	
	foreach ( $villes as $ville ) {
		?>
			<option value="<?php echo $ville->getNumVille(); ?>"> <?php echo $ville->getVilleNom();?> </option>
			<?php
	}
	?>
	</select>
		</p>

		<p>
			Nombre de Km :<input type='number' step="1" name="nbKm"
				placeholder='Ex : 10' class='champ'>
		</p>

		<p>
			<input type='submit' value='Valider'>
		</p>

<?php
} else {
	$ville1 = $_POST ['ville1'];
	$ville2 = $_POST ['ville2'];
	$nbKm = $_POST ['nbKm'];
	
	$pdo = new MyPdo ();
	$Parcours = new Parcours ( array (
			'par_km' => $nbKm,
			'vil_num1' => $ville1,
			'vil_num2' => $ville2 
	) );
	// var_dump($Parcours);
	$ParcoursManager = new ParcoursManager ( $pdo );
	// var_dump($nbKm);
	$retour = $ParcoursManager->add ( $Parcours );
	// var_dump($retour);
	if ($retour != null) // OK
{
		?>  
		<p>
			<img src="image/valid.png" alt='valid' /> Le parcours a bien
			&eacute;t&eacute; ajout&eacute;
		</p>
	<?php
	} else {
		?>  
		<p>
			<img src="image/erreur.png" alt='erreur' /> Le parcours n'a pas
			&eacute;t&eacute; ajout&eacute;, car il existe d&eacute;j&agrave;.
		</p>
	<?php
	}
}
?>