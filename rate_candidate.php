<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $candidate_id = $_POST['candidate_id'];
    $hr_user_id = 1; // This should be replaced with the actual HR user's ID, possibly from session data.
    $meeting_time = $_POST['meeting_time'];

    // Get the ratings from the form
    $linguistic = isset($_POST['linguistic']) ? intval($_POST['linguistic']) : 0;
    $technical = isset($_POST['technical']) ? intval($_POST['technical']) : 0;
    $managerial = isset($_POST['managerial']) ? intval($_POST['managerial']) : 0;
    $transversal = isset($_POST['transversal']) ? intval($_POST['transversal']) : 0;

    // Check if the rating already exists
    $sql = "SELECT * FROM ratings WHERE candidate_id = ? AND hr_user_id = ? AND meeting_time = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $candidate_id, $hr_user_id, $meeting_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing rating
        $sql = "UPDATE ratings 
                SET linguistic = ?, technical = ?, managerial = ?, transversal = ? 
                WHERE candidate_id = ? AND hr_user_id = ? AND meeting_time = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiii", $linguistic, $technical, $managerial, $transversal, $candidate_id, $hr_user_id, $meeting_time);
    } else {
        // Insert new rating
        $sql = "INSERT INTO ratings (candidate_id, hr_user_id, meeting_time, linguistic, technical, managerial, transversal)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssss", $candidate_id, $hr_user_id, $meeting_time, $linguistic, $technical, $managerial, $transversal);
    }

    // Execute the query and check for errors
    if ($stmt->execute()) {
        echo "Le candidat a été noté avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de la note : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
