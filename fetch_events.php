<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT m.meeting_time AS start, m.nature AS title
        FROM meetings m
        WHERE m.hr_user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$events = array();
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);

$conn->close();
?>
