<?php
    if (!empty($_COOKIE['movies_id'])) {
        $affichage = 
        '<tr style="height: 100px;">
            <td class="align-middle">'.($_COOKIE['movies_id']).'<button type="submit" class="btn btn-danger ml-5">Remove</button></td>
            <td class="align-middle text-center">10€</td>
            <td class="align-middle text-center">1</td>
            <td class="align-middle text-right">10€</td>
        </tr>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Shopping cart</title>
</head>
<body>
    <h3 class="text-center mt-3">Your cart</h3>
    <div class="container">
    <div class="row">
        <table class="table mt-4">
            <thead>
                <tr>
                    <th style="border-top:none;" scope="col">Product</th>
                    <th style="border-top:none;" scope="col" class="text-center">Price</th>
                    <th style="border-top:none;" scope="col" class="text-center">Quantity</th>
                    <th style="border-top:none;" scope="col" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?=$affichage?>
            </tbody>
        </table>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="d-flex flex-column justify-content-center">
            <p>Total : </p>
            <button class="btn btn-secondary">CHECK OUT</button>
        </div>
    </div>
    </div>
</body>
</html>