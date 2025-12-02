<?php
include 'session_check.php'; 
include 'db_connect.php'; 

$matric = $_GET['matric'] ?? '';
$error_message = '';
$user_data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    if (empty($matric) || empty($name) || empty($role)) {
        $error_message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, role = ? WHERE matric = ?");
        $stmt->bind_param("sss", $name, $role, $matric);

        if ($stmt->execute()) {
            $message = "User with Matric $matric updated successfully.";
            header("Location: display_users.php?message=" . urlencode($message)); 
            exit();
        } else {
            $error_message = "Error updating user: " . $stmt->error;
        }
        $stmt->close();
    }

} 

if ($matric) {
    $stmt = $conn->prepare("SELECT matric, name, role FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user_data = $result->fetch_assoc();
    } else {
        $error_message = "User not found.";
    }
    $stmt->close();
} else {
    $error_message = "No matric number provided for update.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2> <?php 
    if ($error_message) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    
    if ($user_data): 
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="matric">Matric:</label><br>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($user_data['matric']); ?>" readonly><br>
        <input type="hidden" name="matric" value="<?php echo htmlspecialchars($user_data['matric']); ?>"> 
        
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required><br>
        
        <label for="role">Access Level:</label><br> <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user_data['role']); ?>" required><br><br>
        
        <input type="submit" value="Update">
        <a href="display_users.php">Cancel</a> </form>
    <?php endif; ?>

</body>
</html>