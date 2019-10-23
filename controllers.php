<?php
function detail(){
include'model.php';
include'vues/detail.php';
sendComment($db);
showComment($db);
}

?>