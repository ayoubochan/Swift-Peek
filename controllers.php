<?php

// Define the DOM and logic for each page

session_start();
function home(){
    include 'model.php';
    include 'vues/home.php';
    verifyUserData($db);
    register($db);

}

function detail(){
  include 'model.php';
  include 'session.php';
  include 'vues/detail.php';
}

function cart() {
  include 'vues/cart.php';
}

?>

