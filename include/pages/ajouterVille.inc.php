<h1>Ajouter une ville</h1>

<?php
if (empty ( $_POST ['choix_ville'] )) {
	?>
<div id='ville'>
	<form name='choix_ville' id='choix_ville' action='#' method='post'>
		<p>
			<label for='choix_ville'>Nom : </label><input type='text'
				class='champ' placeholder='Ex : Bordeaux' name='choix_ville'> <input
				type='submit' value='Valider'>
		</p>
<?php
} else {
	$var = $_POST ['choix_ville'];
	$pdo = new MyPdo ();
	$ville = new Ville ( array (
			"$var" 
	) );
	$villeManager = new VilleManager ( $pdo );
	
	$retour = $villeManager->add ( $ville );
	if ($retour != 0) // OK
{
		?>  

		<p>
			<img src="image/valid.png" alt='valid' /> La ville <b><?php echo $_POST['choix_ville'] ?></b>
			a &eacute;t&eacute; ajout&eacute;e.
		</p>
	<?php
	} else {
		?>  
		<p>
			<img src="image/erreur.png" alt='erreur' /> La ville <b><?php echo $_POST['choix_ville'] ?></b>
			n'a pas &eacute;t&eacute; ajout&eacute;e, il se peut qu'elle existe
			d&eacute;j&agrave;
		</p>
	<?php
	}
}

?>