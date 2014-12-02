<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);
$personnes=$personneManager->getAllPersonnes();
?>
<div><h1>Liste des personnes</h1></div>
<?php echo "Actuellement ".count($personnes)." personnes sont enregistrées\n"; ?>
<br/>
<br/>
<center>
<table border='1'>
<tr><th>Num&eacute;ro</th><th>Nom</th><th>Prenom</th></tr>
	<?php
	foreach($personnes as $personne)
	{
	//lien vers salarié ou etudiant avec le numéro a faire
	?>
		<tr><td><?php echo $personne->getPerNum(); ?> 
		</td><td><?php echo $personne->getNomPersonne(); ?>
		</td><td><?php echo $personne->getPrenomPersonne(); ?>
		</td></tr>
	<?php 
	} 
	?>
</table>
</center>
<br/>