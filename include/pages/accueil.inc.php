<?php if (!empty($_SESSION['per_login_connecte'])) { //la personne est connectée ?>
		<h3> Bienvenue <?php echo $_SESSION ["per_prenom_connecte"] ?> !</h3>
				<?php } else { //la personne n'est pas connectée ?>
		<h3> Bienvenue !</h3>
				<?php } ?>
<img class="centreImage" src="image/logo.gif" alt="Covoiturage IUT" title="Covoiturage IUT Limousin" width="38%"/>	