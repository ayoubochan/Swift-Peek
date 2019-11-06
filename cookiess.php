<?php
function addCookie() {
if (isset($_POST['add'])) {
    $temps = 3600*24*365;
    setcookie("movies_id", $_REQUEST['i'], time() * $temps, null, null, false, true);
}

if (isset($_POST['delete'])) {
    setcookie("movies_id", "", time() - 3600);
}
}
