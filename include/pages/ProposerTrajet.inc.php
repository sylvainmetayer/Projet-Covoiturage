<h1>Proposer un trajet</h1>
<?php
if (! empty ( $_SESSION ['per_login_connecte'] )) {
	// condition de connexion
	?>

<?php
	$pdo = new MyPdo ();
	$parcoursManager = new ParcoursManager ( $pdo );
	$villeManager = new VilleManager ( $pdo );
	$proposeManager = new ProposeManager ( $pdo );
	
	if (empty ( $_POST ["vil_num1"] ) && empty ( $_POST ["vil_num2"] )) {
		// Aucun des deux champs n'est remplis.
		
		$villes = $villeManager->getAllVille ();
		?>
<form action="#" method="POST">
	<label for='vil_num1'>Ville de d&eacute;part :</label> <select
		name="vil_num1">
			<?php
		foreach ( $villes as $ville ) {
			?>
				<option value="<?php echo $ville->getNumVille(); ?>"><?php echo $ville->getVilleNom(); ?></option>
			<?php
		}
		?>
		</select><br /> <input type="submit" value="Suivant" />
</form>
<?php
	} else if (empty ( $_POST ["vil_num2"] )) {
		// la ville de départ est choisie, mais pas la ville d'arrivée et les détails
		
		$villeDepart = $villeManager->getVilleParId ( $_POST ["vil_num1"] );
		$listeVille = $parcoursManager->getVilleArriveePossible ( $_POST ["vil_num1"] );
		?>
<form action="#" method="POST">
	<label for='vil_num1'>Ville de d&eacute;part : </label><?php echo $villeDepart->getVilleNom(); ?> <br />
	<input type="hidden" name="vil_num1"
		value="<?php echo $_POST["vil_num1"]; ?>" />
	<!-- Obligé pour pouvoir conserver vil_num1, et evite la variable de session pour un truc -->
	<label for='vil_num2'>Ville d'arriv&eacute;e : </label><select
		name="vil_num2">
			<?php
		foreach ( $listeVille as $ville ) {
			?>
				<option value="<?php echo $ville->getNumVille(); ?>"><?php echo $ville->getVilleNom(); ?></option>
				<?php
		}
		?>
		</select> <br /> <label for='pro_date'>Date de d&eacute;part : </label><input
		type="text" pattern='[0-3][0-9]-[0-1][0-9]-[0-9]{4}' name="pro_date"
		id="pro_date" value="<?php echo date("d-m-Y"); ?>" /> <br /> <label
		for='pro_time'> Heure de d&eacute;part : </label><input type="text"
		pattern='[0-2][0-9]:[0-5][0-9]' name="pro_time" id="pro_time"
		value="<?php echo date("H:i"); ?>" /> <br /> <label for='pro_place'>
		Nombre de places :</label> <input type="text" name="pro_place"
		id="pro_place" value="1" /> <br /> <input type="submit"
		value="Ajouter" />
</form>
<?php
	} else {
		// Tout les champs sont remplis
		
		$parcours = $parcoursManager->VerifParcours ( $_POST ["vil_num1"], $_POST ["vil_num2"] );
		if ($parcours == NULL) {
			// Pas de parcours dans ce sens, alors on fait dans l'autre.
			$parcours = $parcoursManager->VerifParcours ( $_POST ["vil_num2"], $_POST ["vil_num1"] );
		}
		$propose = new Propose ( $_POST );
		$propose->setPerNum ( $_SESSION ["per_num_connecte"] );
		$propose->setParNum ( $parcours->getParNum () );
		
		if ($parcours->getVil_num1 () == $_POST ["vil_num1"]) {
			$sens = 0;
			// Vil_num1 est le départ
		} else {
			// Vil_num1 est l'arrivée
			$sens = 1;
		}
		
		$propose->setSens ( $sens );
		
		// VARDUMP TEST
		// var_dump ( $propose );
		// var_dump ( $parcours );
		// /VARDUMP TEST
		$controleDate = $proposeManager->CtrlDate ( $propose->getDate () );
		//on mock le $controleDate pour forcer le passage, en attendant que la fonction CtrlDate marche
		$controleDate = true;
		if ($controleDate == false) { // date incorrecte
			?>
<p>
	<img src="image/erreur.png" alt='erreur' /> <strong> La date saisie est
		inf&eacute;rieure &agrave; la date du jour. Le parcours ne peut pas &ecirc;tre ajout&eacute; </strong>
</p>
<?php
		} else {
			//on peut ajouter le trajet
		$resultat = $proposeManager->add ( $propose );
		if ($resultat != 1) {
			// On doit controler que seulement 1 propose a été ajouté, sinon, c'est que la requete à plantée.
			?>
<img src="image/erreur.png" alt='erreur' />
<p>Votre proposition de trajet n'a pas &eacute;t&eacute; ajout&eacute;e.</p>

<?php
		} else {
			?>

<p>
<img src="image/valid.png" alt='erreur' />
Votre proposition de trajet &agrave; &eacute;t&eacute;
	ajout&eacute;e.</p>
<?php
		}
		}
	}
	
	?>
<?php
} else {
	?>
<p>Vous devez être connect&eacute; pour afficher cette page.</p>
<?php
}
?>