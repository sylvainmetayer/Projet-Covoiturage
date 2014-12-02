<h1>Supprimer des personnes enregistrées</h1>
<?php
$pdo = new Mypdo ();
$personneManager = new PersonneManager ( $pdo );

if (empty ( $_POST ['per_num'] )) 
{
?>
<form action="#" method="POST">
	Personne à supprimer :
	<select name="per_num" id="per_num">
	<?php
	$listePersonnes = $personneManager->getAllPersonnes ();
	foreach ( $listePersonnes as $personne ) 
	{
	?>
		<option value="<?php echo $personne->getPerNum(); ?>"><?php echo $personne->getNomPersonne()." ".$personne->getPrenomPersonne(); ?></option>
		<?php
	}
	?>
	</select> <input type='submit' value='Supprimer' />
</form>
<?php
} else {
	$personneManager->supprimerPersonne ( $_POST ['per_num'] );
	?><img src='../../image/valid.png' alt='ok'/> <p> Personne supprimée </p>";
	
	<?php
}
?>
