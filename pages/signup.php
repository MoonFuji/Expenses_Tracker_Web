<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/login.css">
    <title>Sign up</title>
</head>

<body>
    <header>
        <h2>Family Expense Tracker</h2>
    </header>
    <h1>Sign up</h1>
    <div class="container">
        <form id="form" action="../utility/signup.inc.php" method="POST">
            <div class="form-control">
                <label for="name">Name</label>
                <input type="text" name="user-name" id="name" placeholder="Enter your Name..." />
            </div>
            <div class="form-control">
                <label for="pwd">Password<br />
                </label>
                <input type="password" id="pwd" name="user-pwd" placeholder="Enter your password..." />
            </div>
            <div class="form-control">
                <label for="pwd">Repeated Password<br />
                </label>
                <input type="password" id="pwd" name="user-pwd-repeated" placeholder="Repeat your password..." />
            </div>
            <button class="btn" type="submit">Sign up</button>
        </form>
    </div>



</body>

</html>