<?php
// Include database connection
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $full_name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $food_item = $conn->real_escape_string(trim($_POST['food']));
    $quantity = intval($_POST['quantity']);
    $delivery_address = $conn->real_escape_string(trim($_POST['address']));
    
    // Prepare SQL statement
    $sql = "INSERT INTO orders (full_name, email, phone, food_item, quantity, delivery_address) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssis", $full_name, $email, $phone, $food_item, $quantity, $delivery_address);
        if ($stmt->execute()) {
            echo "Order placed successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Preparation failed: (" . $conn->errno . ") " . $conn->error;
    }
    $conn->close();
}
?>