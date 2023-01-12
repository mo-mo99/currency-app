<!DOCTYPE html>
<html lang="eng">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>
    </head>
    <body>
        <h1>Signup</h1>
        <form action="signup" method="post" novalidate>
            <div>
                <Label for="name">Name</label>
                <input id="name" type="text" name="name">
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_confirmation">Repeat Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation">
            </div>
            <button>Sign up</button>
        </form>
    </body>
</html>