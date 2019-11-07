<?php
function addSession() {
    if (isset($_POST['add'])) {
        if (isset($_SESSION['shop'])) {
            if ($_SESSION['shop'][$_POST['add']] != null) {
                $_SESSION['shop'][$_POST['add']] ++;
            } else {
                $_SESSION['shop'][$_POST['add']] = 1;
            }
        } else {
            $_SESSION['shop'][$_POST['add']] = 1;
        }
    }
}