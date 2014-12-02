<?php
/**
 * 
 */
// OK
$pdo = new MyPdo ();
// On instancie tous les manager dont on aura besoin
$PersonneManager = new PersonneManager ( $pdo );
$SalarieManager = new SalarieManager ( $pdo );
$EtudiantManager = new EtudiantManager ( $pdo );
// $_SESSION['Personne']='';
?>	

<?php
// Si l'un des champs est vide, cela veut dire que le formulaire de saisie de la personne n'est pas complet,
// donc on affiche le formulaire de saisie d'une personne
if ((empty ( $_POST ['nom'] )) and empty ( $_SESSION ['Personne'] )) {
	
	?>
<h1>Modifier une personne</h1>

<div id='personne'>
	<form action="#" method="POST">
		<select name="per_num" id="per_num">
				<?php
	$listePersonnes = $personneManager->getAllPersonnes();
	foreach ( $listePersonnes as $personne ) {
		?>
					<option value="<?php echo $personne->getPerNum() ?>"><?php echo $personne->getNomPersonne()." ".$personne->getPrenomPersonne(); ?></option>
					<?php
	}
	?>
		</select> <input type='submit' value='Modifier' />
	</form>
</div>

