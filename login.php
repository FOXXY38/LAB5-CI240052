<?php
session_start();
include 'db_connect.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT matric, password FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['matric'] = $row['matric'];
            header("Location: display_users.php"); 
            exit();
        } else {
            $error_message = "Invalid username or password, try <a href='login.php'>login again</a>.";
        }
    } else {
        $error_message = "Invalid username or password, try <a href='login.php'>login again</a>."; 
    }
    
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login</title>
</head>
<body>
    <h2>Login</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="matric">Matric:</label><br>
        <input type="text" id="matric" name="matric" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login"><br><br>
    </form>
    
    <?php 
    if ($error_message) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <p><a href="register.php">Register here if you have not.</a></p>
</body>
</html>

<?php
?>