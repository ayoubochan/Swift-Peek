<?php
function home(){
    include 'model.php';
    include 'vues/home.php';
    
    //Appel de la fonction qui vérifie les entrées de l'utilisateur
    verifyUserData($db);



}


?>