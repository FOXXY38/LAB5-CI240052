<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lab 5a Q1</title>
</head>
<body>
    <?php
    $name = "MUHAMMAD FARHAN AQIL BIN MOHD JANI";
    $matric = "CI240052";
    $course = "BIC21203:PEMBANGUNAN WEB";
    $year = "TAHUN 2";
    $address = "RENGIT, JOHOR";
    ?>
    <table border="1">
        <tr><td>Name</td><td><?php echo $name; ?></td></tr>
        <tr><td>Matric Number</td><td><?php echo $matric; ?></td></tr>
        <tr><td>Course</td><td><?php echo $course; ?></td></tr>
        <tr><td>Year of Study</td><td><?php echo $year; ?></td></tr>
        <tr><td>Address</td><td><?php echo $address; ?></td></tr>
    </table>
</body>
</html>