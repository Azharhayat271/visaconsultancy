<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the values from the form fields
    $stickerNumber = $_POST['sticker_number'];
    $passportNumber = $_POST['passport_number'];
    $applicationStatus = $_POST['application_status'];
    $visaStatus = $_POST['visa_status'];
    $issueDate = $_POST['issue_date'];
    $expiryDate = $_POST['expiry_date'];
    $placeOfIssue = $_POST['place_of_issue'];

    // Database connection settings
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'visa';

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute an SQL query to insert the form data into the database
    $query = "INSERT INTO visadata (sticker_number, passport_number, application_status, visa_status, issue_date, expiry_date, place_of_issue) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $stickerNumber, $passportNumber, $applicationStatus, $visaStatus, $issueDate, $expiryDate, $placeOfIssue);

    if ($stmt->execute()) {
        header('Location: showvisa.html');
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case when the form hasn't been submitted
    echo "Form has not been submitted.";
}
?>
