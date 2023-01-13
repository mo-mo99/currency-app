<?php 


?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
    </head>
    <body>
        
        <h1>Home Page</h1>
        <?php if (isset($_SESSION["user_id"])): ?>
            <p>Hey <?= $user ?></p>
            <p><a href="/logout">Log out</a></p>
            <p><a href="/profile">profile</a></p>
        <?php else: ?>
        <p><a href="/login">Log in</a> or <a href="/signup">Sign up</a>
        <?php endif ?>
    </body>
</html>
<?php /**PATH /Users/mamad/dev/php/currencyApp/views/home.blade.php ENDPATH**/ ?>