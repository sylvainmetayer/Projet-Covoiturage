<?php
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
if (

(empty ( $_POST ['nom'] )) and ((empty($_POST['tel_pro']) or empty($_POST['choix_departement'])) )  

) {
	
	?>
<h1>Ajouter une personne</h1>

<div id='personne'>
	<form name='ajouter_personne' id='ajouter_personne' action='#'
		method='post'>
		Nom : <input type='text' placeholder='Ex : Michu' name='nom'
			class='champ' required> Prénom : <input type='text'
			placeholder='Ex : Sarah' name='prenom' class='champ' required> <br />
		T�l�phone : <input type='text' placeholder='0xxxxxxxxx' name='tel'
			class='champ' pattern='[0][0-9]{9}' required> Mail : <input
			type='mail' placeholder='sarah.michu@example.fr' name='mail'
			class='champ' required> <br /> Login : <input type='text'
			placeholder='Ex : Sarah87' name='login' class='champ' required> Mot
		de passe : <input type='password' placeholder='********' name='mdp'
			class='champ' required> <br /> Cat�gorie :
		<!-- Par défaut, on met l'etudiant coché afin d'être sur qu'une case soit cochée.-->
		<input type='radio' name='typePersonne' class='champ' value='etudiant'
			checked='checked'> Etudiant </input> <input type='radio'
			name='typePersonne' value='personnel' class='champ'> Personnel </input>
		<br /> <input type='submit' value='Valider'>
	</form>
</div>
<?php
} else if ((!empty ( $_POST ['nom'] )) and (empty($_POST['tel_pro']) or empty($_POST['choix_departement']) )  ) {
	// Dans ce cas, le formulaire de saisie de la personne est rempli.
	
	// Details de la personne stockée dans une variable de session
	$Personne = new Personne ( array (
			'per_nom' => $_POST ['nom'],
			'per_prenom' => $_POST ['prenom'],
			'per_tel' => $_POST ['tel'],
			'per_mail' => $_POST ['mail'],
			'per_login' => $_POST ['login'],
			'per_pwd' => $_POST ['mdp'] 
	) );
	
	$Personne->setPerPwd(sha1 ( sha1 ( $Personne->getPerPwd() ) . SEL ));
	//Grain de sel du mot de passe.
	
	$_SESSION ['Personne'] = $Personne;
	
	
	$_SESSION ['typePersonne'] = $_POST ['typePersonne'];
	// Si la personne est un etudiant ou un salarié, peut-être inutile.
	
	// On affiche une page differente selon le statut de la personne
	// On utilise les $_POST afin de s'assurer que c'est juste la page précédente.
	
	if ($_POST ['typePersonne'] == 'personnel') {
		// On génère la page pour la saisie d'un salarié
		?>
<h1>Ajouter un salarié</h1>

<div id='salarie'>
	<form name='ajouter_salarie' id='ajouter_salarie' action='#'
		method='post'>
		Numero de telephone professionnel : <input type='text'
			placeholder='0xxxxxxxxx' name='tel_pro' class='champ'
			pattern='[0][0-9]{9}' required> Fonction : <select
			name=choix_fonction class='champ'> 
					<?php
		// Listage de toutes les fonctions
		$pdo = new MyPdo ();
		$fonctionManager = new FonctionManager ( $pdo );
		$fonctions = $fonctionManager->getAllFonctions ();
		foreach ( $fonctions as $fonction ) {
			?>
						<option value="<?php echo $fonction->getFonNum(); ?>"> <?php echo $fonction->getFonLibelle();?> </option>
						<?php
		}
		?>
				</select> <input type='submit' value='Valider'>
	</form>
</div>
<?php
	} else if ($_POST ['typePersonne'] == 'etudiant') {
		// On génère la page pour la saisie d'un étudiant
		?>
<h1>Ajouter un etudiant</h1>

<div id='etudiant'>
	<form name='ajouter_etudiant' id='ajouter_etudiant' action='#'
		method='post'>
		Année : <select name=choix_annee class='champ'> 
					<?php
		// Listage de toutes les années
		$pdo = new MyPdo ();
		$divisionManager = new DivisionManager ( $pdo );
		$divisions = $divisionManager->getAllDivisions ();
		foreach ( $divisions as $division ) {
			?>
						<option value="<?php echo $division->getDivNum(); ?>"> <?php echo $division->getDivNom();?> </option>
						<?php
		}
		?>
				</select> Departement : <select name=choix_departement class='champ'>
					<?php
		// Listage de toutes les departements
		$pdo = new MyPdo ();
		$departementManager = new DepartementManager ( $pdo );
		$departements = $departementManager->getAllDepartements ();
		// var_dump($departements);
		foreach ( $departements as $departement ) {
			?>
						<option value="<?php echo $departement->getDepNum(); ?>"> <?php echo $departement->getDepNom();?> </option>
						<?php
		}
		?>
				</select>

		<!--<input type="hidden" name="per_num" value="<?php //$PersonneManager->getDernierePersonneAjoutee()->getPerNum() ?>">-->
		<!-- Peut être pas utile-->

		<input type='submit' value='Valider'>
	</form>
</div>
<?php
	}
} if ((empty ( $_POST ['nom'] )) and (!empty($_POST['tel_pro']) or !empty($_POST['choix_departement']) )  ) {
	// NORMALEMENT !!!!!!!!!!!!!!!! A TESTER
	// TODO
	// Dans ce cas, le formulaire d'une personne est complet, dans les $_SESSION, et soit le salarie, soit l'etudiant est dans le $_POST
	
	// On va ajouter une personne
	// var_dump($_SESSION['Personne']);
	$idPersonne = $PersonneManager->add ( $_SESSION ['Personne'] );
	// var_dump($idPersonne);
	
	if ($_SESSION ['typePersonne'] == 'etudiant') {
		// On va ajouter l'étudiant
		
		// TODO
		$etudiant = new Etudiant ( array (
				'dep_num' => $_POST ['choix_departement'],
				'div_num' => $_POST ['choix_departement'] 
		) );
		$retour = $EtudiantManager->add ( $etudiant, $idPersonne );
	} else if ($_SESSION ['typePersonne'] == 'personnel') {
		// On va ajouter un salarie
		
		// TODO
		$salarie = new Salarie ( array (
				'sal_telprof' => $_POST ['tel_pro'],
				'fon_num' => $_POST ['choix_fonction'] 
		) );
		
		$retour = $SalarieManager->add ( $salarie, $idPersonne );
	}
	
	if ($retour != null) {
		// OK
		?>
<p>
	<img src="image/valid.png" alt='valid' /> <b><?php echo $_SESSION['Personne']->getPrenomPersonne(); ?></b>
	a été ajouté.
</p>
<?php
		unset ( $_SESSION ['Personne'] );
		// Enlever la variable de session
	} else {
		// erreur
		?>
<p>
	<img src="image/erreur.png" alt='erreur' /> <b><?php echo $_SESSION['Personne']->getPrenomPersonne(); ?></b>
	n'a pas �t� ajout�.
</p>
<?php
		unset ( $_SESSION ['Personne'] );
	}
}
?>