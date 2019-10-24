<?php

function home() {
  include 'vues/home.php';
  include 'model.php';
}

function detail(){
  include 'vues/components/Back-button.php';
  include 'model.php';
  include 'vues/detail.php';
  sendComment($db);
  showComment($db);
}

?>
