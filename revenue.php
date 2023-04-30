    <?php
    // // 
    // session_start();

    // // Include your database connection file here
    // require_once "db_connection.php";

    // // Check if the user is logged in
    // if (!isset($_SESSION['user_id'])) {
    //     header("Location: login.php");
    //     exit;
    // }

    // $revenue_id = isset($_GET['revenue_id']) ? intval($_GET['revenue_id']) : 0;

    // // Display the revenue form to the user
    // $description = "";
    // $amount = "";
    // if ($revenue_id != 0) {
    //     // Get the record from the database
    //     $user_id = $_SESSION['user_id'];
    //     $stmt = $conn->prepare("SELECT description, amount FROM Revenue WHERE revenue_id =$revenue_id AND user_id = ?");
    //     $stmt->bind_param("i", $user_id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     // Check if the record exists and fetch the data
    //     if ($result->num_rows > 0) {
    //         $row = $result->fetch_assoc();
    //         $description = $row['description'];
    //         $amount = $row['amount'];
    //     } else {
    //         // If the record does not exist, redirect to the revenue list page
    //         header("Location: ./index.php");
    //         exit;
    //     }
    //     $stmt->close();
    // }

    // 
    ?>
    <!-- 

        // <!DOCTYPE html>
        // <html>
    
        // <head>
        //     <title><?php echo $revenue_id == 0 ? "Add" : "Edit"; ?> Revenue</title>
        // </head>
    
        // <body>
        //     <h1><?php echo $revenue_id == 0 ? "Add" : "Edit"; ?> Revenue</h1>
        //     <?php
                //     // Display errors, if any
                //     if (!empty($errors)) {
                //         echo "<ul>";
                //         foreach ($errors as $error) {
                //             echo "<li>$error</li>";
                //         }
                //         echo "</ul>";
                //     }
                //     
                ?>
        //     <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        //         <input type="hidden" name="revenue_id" value="<?php echo $revenue_id; ?>">
        //         <label for="description">Description:</label>
        //         <input type="text" name="description" value="<?php echo $description; ?>"><br>
        //         <label for="amount">Amount:</label>
        //         <input type="text" name="amount" value="<?php echo $amount; ?>"><br>
        //         <?php if ($revenue_id != 0) { ?>
        //             <input type="submit" name="submit" value="update">
        //             <input type="submit" name="delete" value="delete">
        //         <?php } else { ?>
        //             <input type="submit" name="submit" value="add">
        //         <?php } ?>
        //     </form>
        // </body>
    
        // </html>
     -->

    // <?php
        // // Check if the form has been submitted
        // if (isset($_POST['submit'])) {
        //     // Validate the data
        //     $errors = array();
        //     $description = trim($_POST['description']);
        //     $amount = trim($_POST['amount']);
        //     if (empty($description)) {
        //         $errors[] = "Description is required.";
        //     }
        //     if (!is_numeric($amount) || $amount <= 0) {
        //         $errors[] = "Amount must be a positive number.";
        //     } // If there are no errors, insert/update/delete the record if (empty($errors)) { $user_id=$_SESSION['user_id']; $amount=number_format($amount, 2); if (isset($_POST['add'])) { // Insert the record $stmt=$conn->prepare("INSERT INTO Revenue (user_id, description, amount) VALUES (?, ?, ?)");
        //     $stmt->bind_param("isd", $user_id, $description, $amount);
        //     $stmt->execute();
        //     $stmt->close();
        // } else {
        //     // Update or delete the record
        //     $stmt = $conn->prepare("SELECT user_id FROM Revenue WHERE revenue_id = ?");
        //     $stmt->bind_param("i", $revenue_id);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
        //     $stmt->close();
        //     if ($result->num_rows > 0) {
        //         $row = $result->fetch_assoc();
        //         if ($row['user_id'] == $user_id) {
        //             if (isset($_POST['delete'])) {
        //                 // Delete the record
        //                 $stmt = $conn->prepare("DELETE FROM Revenue WHERE revenue_id = ?");
        //                 $stmt->bind_param("i", $revenue_id);
        //                 $stmt->execute();
        //                 $stmt->close();
        //             } else {
        //                 // Update the record
        //                 $stmt = $conn->prepare("UPDATE Revenue SET description = ?, amount = ? WHERE revenue_id = ?");
        //                 $stmt->bind_param("sdi", $description, $amount, $revenue_id);
        //                 $stmt->execute();
        //                 $stmt->close();
        //             }
        //         }
        //     }
        // }



        // // Display the revenue form to the user
        // $description = "";
        // $amount = "";
        // if ($revenue_id != 0) {
        //     // Get the record from the database
        //     $user_id = $_SESSION['user_id'];
        //     $stmt = $conn->prepare("SELECT description, amount FROM Revenue WHERE revenue_id =$revenue_id AND user_id = ?");
        //     $stmt->bind_param("i", $user_id);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
        //     // Check if the record exists and fetch the data
        //     if ($result->num_rows > 0) {
        //         $row = $result->fetch_assoc();
        //         $description = $row['description'];
        //         $amount = $row['amount'];
        //     } else {
        //         // If the record does not exist, redirect to the revenue list page
        //         header("Location: ./index.php");
        //         exit;
        //     }
        //     $stmt->close();
        // }

        ?>