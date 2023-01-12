<!DOCTYPE html>
<html lang="eng">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>

        <?php if ($is_invalid) : ?>
            <em>Invalid login</em>
        <?php endif; ?>

        <form method="post">
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password">
            </div>
            <button>Login</button>

        </form>
    </body>
</html><?php /**PATH /Users/mamad/dev/php/currencyApp/views/login.blade.php ENDPATH**/ ?>