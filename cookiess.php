<?php

$temps = 3600*24*365;

setcookie("movies_id", $_REQUEST['i'], time() * $temps, null, null, false, true);


?>