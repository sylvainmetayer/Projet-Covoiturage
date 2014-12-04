<?php 
	session_destroy();
?>
<h1> Vous avez été déconnecté.</h1>
<p>Vous serez redirigé vers la page d'accueil dans 3 secondes</p>
		<?php header('Refresh: 3; ./'); ?>