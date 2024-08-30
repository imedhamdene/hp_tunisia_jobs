
<?php

// Start of schedule_meeting.php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the candidate ID, meeting time, and meeting type from the form submission
    $candidate_id = $_POST['candidate_id'];
    $meeting_time = $_POST['meeting_time'];
    $meeting_type = $_POST['meeting_type'];

    // Get the HR user ID (assuming the HR user is logged in and their ID is stored in a session)
    session_start();
    $hr_user_id = $_SESSION['user_id'];  // Ensure the session stores the HR user's ID upon login

    // Debugging: Echo the variables to ensure they are correct
    echo "Candidate ID: $candidate_id<br>";
    echo "Meeting Time: $meeting_time<br>";
    echo "Meeting Type: $meeting_type<br>";
    echo "HR User ID: $hr_user_id<br>";

    // Validate if the candidate exists in the users table
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ? AND role = 'candidate'");
    $stmt->bind_param("i", $candidate_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If candidate exists, proceed to schedule the meeting
        $stmt->close();

        $sql = "INSERT INTO meetings (candidate_id, hr_user_id, meeting_time) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $candidate_id, $hr_user_id, $meeting_time);

        // Check if the insert operation was successful
        if ($stmt->execute()) {
            echo "Meeting successfully scheduled!";
            // Redirect back to the HR dashboard with a success message
            // header("Location: hr-dashboard.php?success=meeting_scheduled");
        } else {
            echo "Failed to schedule meeting.";
            // header("Location: hr-dashboard.php?error=meeting_schedule_failed");
        }

        $stmt->close();
    } else {
        // Candidate does not exist, return an error
        echo "Candidate not found!";
        // header("Location: hr-dashboard.php?error=candidate_not_found");
    }
}

// Close the database connection
$conn->close();
