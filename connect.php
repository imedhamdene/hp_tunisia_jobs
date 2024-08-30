<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$email = $_POST['email'];
$password = $_POST['password'];

// Query to find the user
$sql = "SELECT id, role, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'hr') {
        header('Location: hr-dashboard.php');
    } elseif ($user['role'] == 'candidate') {
        header('Location: candidate-dashboard.php');
    }
} else {
    echo "Identifiants incorrects.";
}

$conn->close();
?>
