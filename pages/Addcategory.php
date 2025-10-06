<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_evaluation_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['evaluation_category'], $_POST['status'])) {
        $evaluation_category = $_POST['evaluation_category'];
        $status = $_POST['status'];

        $sql = "INSERT INTO evaluation_category_table (evaluation_category, status) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $evaluation_category, $status);

        if ($stmt->execute()) {
            // Redirect with success flag
            header("Location: category.php?status=success");
            exit();
        } else {
            // Redirect with error flag
            header("Location: category.php?status=error");
            exit();
        }

        $stmt->close();
    } else {
        header("Location: category.php?status=incomplete");
        exit();
    }
}

$conn->close();
?>
