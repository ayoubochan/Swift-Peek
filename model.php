<?php

// Try to access Database

try{
    $db = new PDO('mysql:host=localhost;dbname=swift_peek;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
die('Erreur : ' .$e->getMessage());
}


// function that verify connexion validity
function verifyUserData($db){
    if(isset($_POST['onEnvoi'])){
            if(!empty($_POST['monPseudo'])  && !empty($_POST['monMotDepass'])){

                $monPseudo = htmlspecialchars($_POST['monPseudo']);

                $req = $db->prepare("select * from users 
                                        where pseudo = :monPseudo 
                                        or email =:monMail");

                $req->execute(array('monPseudo' => $monPseudo, 'monMail' => $monPseudo));
                $resultat = $req->fetch();
                $req->closeCursor();
                
                //User session created
                if(($_POST['monMotDepass']) == $resultat['password']){

                     $_SESSION['pseudo'] = $monPseudo;
                     return $_SESSION['pseudo'].' '.','.'You are connected.';
                    
                   
                }else{

                    $mssgErr = '';
                    $mssgErr = 'Your id or password is not valid';
                    return $mssgErr;
                }

               

        }else{
            $mssgErr = 'invalid input';
            return $mssgErr;

        }
    }
 // User session destroyed
 if(isset($_POST['onSedeconnect'])){
                
    $_SESSION['pseudo']="";
    
    
}
}

    // Send comments to DB
    function sendComment($db){
    if(isset($_POST['sendcomment'])){
        if(isset($_SESSION['pseudo']) && isset($_POST['addcomment'])){
    
    $req = $db->prepare('INSERT INTO comments (pseudo, comment,movie) VALUES(?, ?,?)');
    $req->execute(array( $_SESSION['pseudo'], $_POST['addcomment'], $_REQUEST['i']));
        
        }
        
        }
    }

    function showComment($db){
    
    $reponse = $db->prepare('SELECT * FROM comments WHERE movie = ? ORDER BY date DESC');
    $reponse->execute(array($_REQUEST['i'])); // Take id movie to fetch the right comments
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
    $reponse->closeCursor();
    // Array of comments returned
    return $commentArray;
    }

    // Treat registrations and secure user data
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
