<?php
session_start(); 
$codePromo = "MikeEstTropCool";
if (isset($_POST['nom'])) {
    $_SESSION['form_buy']['nom']=$_POST['nom'];
}
if (isset($_POST['rue'])) {
    $_SESSION['form_buy']['rue']=$_POST['rue'];
}
if (isset($_POST['ville'])) {
    $_SESSION['form_buy']['ville']=$_POST['ville'];
}
if (isset($_POST['pays'])) {
    $_SESSION['form_buy']['pays']=$_POST['pays'];
}
if (isset($_COOKIE['quantite'])) {
    $quantite = $_COOKIE["quantite"];
} else {
    $quantite = 0;
}
// print_r ($_SESSION[]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Commande</title>
</head>
<body onload="calculFraisTotal()">
    <div class="container">
        <!-- Formulaire de commande -->
        <form method="POST" action="" onsubmit="msgConfirmation()">
            
            <label for="nbreFilms">Nombre de films</label>
            <input class="form-control" id="nbreFilms" type="text" value="<?php echo $quantite; ?>" onchange="calculFraisTotal()" disabled/>
            <label for="reduction">Réduction (%)</label>
            <input class="form-control" id="reduction" type="text" disabled/>
            <label for="nom">Prénom - Nom *</label>
            <?php if (!empty($_SESSION['form_buy']['nom']))
                        echo '<input class="form-control" id="nom" name="nom" type="text" value="'.$_SESSION['form_buy']['nom'].'" required/>';
                    else 
                        echo '<input class="form-control" id="nom" name="nom" type="text" required/>';
            ?>
            <label for="rue">Rue *</label>
            <?php if (!empty($_SESSION['form_buy']['rue']))
                        echo '<input class="form-control" id="rue" name="rue" type="text" value="'.$_SESSION['form_buy']['rue'].'" required/>';
                    else 
                        echo '<input class="form-control" id="rue" name="rue" type="text" required/>';
            ?>
            <label for="ville">Ville *</label>
            <?php if (!empty($_SESSION['form_buy']['ville']))
                        echo '<input class="form-control" id="ville" name="ville" type="text" value="'.$_SESSION['form_buy']['ville'].'" required/>';
                    else 
                        echo '<input class="form-control" id="ville" name="ville" type="text" required/>';
            ?>
            <label for="pays">Pays</label>
            <select class="form-control" id="pays" name="pays"onchange="calculFraisTotal()" >
                <!--<option>Belgique</option>
                <option>UE</option>
                <option>World</option>-->
                <option value="Belgique" <?php if($_SESSION['form_buy']['pays'] == "Belgique") echo " SELECTED"; ?>>Belgique</option> 
                <option value="UE" <?php if($_SESSION['form_buy']['pays'] == "UE") echo " SELECTED"; ?>>UE</option> 
                <option value="World" <?php if($_SESSION['form_buy']['pays'] == "World") echo " SELECTED"; ?>>World</option> 
            </select>>
            <label for="frais">Frais de livraison (Eur)</label>
            <input class="form-control" id="frais" type="text" disabled/> 
            <label for="codePromo">Code promo</label>
            <input class="form-control" id="codePromo" type="text" onchange="calculFraisTotal()" /> 
            <label for="promo">Promo (%)</label>
            <input class="form-control" id="promo" type="text" disabled/> 
            <label for="total">Total à payer (Eur)</label>
            <input class="form-control" id="total" type="text" /><br>
            <a>Les champs indiqués par une * sont obligatoires</a><br> 

            <button type="submit" class="btn btn-primary">Commander</button>
        </form>
    <div>
    <script type="text/javascript">
        // Rend la touche Enter inactive
        window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true)
            
        // Message de confirmation de la commande
        function msgConfirmation() {
            alert("Commande envoyée");
        }
         
        // Calcul le montant total avec les frais et les réductions
        function calculFraisTotal() {
            var prix = 10; // Prix unique pour les articles en Eur
            var codePro = document.getElementById("codePromo").value;
            
            // Vérification du code promo
            //var codePromo = "MikeEstTropCool";
            var codePromo = <?php echo json_encode($codePromo); ?>;
            var codePromoOk = false;
            if (codePro == codePromo) {
                codePromoOk = true;
            }
            
            // Calcul de la réduction
            var quantite = document.getElementById("nbreFilms").value;
            var reduction = 0;

            if (quantite >= 5) {
                reduction = 5;
            } else {
                reduction = 0;
            }
            document.getElementById("reduction").value = reduction;
            
            // Calcul des frais et de la promo
            var sel = document.getElementById("pays");
            var pays=sel.options[sel.selectedIndex].value;
            var livraison = 0;
            var promo = 0;
            switch (pays) {
                case 'Belgique':
                    if (codePromoOk) {
                        promo = 15;
                        livraison = 0;
                        document.getElementById("promo").value = promo;
                    } else {
                        promo = 0;
                        livraison = 0;
                        document.getElementById("promo").value  = promo;
                    }
                    livraison = 0;
                    document.getElementById("frais").value  = "Frais de livraison gratuit";
                    break;
                case 'UE':
                    if (codePromoOk) {
                        promo = 10;
                        livraison = 0;
                        document.getElementById("promo").value = promo;
                        document.getElementById("frais").value = "Frais de livraison gratuit";
                    } else {
                        promo = 0;
                        livraison = 2.5;
                        document.getElementById("promo").value = promo;
                        document.getElementById("frais").value = livraison;
                    }
                    break;
                case 'World':
                    if (codePromoOk) {
                        promo = 10;
                        livraison = 0;
                        document.getElementById("promo").value = promo;
                        document.getElementById("frais").value = "Frais de livraison gratuit";
                    } else {
                        promo = 0;
                        livraison = 5;
                        document.getElementById("promo").value = promo;
                        document.getElementById("frais").value = livraison;
                    }
                    break;
                default:
            }
            // Calcul du total à payer
            var total = 0;
            var totalReduction = 0;
            total = quantite * prix;
            totalReduction = total - (total * (reduction/100)) - (total * (promo/100)) + livraison;
            if (quantite > 0) {
                document.getElementById("total").value = totalReduction;
            } else {
                document.getElementById("total").value = 0;
            }
        }
  </script>
    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>  
</body>
</html>