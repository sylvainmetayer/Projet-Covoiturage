<?php 
	//modifier cette page.
	// 1 - Si vide : saisie formulaire
	// 2 - si pas vide, completer données salarie/etudiant
	// 3 - Si données salarie/etudiant pas vide, ajout personne et ensuite ajout etudiant/salarié
	// 4 - Utiliser des variable de sessions pour se faciliter les if
	$pdo = new MyPdo();
	$PersonneManager = new PersonneManager($pdo);
?>	
	<h1>Ajouter une personne</h1>

<?php
// On verifie que aucun champ est vide
if (empty($_POST['nom']) 
or empty($_POST['prenom']) 
or empty($_POST['tel']) 
or empty($_POST['mail']) 
or empty($_POST['login']) 
or empty($_POST['mdp']) 
or (empty($_POST['typePersonne']))
)
{
?>
<div id='personne'>
<form name='ajouter_personne' id='ajouter_personne' action='#' method='post'>
<p> 
Nom : <input type='text' placeholder='Ex : Michu' name='nom' class='champ' required>
Prénom : <input type='text' placeholder='Ex : Sarah' name='prenom' class='champ' required>
<br/>
Téléphone : <input type='text' placeholder='0xxxxxxxxx' name='tel' class='champ' pattern='[0][0-9]{9}' required>
Mail : <input type='mail' placeholder='sarah.michu@example.fr' name='mail' class='champ' required>
<br/>
Login : <input type='text' placeholder='Ex : Sarah87' name='login' class='champ' required>
Mot de passe : <input type='password' placeholder='********' name='mdp' class='champ' required>
<br/>
Catégorie : 
<input type='radio' name='typePersonne' class='champ' value='etudiant' checked='checked'> Etudiant </input>
<input type='radio' name='typePersonne' value='personnel' class='champ'> Personnel </input>
<br/>
<input type='submit' value='Valider'>

<?php
}
else
{
	//On récupère les valeurs saisies
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	var_dump($prenom);
	$tel = $_POST['tel'];
	$mail = $_POST['mail'];
	$login = $_POST['login'];
	$mdp = $_POST['mdp'];
	
	
	
	//On affiche une page differente selon le statut de la personne, et on redirige pour le requete de l'étudiant ou du salarié
	if ($_POST['typePersonne']=='personnel') { 
		//$typePersonne=1; //Personnel
		//formulaire personnel
		?>
		<h1>Ajouter un salarié</h1>
		<form name='ajouter_salarie' id='ajouter_salarie' action='ajouter_salarie.inc.php' method='post'>
		Numero de telephone professionnel :
		<input type='text' placeholder='0xxxxxxxxx' name='tel' class='champ' pattern='[0][0-9]{9}' required>
		
		Fonction :
		<select name=choix_fonction class='champ'> 
			<option>Choissisez votre fonction</option>
			<?php
			//Listage de toutes les années
			$pdo = new MyPdo();
			$fonctionManager = new FonctionManager($pdo);
			$fonctions = $fonctionManager->getAllFonctions();
			foreach ($fonctions as $fonction) 
			{ 
				?>
				<option value="<?php echo $fonction->getFonNum(); ?>" > <?php echo $fonction->getFonLibelle();?> </option>
				<?php 
			}
			?>
		</select>
		
		<input type='submit' value='Valider'>
		<?php
	}
	else { //$_POST['typePersonne']=='etudiant'
		//$typePersonne=0; //Etudiant
		//formulaire etudiant
		?>
		<form name='ajouter_etudiant' id='ajouter_etudiant' action='ajouter_etudiant.inc.php' method='post'>
		Année :
		<select name=choix_annee class='champ'> 
			<option>Choissisez votre année</option>
			<?php
			//Listage de toutes les années
			$pdo = new MyPdo();
			$divisionManager = new DivisionManager($pdo);
			$divisions = $divisionManager->getAllDivisions();
			foreach ($divisions as $division) 
			{ 
				?>
				<option value="<?php echo $division->getDivNum(); ?>" > <?php echo $division->getDivNom();?> </option>
				<?php 
			}
			?>
		</select>
		
		Departement :
		<select name=choix_departement class='champ'> 
			<option>Choissisez votre departement</option>
			<?php
			//Listage de toutes les departements
			$pdo = new MyPdo();
			$departementManager = new DepartementManager($pdo);
			$departements = $departementManager->getAllDepartements();
			var_dump($departements);
			foreach ($departements as $departement) 
			{ 
				?>
				<option value="<?php echo $departement->getDepNum(); ?>" > <?php echo $departement->getDepNom();?> </option>
				<?php 
			}
			?>
		</select>
	
		<input type="hidden" name="per_num" value="<?php $PersonneManager->getDernierePersonneAjoutee()->getPerNum() ?>">
		
		<input type='submit' value='Valider'>
		</form>
		<?php
	}

	//On va ajouter une personne
	$Personne = new Personne(array(
	'per_nom' => $nom, 
	'per_prenom' => $prenom, 
	'per_tel' => $tel, 
	'per_mail' => $mail, 
	'per_login' => $login,
	'per_pwd' => $mdp,
	));
	var_dump($Personne);
	$retour = $PersonneManager->add($Personne);
	
/* 	if ($retour != 0) //OK
	{
		?>  
		<p>
		<img src="image/valid.png" alt='valid'/>
		La personne <b><?php echo $_POST['prenom'] ?></b> a été ajoutée 
		</p>
	<?php
	}
	else
	{
		?>  
		<p>
		<img src="image/erreur.png" alt='erreur'/>
		La personne <b><?php echo $_POST['prenom'] ?></b> n'a pas été ajoutée 
		</p>
	<?php 
	} */
}
?>