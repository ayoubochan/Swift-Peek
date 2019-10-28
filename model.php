
<?php
//Veux être sur d'être connecté à la base de donnée
try{
    $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
                $monMotDepass = sha1($_POST['monMotDepass']);

                //les caractères spéciaux en entités HTML pour le pseudo
                $monPseudo = htmlspecialchars($_POST['monPseudo']);
                //echo $monPseudo;

                //Requete à cet enfoiré de Mysql
                $req = $db->prepare("select * from users 
                                        where pseudo = :monPseudo 
                                        or email =:monMail 
                                        and password = :monMotDepass");

                $req->execute(array('monPseudo' => $monPseudo, 'monMail' => $monPseudo,  'monMotDepass' => $monMotDepass));
                $resultat = $req->fetch();
                $req->closeCursor();
                //print_r( $resultat);

                //Vérifier que l'utilisateur à entré les bonnes données
                $motDepassCorrect = password_verify($monMotDepass, $resultat['password']);

                //Ouverture de la session SI le mot de passe est correct.
                if($resultat){
                    //echo 'Vous êtes connecté';
                    if($motDepassCorrect){
                        session_start();
                        $_SESSION['id'] = $_POST['id'];
                        $_SESSION['pseudo'] = $monPseudo;
                          
                    }
                }else{
                    //Vérifie les érreurs de validité dans le champs Pseudo/Mail
                    $mssgErr = '';
                    $mssgErr = 'Your id or password is not valid';
                    return $mssgErr;
   
                }


        }else{
            //Vérifie l'erreur des champs vide
            $mssgErr = 'invalid input';
            return $mssgErr;
            //echo 'invalid input';

            
            
        }
    }

}

?>
