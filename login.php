<?php
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'visa';

// Initialize variables for the entered email and password
$enteredEmail = '';
$enteredPassword = '';

// Initialize an error message variable
$errorMessage = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered email and password from the form
    $enteredEmail = $_POST['email'];
    $enteredPassword = $_POST['password'];

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL query to retrieve the user's password based on the entered email
    $query = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $enteredEmail);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();

    // Verify the entered password against the stored password (in plain text)
    if ($enteredPassword === $storedPassword) {
        // Redirect to the admin page (change 'adminpage.html' to your actual admin page)
        header('Location: adminpage.html');
        exit();
    } else {
        $errorMessage = 'Invalid email or password. Please try again.';
        echo "<script>alert('$errorMessage'); window.location='login.html';</script>";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
