<?php

// Choose the right page to show

include 'controllers.php';

/*switch(true) {
  case !isset($_REQUEST['i']):
    home();
    break;
  case isset($_REQUEST['i']):
    detail();
    break;
}*/

if (isset($_REQUEST['i'])) {
  detail();
} else {
  if (isset($_REQUEST['cart'])) {
  cart();
  } else {
    home();
  }
}
