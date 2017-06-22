<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>GSB - Connexion</title>
<link rel="stylesheet" href="gsb.css">
<link href="https://fonts.googleapis.com/css?family=Lobster|Playfair+Display" rel="stylesheet">
<script type="text/javascript">
// language = "javascript"
function verif_formulaire(){
	alert("Saisis");
	var regexPseudo = new RegExp(/^[a-z]([a-z]([0-9]{0,4}){4,20})/i);
	var regexMDP = new RegExp(/^[a-z]([a-z]/*([0-9]{2,})([_#*$]{2,})*/{7,20})/i);
	alert("Sa5644isis");
	if(!regexPseudo.test(document.frmFormulaire.txtPseudo.value))  {     
		// on affiche un message     
		alert("Saisissez un pseudo valide !\nIl doit contenir :\n\t- Entre 5 et 20 caracteres."
				+ "\n\t- N'etre compose uniquement de lettres et de chiffres"
				+ "\n\t- Commencer par une lettre\n\t- Comporter entre 0 et 4 chiffres");
		document.frmFormulaire.txtPseudo.focus();
		return false;
		}
	else if(!regexMDP.test(document.frmFormulaire.txtMDP.value))  {
		alert("Saisissez un mot de passe valide !\nIl doit contenir :\n\t- Entre 8 et 20 caracteres."
				+ "\n\t- N'etre compose uniquement de lettres, de chiffres et des symboles suivant : _#*$"
				+ "\n\t- Commencer par une lettre\n\t- Comporter au moins 2 chiffres"
				+ "\n\t- Comporter au moins 2 des symboles suivant : _#*$");
		document.frmFormulaire.txtMDP.focus();
		return false;   
	}
	else
		{
		return true;
		}
	} 
	</script>
</head>
<body>

<h1> Galaxy Swiss Bourdin </h1>
<div id="Logo">
<img src="images/icon-medical.gif" alt="Nouveau !" >
</div>

<div id="home1">
<a href="index.php"><img src="images/home.png" alt= "home"></a>
<FONT face="Lobster">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</FONT>
</div>

<?php
//echo '<body onLoad="alert(\''.$_POST['deconnexion'].'\')">';
$connecte = false;
try {
	/*$_POST['txtLogin'] = "ltusseau";
	$_POST['txtMDP'] = "ktp3s";*/
	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == "Deconnexion"){
		session_start ();
		session_unset ();
		session_destroy ();
		//header ('location: index.htm');
		//header("Refresh:0");
	}else if (isset($_POST['txtLogin']) && isset($_POST['txtMDP']) && 
			$_POST['txtLogin']!="" && $_POST['txtMDP']!="") {
			
	$source = "mysql:host=localhost;dbname=gsbv2";
	$utilisateur = "root";
	$mot_de_passe = "";
	$db = new PDO($source, $utilisateur, $mot_de_passe);
	$sql_select = "SELECT idVisiteur, nom, prenom, adresse, cp, ville, dateEmbauche FROM visiteur WHERE login='"
		.$_POST['txtLogin']."' AND mdp='".$_POST['txtMDP']."';";
	$st = $db->prepare($sql_select);
	
	/*//OU insertion dans BDD avec parametres
	 $sql_insert     =     "INSERT     INTO     clients     (NomCli,PreCli,AdrCli,TelCli) VALUES(:p1,:p2,:p3,:p4)";
	 $st= $db->prepare($sql_insert);
	 $st->bindParam(":p1",$nom);
	 $st->bindParam(":p2",$prenom);
	 $st->bindParam(":p3",$adr);
	 $st->bindParam(":p4",$tel);*/
	$st->execute();
	$lignes = $st->fetch();
	
	if(count($lignes[0]) == 1){
		session_start ();
		$_SESSION['login'] = $_POST['txtLogin'];
		$_SESSION['MDP'] = $_POST['txtMDP'];
		$_SESSION['idVisiteur'] = $lignes[0];
		$_SESSION['nom'] = $lignes[1];
		$_SESSION['prenom'] = $lignes[2];
		$_SESSION['adresse'] = $lignes[3];
		$_SESSION['cp'] = $lignes[4];
		$_SESSION['ville'] = $lignes[5];
		$_SESSION['dateEmbauche'] = $lignes[6];
		$connecte = true;
		//$_SESSION['connecte'] = true;
		//header ('location: page_membre.php');
		echo "<FONT face=\"Lobster\"><div id=\"connexion\">Bonjour "
		.$_SESSION['prenom']." ".$_SESSION['nom']." (".$_SESSION['idVisiteur'].")";
		?>
		<form action="connexion.php" method="post">
		<INPUT TYPE = "submit" NAME = "deconnexion" VALUE ="Deconnexion"/>
		</form>
		</div>
		</FONT>
		<?php
	}
	else {
		//echo '<body onLoad="alert(\'Membre introuvable...\')">';
		echo '<script type="text/javascript">alert("Membre introuvable...");</script>';
		//echo '<meta http-equiv="refresh" content="0;URL=index.htm">';
	}
	$sql_select = null;
	$st = null;
	$db = null;
	$lignes = null;
}
} catch (PDOException $e) {
	echo '<body onLoad="alert(\'Erreur!: ',$e->getMessage(),'<br />\')">';
	die();
}

if(!$connecte){
?>
<form name = "frmFormulaire" action="connexion.php" method="post" onSubmit="return verif_formulaire()">
<div id="connexion">
<FONT face="Lobster">
Connexion :</br>
Pseudo <INPUT type=text name="txtLogin" size="20"/>
Mot de passe <INPUT type=text name="txtMDP" size="20"/>
<INPUT TYPE = "submit" VALUE ="Connexion"/>
</FONT>
</div>
</form>
<?php	
}
?>
 
<div id="Frais">
<FONT face="Lobster" id="Fiche">Fiche Forfaitaire
</br></br>
Frofait Etape  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type=text name="txt_nom" id="saisie1">
</br></br>
Frais kilométriques  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type=text name="txt_nom" id="saisie2">
</br></br>
Nuitée hôtel  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type=text name="txt_nom" id="saisie3">
</br></br>
Repas rstaurant    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type=text name="txt_nom" id="saisie4">
</br></br>
<INPUT TYPE = "submit" VALUE ="Confirmer" id="confirmer" >
</FONT>
</div>
	
<div id="AutresF">
</br></br>
<FONT face="Lobster" id="autres">Autres
</br></br>
Le&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type=date name="date" id="date">
</br></br>
L'achat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type=text name="achat" id="achat">
			</br></br>
			Le prix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type=text name="prix" id="prix">
			</br></br>
			<INPUT TYPE = "submit" VALUE ="Valider" id="confirmer" >
			</FONT>
			</div>
	</body>
</html>