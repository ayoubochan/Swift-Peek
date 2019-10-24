<?php 
// Connexion à la base de données
try
{
	// On se connecte à MySQL
	$db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

function sendComment($db){
if(isset($_POST['sendcomment'])){
	if(isset($_POST['addpseudo']) && isset($_POST['addcomment'])){
		// Insertion du message à l'aide d'une requête préparée
$req = $db->prepare('INSERT INTO comments (pseudo, comment,movie) VALUES(?,?,?)');
$req->execute(array($_POST['addpseudo'], $_POST['addcomment'], $_REQUEST['i']));
     // header('Location:comment_section.php');
	  }
	
	}
}

function showComment($db){
//Récupere toutes les infos de la TABLE comment et les affichent
//$reponse = $db->query('SELECT * FROM comments ORDER BY date DESC');

// Récupération des commentaires
$recup = $db->prepare('SELECT * FROM comments WHERE movie = ? ORDER BY date DESC');
$recup->execute(array($_REQUEST['i']));

while ($donnees = $recup->fetch())
{
   echo htmlspecialchars($donnees['pseudo'])."<br>";
   echo htmlspecialchars($donnees['comment'])."<br>";
   echo htmlspecialchars($donnees['date'])."<br><br>"; 

}
$recup->closeCursor(); // Termine le traitement de la requête
}
