<!doctype html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/login.css">

    <title>log in</title>
</head>

<body>
    <header>
        <h2>Family Expense Tracker</h2>
    </header>
    <h1>Log in</h1>
    <div class="container">
        <form id="form" method="POST" action="../utility/login.inc.php">
    
            <div class="form-control">
                <label for="us-name">Name</label>
                <input type="text" name="user-name" id="us-name" placeholder="Enter your Name..." />
            </div>
            <div class="form-control">
                <label for="pwd">Password<br />
                </label>
                <input type="password" name="user-pwd" id="pwd" placeholder="Enter your password..." />
            </div>
            <button class="btn" type="submit">Login</button>
        </form>
    </div>


    
</body>
   
</html>