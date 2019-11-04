
<?php

//Veux être sur d'être connecté à la base de donnée
try{
    $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
die('Erreur : ' .$e->getMessage());
}


//Fonction qui vérifie les données entrées par l'utilisateur
function verifyUserData($db){
    //Vérifie s'il y'a eu un post   
    if(isset($_POST['onEnvoi'])){
            // Vérifie si les champs ne sont pas vide
            if(!empty($_POST['monPseudo'])  && !empty($_POST['monMotDepass'])){
            
                //Mot de passe crypté
                //$monMotDepass = password_hash($_POST['monMotDepass'],PASSWORD_DEFAULT);

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

                     //$_SESSION['id'] = $resultat['id'];
                     $_SESSION['pseudo'] = $monPseudo;
                     return $_SESSION['pseudo'].' '.','.'You are connected.';
                    
                   
                }else{
                    //Vérifie les érreurs de validité dans le champs Pseudo/Mail
                    $mssgErr = '';
                    $mssgErr = 'Your id or password is not valid';
                    return $mssgErr;
   
                }

               

        }else{
            //Message erreur si les champs sont vide
            $mssgErr = 'invalid input';
            return $mssgErr;

        }
    }
 //Le boutton déconnexion
 if(isset($_POST['onSedeconnect'])){
                
    $_SESSION['pseudo']="";
    echo "vs etres deco";
    
}
}

//Lien menant vers la page motDepassPerdu
if(isset($_POST['lostPassWord'])){
    header('Location: vues/components/motDepassPerdu.php');
    exit();
}




//Commentaire dans la bdd
    function sendComment($db){
    if(isset($_POST['sendcomment'])){
        if(isset($_SESSION['pseudo']) && isset($_POST['addcomment'])){
            // Insertion du message à l'aide d'une requête préparée
    $req = $db->prepare('INSERT INTO comments (pseudo, comment,movie) VALUES(?, ?,?)');
    $req->execute(array( $_SESSION['pseudo'], $_POST['addcomment'], $_REQUEST['i']));
        
        }
        
        }
    }
    //Montre les commentaire
    function showComment($db){
    
    //Récupere toutes les infos de la TABLE comments avec une requete préparée (laisser le prepare, ne pas mettre de query sinon ca fonctionne pas) et va ensuite les afficher en fonction du film
    $reponse = $db->prepare('SELECT * FROM comments WHERE movie = ? ORDER BY date DESC');
    $reponse->execute(array($_REQUEST['i'])); // fait en sorte que les commentaires s'affichent en fonction du film
    $commentArray = [];
    while ($donnees = $reponse->fetch())
    {
    array_push($commentArray, 
    "<li>
    <p id='pseudo'>". htmlspecialchars($donnees['pseudo']) ."</p>
    <p id='comment'>". htmlspecialchars($donnees['comment']) ."</p>
    <p class='date'>". str_replace(" ", " | ", substr(htmlspecialchars($donnees['date']), 0, 16)) ."</p>
    </li>"
    );
    }
    $reponse->closeCursor(); // Termine le traitement de la requête
    return $commentArray;
    }

       // partie fred inscription base de donnée 
    function register($db){

        if (isset ($_POST["submit"])){

            $pseudo=trim(htmlspecialchars($_POST["pseudo"]));
            $allPseudo=$db->query("SELECT pseudo FROM users ");
        
            while($alllist=$allPseudo->fetch()){
                if ($pseudo===$alllist["pseudo"]){
        
                    
                       
                }   
               
            }
             
            $email = trim(htmlspecialchars($_POST["email"]));
                 $allmaillist=$db->query("SELECT email From users");
                  while($allmail=$allmaillist->fetch()){
        
                      if ($email===$allmail["email"]){
                          
                      }
                  }
             
            $password = trim(htmlspecialchars($_POST["password"]));
            $password2 = trim(htmlspecialchars($_POST["password2"]));
                
            }    
              if (isset($pseudo) && isset($email) && isset ($password) && isset($password2)){
        
                         if ( $password!==$password2  ){
        
                         }
                         else{
                             $password=md5($password);
        
                            $db->exec("INSERT INTO users (pseudo, password, email) VALUE('$pseudo','$password','$email')");
                            
        
                         }
             }
        
    }
