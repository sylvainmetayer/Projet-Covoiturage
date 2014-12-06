<h1>Rechercher un trajet</h1>
<?php
if (! empty ( $_SESSION ['per_login_connecte'] ) && empty ( $_POST ['vil_num1'] ) && empty ( $_POST ['vil_num2'] )) {
	// Personne connectée.
	?>
<form name='recherche_trajet' id='recherche_trajet' action='#'
	method='post'>

	<p>
		<label for='vil_num1'>Ville de d&eacute;part :</label> <select
			name='vil_num1' class='champ'>
		<?php
	// Listage de tous les départs
	$pdo = new MyPdo ();
	$proposeManager = new ProposeManager ( $pdo );
	$departs = $proposeManager->getAllDeparts ();
	foreach ( $departs as $depart ) {
		?>
			<option value="<?php echo $depart->getNumVille(); ?>"> <?php echo $depart->getVilleNom();?> </option>
			<?php
	}
	?>
	</select><br /> <input type="submit" value="Suivant" />

</form>
<?php
} else if (! empty ( $_SESSION ['per_login_connecte'] ) && ! empty ( $_POST ['vil_num1'] ) && empty ( $_POST ['vil_num2'] )) {
	
	$pdo = new MyPdo ();
	$villeManager = new VilleManager ( $pdo );
	$villeDepart = $villeManager->getVilleParId ( $_POST ["vil_num1"] );
	?>
<form name='ajouter_trajet' id='ajouter_trajet' action='#' method='post'>
	<p>
		<label for='vil_num1'>Ville de d&eacute;part : </label><?php echo $villeDepart->getVilleNom(); ?> 
	<label for='vil_num2'>Ville de d'arriv&eacute;e :</label> <select
			name='vil_num2' class='champ'>
	<?php
	// Listage de toutes les villes
	$proposeManager = new ProposeManager ( $pdo );
	$depart = $_POST ['vil_num1'];
	$arrives = $proposeManager->getAllArrive ( $depart );
	var_dump ( $arrives );
	foreach ( $arrives as $arrive ) {
		?>
				<option value="<?php echo $arrive->getNumVille(); ?>"> <?php echo $arrive->getVilleNom();?> </option>
				<?php
	}
	?>
		</select><br /> <label for='pro_date'>Date de d&eacute;part : </label><input
			type="text" pattern='[0-3][0-9]-[0-1][0-9]-[0-9]{4}' name="pro_date"
			id="pro_date" value="<?php echo date("d-m-Y"); ?>" /> <label
			for='pro_precision'> Précision : </label> <select
			name="pro_precision" class='champ'>
			<option value="0">Ce jour</option>
			<option value="1">+/- 1 jour</option>
			<option value="2">+/- 2 jours</option>
			<option value="3">+/- 3 jours</option>
		</select><br /> <label for='pro_time'> A partir de : </label><input
			type="text" pattern='[0-2][0-9]:[0-5][0-9]' name="pro_time"
			id="pro_time" value="<?php echo date("H:i"); ?>" /> <input
			type="hidden" name="vil_num1"
			value=" <?php echo $villeDepart->getVilleNom(); ?> " /> <br /> <input
			type="submit" value="Suivant" />

</form>
<?php
} else if (! empty ( $_SESSION ['per_login_connecte'] ) && ! empty ( $_POST ['vil_num2'] ) && ! empty ( $_POST ['vil_num1'] )) {
	
	$pdo = new MyPdo ();
	$proposeManager = new ProposeManager ( $pdo );
	$parcoursManager = new ParcoursManager ( $pdo );
	$villeManager = new VilleManager ( $pdo );
	$personneManager = new PersonneManager ( $pdo );
	$vil_num1 = $_POST ['vil_num1'];
	$vil_num2 = $_POST ['vil_num2'];
	$date = $_POST ['pro_date'];
	$precision = $_POST ['pro_precision'];
	$heure = $_POST ['pro_time'];
	$trajet = $proposeManager->getDetailsTrajet ( $vil_num1, $vil_num2, $date, $precision, $heure );
	
	if ($trajet != null) {
		?>
<center>
	<table border='solid'>
		<tr>
			<th>Ville d&eacute;part</th>
			<th>Ville arriv&eacute;e</th>
			<th>Date d&eacute;part</th>
			<th>Heure d&eacute;part</th>
			<th>Nombre de place(s)</th>
			<th>Nom du covoitureur</th>
		</tr>
		<tr>
			<td><?php echo $villeManager->getVilleParId($parcoursManager->getParcoursParId($trajet->getParNum())->getVil_num1())->getVilleNom()  ; ?></td>
			<td><?php echo $villeManager->getVilleParId($parcoursManager->getParcoursParId($trajet->getParNum())->getVil_num2())->getVilleNom(); ?></td>
			<td><?php echo $trajet->getDate(); ?></td>
			<td><?php echo $trajet->getTime(); ?></td>
			<td><?php echo $trajet->getPlace(); ?></td>
			<td><?php echo $personneManager->getPersonneParId($trajet->getPerNum())->getNomPersonne(); ?></td>
		</tr>
	</table>
</center>
<?php
	} else {
		?><p>
	Désolé, pas de trajet disponible ! <br /> <strong><a
		href='index.php?page=9'>Proposer un trajet ?</a></strong>
</p><?php
	}
} else {
	?>
<p>Vous devez être connecté pour afficher cette page.</p>
<?php
}
?>
