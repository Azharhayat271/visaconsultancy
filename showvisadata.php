<?php
// Replace these with your own database connection details
$host = "localhost";
$username = "root";
$password = "";
$database = "visa";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    // Check if the "Delete" button is clicked for a specific record
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM visadata WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT * FROM visadata"; // Make sure to use the correct table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Sticker Number</th><th>Passport Number</th><th>Application Status</th><th>Visa Status</th><th>Issue Date</th><th>Expiry Date</th><th>Place of Issue</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["sticker_number"] . "</td>";
        echo "<td>" . $row["passport_number"] . "</td>";
        echo "<td>" . $row["application_status"] . "</td>";
        echo "<td>" . $row["visa_status"] . "</td>";
        echo "<td>" . $row["issue_date"] . "</td>";
        echo "<td>" . $row["expiry_date"] . "</td>";
        echo "<td>" . $row["place_of_issue"] . "</td>";
        echo "<td><a href='?delete_id=" . $row["id"] . "'>Delete</a></td>"; // Add a delete link
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>
