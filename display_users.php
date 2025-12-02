<?php
include 'session_check.php'; 
include 'db_connect.php'; 

if (isset($_GET['delete_matric'])) {
    $matric_to_delete = $_GET['delete_matric'];
    $stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric_to_delete);
    if ($stmt->execute()) {
        $message = "User with Matric $matric_to_delete deleted successfully.";
    } else {
        $message = "Error deleting user: " . $stmt->error;
    }
    $stmt->close();
    header("Location: display_users.php?message=" . urlencode($message));
    exit();
}

$sql = "SELECT matric, name, role FROM users ORDER BY matric ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Management (CRUD)</title>
    <style>
        table {
            border-collapse: collapse;
            font-size: 1.2em;
        }
        th, td {
            border: 1px solid black;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .action-link {
            padding: 0 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>User List (CRUD)</h2>
    <?php 
        if (isset($_GET['message'])) {
            echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
        } 
    ?>
    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th> </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["matric"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["role"] . "</td>";
                echo "<td>";
                echo "<a class='action-link' href='update_user.php?matric=" . $row["matric"] . "'>Update</a>";
                echo "<a class='action-link' href='display_users.php?delete_matric=" . $row["matric"] . 
                     "' onclick='return confirm(\"Are you sure you want to delete user: " . $row["name"] . "?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
    </table>
    <p><a href="logout.php">Logout</a></p>

<?php
$conn->close();
?>
</body>
</html>