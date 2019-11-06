<?php
$fraisLivraisonBelgique = 0;
$fraisLivraisonUE = 2.5;
$fraisLivraisonWorld = 5;
$reduction = 0.05; // Réduction à partir de 5 articles
$codePromo = "MikeEstTropCool";
$codePro = "";
$codePromoOk = false;
$promo = 0.10;
$promoBelgique = 0.15;
$prix = 10; // Prix identique pour tout les films
$quantiteReduction = 5;
//$Quantite = $_COOKIE[$_SESSION['QUANTITY']];
$quantite = 1;
$total = 0;
$totalHorsPromo = 0;
$login = false;
$destination = 'Belgique';

$totalHorsPromo = $prix * $quantite;

if ($codePro == $codePromo) {
    $codePromoOk = true;
}

if ($quantite >=  $quantiteReduction) {
    $total = $totalHorsPromo - ($totalHorsPromo * $reduction);
}

switch ($destination) {
    case 'Belgique':
        if ($codePromo) {
            $total = $total - ($total * $promoBelgique);
        } else {
            $total = $total + $fraisLivraisonBelgique;
        }
        break;
    case 'UE':
        if ($codePromo) {
            $total = $total - ($total * $promo);
        } else {
            $total = $total + $fraisLivraisonUE;
        }
        break;
    case 'World':
        if ($codePromo) {
            $total = $total - ($total * $promo);
        } else {
            $total = $total + $fraisLivraisonWorld;
        }
        break;
    default:
}
echo $total;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
</body>
</html>