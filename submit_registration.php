<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$host = 'IP';
$db_user = 'USER'; 
$db_pass = 'PW'; 
$db_name = 'UNAME';

// Connect to MySQL database
$con = mysqli_connect($host, $db_user, $db_pass, $db_name);

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Honeypot check - if this field is filled, it's a bot
    if (!empty($_POST['honeypot'])) {
        die("Spam detected. Submission rejected.");
    }

    // Sanitize the input data
    $FirstName = mysqli_real_escape_string($con, $_POST['FirstName']);

    // Prepare an SQL statement for inserting the data
    $stmt = $con->prepare("INSERT INTO Registration (FirstName, LastName, DateofBirth, PhoneNumber, Email, Address, City, State, Zip, BacDegree, YearofBac, TypeofBac, Licence) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters to the SQL query
    $stmt->bind_param("sssssssssssss", $FirstName, $LastName, $DateofBirth, $PhoneNumber, $Email, $Address, $City, $State, $Zip, $BacDegree, $YearofBac, $TypeofBac, $Licence);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the thank you page after successful submission
        header("Location: thankyou.html");
        exit();
    } else {
        // Display an error message if the insertion fails
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
mysqli_close($con);
?>
