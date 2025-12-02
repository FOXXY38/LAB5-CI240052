<?php
include 'db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($matric) || empty($name) || empty($password) || empty($role)) {
        $message = "All fields are required.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $matric, $name, $hashed_password, $role);

        if ($stmt->execute()) {
            $message = "New user registered successfully! You can now <a href='login.php'>log in</a>.";
        } else {
            if ($conn->errno == 1062) {
                 $message = "Error: Matric number already exists. Please use a different one.";
            } else {
                 $message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <?php echo $message; ?> 
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="matric">Matric:</label><br>
        <input type="text" id="matric" name="matric" maxlength="10" required><br>
        
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" maxlength="100" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" maxlength="255" required><br>
        
        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="">Please select</option>
            <option value="student">student</option>
            <option value="lecturer">lecturer</option>
        </select><br><br>
        
        <input type="submit" value="Submit">
    </form>
    <p>Already have an account? <a href="login.php">Login here.</a></p>
</body>
</html>