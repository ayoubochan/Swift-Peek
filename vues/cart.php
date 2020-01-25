<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="vues/css/cart.css">
    <script src="https://kit.fontawesome.com/7b840f6fa2.js" crossorigin="anonymous"></script>
    <title>Shopping cart</title>
</head>
<body>
    <?=$message?>
    <a href="index.php"><i class="fas fa-chevron-left fa-3x ml-3" id="cart-arrow"></i></a>
    <h3 class="text-center mt-3">Your cart</h3>
    <div class="container">
    <div class="row">
        <table class="table mt-4">
            <thead>
                <tr>
                    <th style="border-top:none;" scope="col">Product</th>
                    <th style="border-top:none;" scope="col" class="text-center">Price</th>
                    <th style="border-top:none;" scope="col" class="text-center">Quantity</th>
                    <th style="border-top:none;" scope="col" class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?=$affichage?>
            </tbody>
        </table>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="d-flex flex-column justify-content-center">
            <h3 id="total"></h3>
            <form method="POST" class="mt-3">
                <button class="btn btn-checkout" name="checkout" id="checkout">CHECK OUT</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>

<script>
let input = document.getElementsByTagName('input')
let itemTotal = document.getElementsByClassName('itemTotal')
let arrayTotal = []
function defineArray() {
    arrayTotal = []
    for(let i = 0; i < input.length; i++) {
    arrayTotal.push(input[i].value)
    input[i].onchange = () => {
        showTotal()
    }
}
return arrayTotal
}

defineArray()

let total = 0
let arrayItem = []
function defineTotal() {
    total = 0
    arrayItem = []
    defineArray().map((elem, index) => {
        arrayItem.push(parseInt(elem))
        total += parseInt(elem)
        
})
return total
}

function showTotal() {
        document.getElementById('total').textContent = `Total : ${defineTotal() * 10}€`
        for (let j=0; j<itemTotal.length; j++) {
            itemTotal[j].textContent = `${arrayItem[j] * 10}€`
        }
        document.getElementById('checkout').value = defineTotal()
}
showTotal()

/*for (let i=0; i<input.length; i++) {
    total = parseInt(input[i].value)
    saveTotal = total
    input[i].addEventListener('change', function(e) {
        console.log(5, e.target.value, total)
        total = ((total + parseInt(e.target.value)) - saveTotal)
        saveTotal = total
        document.getElementById('total').textContent = `Total : ${total}`
    })
    
}*/
//document.getElementById('total').textContent = `Total : ${total}`
</script>