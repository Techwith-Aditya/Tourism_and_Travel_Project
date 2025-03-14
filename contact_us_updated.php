<?php
    // Database credentials
    $db_hostname = "127.0.0.1";
    $db_username = "root";
    $db_password = "";
    $db_name = "tour";

    // Create connection
    $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);

    if (!$conn) 
    {
        die("Connection Failed: " . mysqli_connect_error());
    }

    // Check if form data is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // Get and sanitize input data
        $name = trim(htmlspecialchars($_POST['name']));
        $email = trim(htmlspecialchars($_POST['email']));
        $phone = trim(htmlspecialchars($_POST['phone']));
        $subject = trim(htmlspecialchars($_POST['subject']));
        $message = trim(htmlspecialchars($_POST['message']));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            die("Invalid email format.");
        }

        // Prevents SQL Injection
        $sql = "INSERT INTO contact (Name, Email, Phone, Subject, Message) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) 
        {
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $subject, $message);

            if (mysqli_stmt_execute($stmt)) 
            {
                echo "Thank you! We will contact you soon.";
            } 
            else 
            {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } 
        else 
        {
            echo "Error in preparing statement.";
        }
    } 
    else 
    {
        echo "Invalid request.";
    }

    // Close connection
    mysqli_close($conn);
?>
