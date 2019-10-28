<?php

function home(){
    include 'model.php';
    include 'vues/home.php';
    //include 'vues/components/formConnexion.php';
    
    //Appel de la fonction qui vérifie les entrées de l'utilisateur
    verifyUserData($db);

}

function detail(){
  include 'model.php';
  include 'vues/detail.php';
  //Envoi et montre les détails
  sendComment($db);
  showComment($db);
}


?>

