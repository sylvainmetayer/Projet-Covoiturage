<?php
	$pdo = new MyPdo();
	$villeManager = new VilleManager($pdo);
	$villes = $villeManager->getAllVille();
?>
<div>
	<h1>Liste des villes</h1>
	
	<p>Actuellement, il y a 
	<?php echo $villeManager->getNbVille(); ?> 
	villes enregistrées
	</p>
</div>
<center>
<table border='solid' >
	<tr>
		<th>Numero</th> <th>Nom</th> 
	</tr>
	
<?php
	foreach ($villes as $ville)	//$ville est un objet ville 
	{
?>
	<tr>
		<td><?php echo $ville->getNumVille();?></td>
		<td><?php echo $ville->getVilleNom();?></td>
	</tr>
<?php 
	}
?>
</table> <br />
</center>