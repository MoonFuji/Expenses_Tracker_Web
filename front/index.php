<?php
session_start();
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

require_once "../utility/db_connection.php";
// require_once "../utility/get_balances.php";
// $user_balance = $_SESSION['user_balance'];
// $sub_users_balance = $_SESSION['sub_users_balance'];
// $global_balance = $user_balance + $sub_users_balance;


?>
<!doctype html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/style.css">

    <title>Familly Expense Tracker</title>
</head>

<body>
    <header>
        <h2>Family Expense Tracker</h2>
    </header>
    <h2>Welcome 
        <?php echo $username ; ?> !</h2>
    <div class="container">
        <h4>Your balance</h4>
        <h1 id="balance">0 DA</h1>
    
        <div class="inc-exp-container">
            <a href="expense.html">
                <h4>Revenue</h4>
                <p id="money-plus" class="money plus">+$0.00</p>
            </a>
            <a href="revenue.html">
                <h4>Expense</h4>
                <p id="money-minus" class="money minus">-$0.00</p>
            </a>
        </div>
        <h3>Add new Transaction</h3>
        <form id="form">
            <div class="form-control">
                <label for="revenueORexoense">Choose a transaction (Revenue / Expense)</label>
                <select id="revenueORexpense" name="option">
                    <option value="option1">Revenue</option>
                    <option value="option2">Expense</option>
                      
                </select>
            </div>
            <div class="form-control">
                <label for="text">Name</label>
                <input type="text" name="user-name" id="text" placeholder="Enter name of transaction..." />
            </div>
            <div class="form-control">
                <label for="categories">Category</label>
                <select id="categories" name="option">
                    <option value="option1">Food</option>
                    <option value="option2">Clothes</option>
                    <a href=""><option value="other">Add category</option></a>
                 </select>
            </div>
            <div class="form-control">
                <label for="date">Date <br/>
                </label>
                <input type="Date" name="date" id="date"/>
            </div>
            <div class="form-control">
                <label for="amount">Amount <br />
                </label>
                <input type="number" name="amount" id="amount" placeholder="Enter amount..." />
            </div>
            <button class="btn">Add transaction</button>
        </form>
    </div>
    <!-- end add new transation -->
    <section>
        <div class="sub-user">
            <a href="subUsers.html"><h3>Add or Edit Sub-user</h3></a>
            
            <form id="form">
                <div class="form-control">
                    <label for="text">Name of sub-user</label>
                    <input type="text" name="sub-user-name" id="text" placeholder="Enter name sub-user..." />
                </div>
                <div class="form-control">
                    <label for="password">Password of sub-user</label>
                    <input type="text" name="sub-user-pwd" id="password" placeholder="Enter password sub-user..." />
                </div>
                
                <button class="btn">Add transaction</button>
            </form>
        </div>
        <div class="add-category">
            <a href="categories.html"><h3>Add or Edit Category</h3></a>
            
            <form id="form">
                <div class="form-control">
                    <label for="text">Name of category</label>
                    <input type="text" name="category-name" id="text" placeholder="Enter name category..." />
                </div>
                <button class="btn">Add Category</button>
            </form>
        </div>
        
    </section>

    
</body>
   
</html>