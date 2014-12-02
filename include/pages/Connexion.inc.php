<h1>Pour vous connecter</h1>

<?php 

$pdo=new Mypdo();
$personneManager=new PersonneManager($pdo);

$nb1= rand(1, 9);
$nb2= rand(1, 9);


if (empty($_POST['reponse']))
{
?>

<form action="#" method="post">
		Login : 
		<input type="text" name="per_login" id="per_login">
		<br/>
		Mot de passe : 
		<input type="password" name="per_pwd" id="per_pwd">
		<br/>
		<p> 
		Merci de résoudre le calcul suivant pour confirmer que vous n'êtes pas un robot <br/>
		<?php echo "$nb1+$nb2 = ?"; ?>
		</p>
		<input type="hidden" name="nb1" value="<?php echo $nb1; ?>" />
		<input type="hidden" name="nb2" value="<?php echo $nb2; ?>" />
		<br/>
		<input type="text" pattern='[0-9]' name="reponse" /> 
		<br/>
		<input type="submit" value="Connexion" />
	</form>
<?php 
} else 
{
	
	$nb1_verif = $_POST['nb1'];
	$nb2_verif = $_POST['nb2'];
	$resultat = $nb1_verif + $nb2_verif; //resultat attendu.
	
	$reponse = $_POST['reponse']; //réponse de l'utilsateur
	
	$login = $_POST['per_login'];
	$pass = $_POST['per_pwd'];
	//détails de la connexion
	$connexionOK = $personneManager->testConnexion($login, $pass);

	var_dump($connexionOK);
	var_dump($login);
	var_dump($reponse);
	
	
	if ($reponse != $resultat) //si le captcha est incorrect
	{
		echo "Le captcha est incorrect";
	}
	
	if ($connexionOK == false) //mauvais mot de passe/identifiant
	{
		echo "Erreur d'identifiant / mot de passe";
	}
	
	if ( ($connexionOK == $resultat) && ($connexionOK == true) ) //le captcha est bon et les id/mdp aussi
	{
		$_SESSION['per_login'] = $_POST['per_login'];
		$personneConnectee = $personneManager->getPersonneParLogin($_SESSION['per_login']);
		$_SESSION["per_num"] = ($personneConnectee->getPerNum()->per_num);
		// Probleme, etant donné que c'est un objet
		// TODO
		var_dump($personneConnectee);
		echo "<p>Bienvenue ".$personneConnectee->getPrenomPersonne()." !</p>";
	}
}
?>