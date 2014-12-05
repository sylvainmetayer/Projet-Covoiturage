<h1>Ajouter une ville</h1>

<?php
if (empty ( $_POST ['choix_ville'] )) {
	?>
<div id='ville'>
	<form name='choix_ville' id='choix_ville' action='#' method='post'>
		<p>
			Nom : <input type='text' placeholder='Ex : Bordeaux'
				name='choix_ville'> <input type='submit' value='Valider'>

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
			a été ajoutée
		</p>
	<?php
	} else {
		?>  
		<p>
			<img src="image/erreur.png" alt='erreur' /> La ville <b><?php echo $_POST['choix_ville'] ?></b>
			n'a pas été ajoutée
		</p>
	<?php 
	}
} 

?>