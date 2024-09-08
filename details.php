<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6f9a37, #4CAF50);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .details-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            font-size: 24px;
            color: #6f9a37;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #ccc;
            margin: 10px 0;
        }

        .user-image {
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .user-image:hover {
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="details-container">
        <h2>User Details</h2>
        <?php
        // Database connection and data fetching code
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sample_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $stmt = $conn->prepare("SELECT name, email, image FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($name, $email, $image);

            if ($stmt->fetch()) {
                echo "<p>Name: " . $name . "</p>";
                echo "<p>Email: " . $email . "</p>";
                echo "<img src='uploads/" . $image . "' alt='User Image' class='user-image' width='150'>";
            } else {
                echo "<p>No record found.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Invalid ID.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
