<?php
//Veux être sur d'être connecté à la base de donnée
try{
    $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
                    
                    //La déconnexion
                    if(isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
                        $connectOupas = '';
                        $connectOupas = 'visibility: visible';
                        return $connectOupas;
                    }else{
                        $connectOupas = 'visibility: hidden';
                        return $connectOupas;
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