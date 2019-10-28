
<?php
//Veux être sur d'être connecté à la base de donnée
try{
    $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
die('Erreur : ' .$e->getMessage());
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

//Fonction qui vérifie les données entrées par l'utilisateur
function verifyUserData($db){
    //Vérifie s'il y'a eu un post   
    if(isset($_POST['onEnvoi'])){
            // Vérifie si les champs ne sont pas vide
            if(!empty($_POST['monPseudo'])  && !empty($_POST['monMotDepass'])){
            
                //Mot de passe crypté
                //$monMotDepass = sha1($_POST['monMotDepass']);

                //les caractères spéciaux en entités HTML pour le pseudo
                $monPseudo = htmlspecialchars($_POST['monPseudo']);

                //Requete à  Mysql
                $req = $db->prepare("select * from users 
                                        where pseudo = :monPseudo 
                                        or email =:monMail");

                $req->execute(array('monPseudo' => $monPseudo, 'monMail' => $monPseudo));
                $resultat = $req->fetch();
                $req->closeCursor();

                //Vérifier que l'utilisateur à entré les bonnes données
                //$motDepassCorrect = password_verify($monMotDepass, $resultat['password']);
                

                //Ouverture de la session SI le mot de passe est correct.
                if(($_POST['monMotDepass']) == $resultat['password']){
                     //session_start();
                     //$_SESSION['id'] = $resultat['id'];
                     $_SESSION['pseudo'] = $monPseudo;
                     return $_SESSION['pseudo'].' '.','.'You are connected.';
                    
                   
                }else{
                    //Vérifie les érreurs de validité dans le champs Pseudo/Mail
                    $mssgErr = '';
                    $mssgErr = 'Your id or password is not valid';
                    return $mssgErr;
   
                }

                //Le boutton déconnexion
                if(isset($_POST['onSedeconnect'])){
                    session_destroy();
                    if(empty($_SESSION['pseudo'])){
                    $ilEstDeconnect = 'You are disconnected';
                    return $ilEstDeconnect;
                    var_dump($ilEstDeconnect);
                    }
                }

        }else{
            //Message erreur si les champs sont vide
            $mssgErr = 'invalid input';
            return $mssgErr;

        }
    }

}





//Commentaire dans la bdd
    function sendComment($db){
    if(isset($_POST['sendcomment'])){
        if(isset($_POST['addpseudo']) && isset($_POST['addcomment'])){
            // Insertion du message à l'aide d'une requête préparée
    $req = $db->prepare('INSERT INTO comments (pseudo, comment) VALUES(?, ?)');
    $req->execute(array($_POST['addpseudo'], $_POST['addcomment']));
        
        }
        
        }
    }
    //Montre les commentaire
    function showComment($db){
    //Récupere toutes les infos de la TABLE comment et les affichent
    $reponse = $db->query('SELECT * FROM comments ORDER BY date DESC');
    while ($donnees = $reponse->fetch())
    {
    echo htmlspecialchars($donnees['pseudo'])."<br>";
    echo htmlspecialchars($donnees['date'])."<br>"; 
    echo htmlspecialchars($donnees['film'])."<br>";
    echo htmlspecialchars($donnees['comment'])."<br><br>"; 

    }
    $reponse->closeCursor(); // Termine le traitement de la requête
    }

?>

