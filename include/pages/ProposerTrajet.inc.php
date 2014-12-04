<h1>Proposer un trajet</h1>
<?php 
if (!empty($_SESSION ['per_login_connecte'])) { 
?>
<div id='propose'>
	<form name='propose_trajet' id='propose_trajet' action='#' method='post'>

		<p>
			Ville de d�part : <select name=ville1 class='champ'>
				<option>Choisissez votre ville de départ</option>
			<?php
		// Listage de toutes les villes
// 		$pdo = new MyPdo ();
// 		$villeManager = new VilleManager ( $pdo );
// 		$villes = $villeManager->getAllVille ();
// 		foreach ( $villes as $ville ) {
// 			?>
				<option value="<?php echo $ville->getNumVille(); ?>"> <?php echo $ville->getVilleNom();?> </option>
				<?php
// 		}
		?>
		</select>

<?php 
} else {
	?>
	<p> Vous devez être connecté pour afficher cette page. </p>
	<?php 
} ?>