<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
</head>
<body>
    <h2>User Information Search</h2>
    <form method="post" action="">
        <label for="pppu">Enter Username:</label>
        <input type="text" name="pppu" id="pppu" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = ""; // Leave empty if no password is set
    $database = "website"; // Replace with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize the input to prevent SQL injection
        $usernameToSearch = mysqli_real_escape_string($conn, $_POST['pppu']);

        // Using prepared statement to prevent SQL injection
        $sql = "SELECT ip, mac, id, router FROM ppp_acc WHERE pppu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usernameToSearch);

        // Execute the query
        $stmt->execute();

        // Bind the results
        $stmt->bind_result($ipAddress, $macAddress, $userId, $router);

        // Fetch the results
        if ($stmt->fetch()) {
            // Display the information
            echo "<h3>Search Results:</h3>";
            echo "<p>IP Address: " . $ipAddress . "</p>";
            echo "<p>MAC Address: " . $macAddress . "</p>";
            echo "<p>User ID: " . $userId . "</p>";
            echo "<p>Router: " . $router . "</p>";
        } else {
            echo "<p>No information found for the provided username.</p>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>
