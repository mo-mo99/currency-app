<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
$price_per_ruble;
foreach($data as $da) {
    if($da['name'] === $_POST['currency']){
        $price_per_ruble = $da['rate']/$da['unit'];
    }
}

if($_POST['ruble'] == 0){
    $calc = $price_per_ruble * $_POST['currency_number'];
    echo $_POST['currency_number']. ' '.$_POST['currency']. ' = ' . $calc. ' rubles';
}elseif($_POST['currency_number'] == 0 && $_POST['ruble'] != 0){
    $calc = $_POST['ruble'] / $price_per_ruble;
    echo $_POST['ruble']. ' rubles' . ' = ' . $calc . ' '. $_POST['currency'];
}else {
    echo "not valid data";
}
}

?>

<?php if (isset($_SESSION["user_id"])): ?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>profile</title>
    </head>
    <body>
    <p><a href="/home">Home</a></p>
        <h1>Profile</h1>
        
        <form method="post">
        <div class="input-group mb-3">
            <label class="input-group-text" for="Currency">Currency</label>
            <select class="form-select" id="Currency" name="currency">
                <option >Choose...</option>
                <?php foreach($data as $d): ?>
                    <option value="<?= $d['name']; ?>"> <?= $d['name']; ?> </option>
                <?php endforeach; ?> 
            </select>
            <input type="number" name="currency_number"
            value="<?= htmlspecialchars($_POST["currency_number"] ?? "0") ?>"
            ></input>
            <label for="ruble">Ruble</label>
            <input type="number" id="ruble" name="ruble" value=0></input>
        </div>
        <button>Calculate</button>
        </form>
    </body>
</html>
<?php else: ?>
    
    <?php Header('location: /views/login.blade.php') ?>
<?php endif ?><?php /**PATH /Users/mamad/dev/php/currencyApp/views/profile.blade.php ENDPATH**/ ?>