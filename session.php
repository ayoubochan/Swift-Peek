<?php
function addSession() {
if (isset($_POST['add'])) {
    if (isset($_SESSION['shop'])) {
        if ($_SESSION['shop'][$_REQUEST['i']] != null) {
            $_SESSION['shop'][$_REQUEST['i']] ++;
        } else {
            $_SESSION['shop'][$_REQUEST['i']] = 1;
        }
    } else {
        $_SESSION['shop'][$_REQUEST['i']] = 1;
    }
}
if (isset($_POST['delete'])) {
    unset($_SESSION['shop'][$_REQUEST['i']]);
}
}