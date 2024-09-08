<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sample_db";

// Create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $image = $_FILES['image']['name'];

    // Directory where the image will be uploaded
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Check if the image is valid and move it to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Prepare the SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $image);

        // Execute the statement and check if it's successful
        if ($stmt->execute()) {
            header("Location: details.php?id=" . $conn->insert_id); // Redirect to details page
            exit(); // Terminate script execution after redirection
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>
