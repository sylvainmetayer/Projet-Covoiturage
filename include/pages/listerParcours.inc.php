 <?php
	$pdo = new MyPdo ();
	$parcoursManager = new ParcoursManager ( $pdo );
	$parcours = $parcoursManager->getAllParcours ();
	
	$villeManager = new VilleManager ( $pdo );
	?>
<div>
	<h1>Liste des parcours</h1>

	<p>Actuellement, il y a 
	<?php echo count($parcours);?> 
	parcours enregistr&eacute;s
	</p>
</div>
<center>
	<table border='solid'>
		<tr>
			<th>Num&eacute;ro</th>
			<th>Ville de d&eacute;part</th>
			<th>Ville d'arriv&eacute;e</th>
			<th>Nombre de Kilom&egrave;tre</th>
		</tr>
	
<?php
foreach ( $parcours as $single_parcours ) {
	?>
	<tr>
			<td><?php echo $single_parcours->getParNum();?></td>
		<?php
	// var_dump($single_parcours->getVil_num1());
	// var_dump($villeManager->getNomVille($single_parcours->getVil_num1()));
	?>
		<td><?php echo $villeManager->getNomVille($single_parcours->getVil_num1())->getVilleNom();?></td>
			<td><?php echo $villeManager->getNomVille($single_parcours->getVil_num2())->getVilleNom();?></td>
			<td><?php echo $single_parcours->getParKm();?></td>
		</tr>
<?php
}
?>
</table>
	<br />
</center>