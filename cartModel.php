<?php
    $affichage = "";
    if (!empty($_SESSION['shop'])) {
        if (isset($_POST['remove'])) {
            unset($_SESSION['shop'][$_POST['remove']]);
        }
        foreach ($_SESSION['shop'] as $key=>$value) {
        $array = explode(',', $key);
        $affichage .= 
        '<tr style="height: 100px;">
            <td class="align-middle"><form method="POST"><img width="30%" height="40%" class="img-fluid mr-3" src="'.$array[1].'">'.$array[0].'<button type="submit" class="btn btn-danger ml-3" name="remove" value="'.$key.'">Remove</button></form></td>
            <td class="align-middle text-center">10€</td>
            <td class="align-middle text-center"><input class="text-center" min="1" type="number" value="'.$value.'"></td>
            <td class="align-middle text-center itemTotal"></td>
        </tr>';
        }
    }

    $message = empty($_SESSION['pseudo']) ? '<div class="alert alert-danger" role="alert">
    You need to log in to proceed the shopping ;-) </div>' : "";
?>

