<?php
// Start of your PHP file
$conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['candidate_id'])) {
    $candidate_id = $_GET['candidate_id'];

    $sql = "SELECT u.firstname, u.lastname, u.email, c.phone, c.address, c.profile_picture, c.cv_path, c.motivation_letter_path, p.title
            FROM users u
            JOIN candidates c ON u.id = c.id
            JOIN positions p ON c.position_id = p.id
            WHERE u.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $candidate_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $candidate = $result->fetch_assoc();

    if ($candidate) {
        echo "<h2>" . htmlspecialchars($candidate['firstname']) . " " . htmlspecialchars($candidate['lastname']) . "</h2>";
        echo "<p>Email: " . htmlspecialchars($candidate['email']) . "</p>";
        echo "<p>Téléphone: " . htmlspecialchars($candidate['phone']) . "</p>";
        echo "<p>Adresse: " . htmlspecialchars($candidate['address']) . "</p>";
        echo "<p>Poste: " . htmlspecialchars($candidate['title']) . "</p>";
        if ($candidate['profile_picture']) {
            echo "<img src='" . htmlspecialchars($candidate['profile_picture']) . "' alt='Photo de profil' style='max-width: 150px; display: block; margin: 10px 0;'>";
        }
        echo "<p><a href='" . htmlspecialchars($candidate['cv_path']) . "'>Voir le CV</a></p>";
        echo "<p><a href='" . htmlspecialchars($candidate['motivation_letter_path']) . "'>Voir la lettre de motivation</a></p>";
    } else {
        echo "<p>Informations du candidat non trouvées.</p>";
    }

    $conn->close();
    exit(); // Stop further processing to avoid sending the full HTML
}

// Continue with your full page HTML and PHP below...
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord RH - HP Tunisie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            display: block;
            text-align: center;
            cursor: pointer;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .sidebar a.logout {
            background-color: #ff4d4d;
        }

        .sidebar a.logout:hover {
            background-color: #ff1a1a;
        }

        .filters {
            margin-bottom: 20px;
            background-color: #444;
            padding: 10px;
            border-radius: 5px;
        }

        .filters form {
            display: flex;
            flex-direction: column;
        }

        .filters label {
            margin-bottom: 5px;
            color: #ddd;
        }

        .filters select, .filters input, .filters button {
            margin-bottom: 10px;
        }

        .filters select, .filters input {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #555;
        }

        .filters button {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filters button:hover {
            background-color: #555;
        }

        .search-bar {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            background-color: #444;
            padding: 10px;
            border-radius: 5px;
        }

        .search-bar label {
            color: #ddd;
            margin-bottom: 5px;
        }

        .search-bar input {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #555;
            margin-bottom: 10px;
        }

        .search-bar button {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #555;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            position: relative;
        }

        .section {
            display: none;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .section.active {
            display: block;
        }

        h1 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        button {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            max-height: 80%;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            overflow: auto;
            display: none;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 999;
            display: none;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-header button {
            background-color: red;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-header button:hover {
            background-color: darkred;
        }
        .calendar-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #calendar {
            width: 100%;
            height: 500px; /* Adjust height as needed */
        }
        /************************************************************************************* */
        
        .rating-section, .meeting-section, .candidate-details{
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .rating-section input, .meeting-section input, .meeting-section select {
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .rating-section button, .meeting-section button {
            margin-top: 10px;
            width: 30%;
        }

        /****************************** */
        

.rating-section {
    margin-top: 20px;
}

.rating-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.rating-item {
    width: calc(50% - 20px); /* Two items per row with gap adjustment */
    box-sizing: border-box;
    text-align: center;
}

.rating-item label {
    display: block;
    margin-top: 10px;
    color: #333;
}

.rating-item input {
    width: 40%;
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ddd;
    margin-top: 5px;
}

.progress-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 8px solid #ddd;
    position: relative;
    margin: 0 auto;
    background: conic-gradient(#4caf50 calc(var(--percentage) * 1%), #ddd 0);
}

.progress-circle::before {
    content: '0%';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 18px;
    color: #333;
    font-weight: bold;
}

.progress-circle[data-percentage]::before {
    content: attr(data-percentage) '%';
}



        
/************************************************************** */
    </style>





    <script>
        function showSection(sectionId) {
            var sections = document.getElementsByClassName('section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }
            document.getElementById(sectionId).classList.add('active');
        }

        function openModal(candidateId) {
            console.log(candidateId);  // Check if the correct ID is passed
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'hr-dashboard.php?candidate_id=' + candidateId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('candidate-details-content').innerHTML = xhr.responseText;
                    document.getElementById('modal-overlay').style.display = 'block';
                    document.getElementById('candidate-details-modal').style.display = 'block';
                    
                    
                }
            };
            xhr.send();
        }

        function closeModal() {
            document.getElementById('modal-overlay').style.display = 'none';
            document.getElementById('candidate-details-modal').style.display = 'none';
        }

        function searchCandidate() {
            var query = document.getElementById('search-query').value;
            window.location.href = 'hr-dashboard.php?search=' + encodeURIComponent(query);
        }

        // Set default active section
        window.onload = function() {
            showSection('candidates-section');
        };
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>Tableau de bord RH</h2>
        <div class="search-bar">
            <label for="search-query">Rechercher par nom :</label>
            <input type="text" id="search-query" placeholder="Nom du candidat...">
            <button onclick="searchCandidate()">Rechercher</button>
        </div>
        <div class="filters">
            <form method="GET" action="hr-dashboard.php">
                <label for="position-filter">Filtrer par poste :</label>
                <select id="position-filter" name="position_id">
                    <option value="">Tous les postes</option>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

                    // Fetch available positions
                    $sql = "SELECT id, title FROM positions";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>

                <label for="sort-by">Trier par :</label>
                <select id="sort-by" name="sort_by">
                    <option value="lastname">Nom</option>
                    <option value="firstname">Prenom</option>
                </select>

                <button type="submit">Appliquer</button>
            </form>
        </div>
        <a href="login.php" class="logout">Déconnexion</a>
    </div>
    <div class="main-content">
        <!-- Candidates Section -->
        <div id="candidates-section" class="section active">
            <h1>Tous les Candidats</h1>

            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Poste</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connect to database
                    $conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $position_id = isset($_GET['position_id']) ? $_GET['position_id'] : '';
                    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'lastname';
                    $search_query = isset($_GET['search']) ? $_GET['search'] : '';

                    $sql = "SELECT u.id, u.firstname, u.lastname, u.email, p.title
                            FROM users u
                            LEFT JOIN candidates c ON u.id = c.id
                            LEFT JOIN positions p ON c.position_id = p.id
                            WHERE u.role = 'candidate'";

                    $params = [];
                    $types = '';

                    if (!empty($position_id)) {
                        $sql .= " AND p.id = ?";
                        $types .= 'i';
                        $params[] = $position_id;
                    }

                    if (!empty($search_query)) {
                        $sql .= " AND (u.firstname LIKE ? OR u.lastname LIKE ?)";
                        $types .= 'ss';
                        $search_query_param = '%' . $search_query . '%';
                        $params[] = $search_query_param;
                        $params[] = $search_query_param;
                    }

                    $sql .= " ORDER BY " . $sort_by;

                    $stmt = $conn->prepare($sql);

                    if (!empty($types)) {
                        $stmt->bind_param($types, ...$params);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["lastname"] . "</td>
                                    <td>" . $row["firstname"] . "</td>
                                    <td>" . $row["email"] . "</td>
                                    <td>" . $row["title"] . "</td>
                                    <td><button onclick=\"openModal(" . $row["id"] . ")\">Voir Détails</button></td>
                                    
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Aucun candidat trouvé.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="calendar-container">
            <h2>Calendrier des Réunions</h2>
            <div id="calendar"></div>
        </div>

        <!-- Modal Overlay -->
        <div id="modal-overlay" class="modal-overlay" onclick="closeModal()"></div>

        <!-- Candidate Details Modal -->
        <div id="candidate-details-modal" class="modal">
            <div class="modal-header">
                <h2>Détails du Candidat</h2>
                <button onclick="closeModal()">X</button>
            </div>
            <div class ="candidate-details" id="candidate-details-content">
                <!-- Content for candidate details goes here -->
                <?php
                if (isset($_GET['candidate_id'])) {
                    $candidate_id = $_GET['candidate_id'];

                    $conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

                    $sql = "SELECT u.firstname, u.lastname, u.email, c.phone, c.address, c.profile_picture, c.cv_path, c.motivation_letter_path, p.title
                            FROM users u
                            JOIN candidates c ON u.id = c.id
                            JOIN positions p ON c.position_id = p.id
                            WHERE u.id = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $candidate_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $candidate = $result->fetch_assoc();

                    if ($candidate) {
                        echo "<h2>" . htmlspecialchars($candidate['firstname']) . " " . htmlspecialchars($candidate['lastname']) . "</h2>";
                        echo "<p>Email: " . htmlspecialchars($candidate['email']) . "</p>";
                        echo "<p>Téléphone: " . htmlspecialchars($candidate['phone']) . "</p>";
                        echo "<p>Adresse: " . htmlspecialchars($candidate['address']) . "</p>";
                        echo "<p>Poste: " . htmlspecialchars($candidate['title']) . "</p>";
                        if ($candidate['profile_picture']) {
                            echo "<img src='" . htmlspecialchars($candidate['profile_picture']) . "' alt='Photo de profil' style='max-width: 150px; display: block; margin: 10px 0;'>";
                        }
                        echo "<p><a href='" . htmlspecialchars($candidate['cv_path']) . "'>Voir le CV</a></p>";
                        echo "<p><a href='" . htmlspecialchars($candidate['motivation_letter_path']) . "'>Voir la lettre de motivation</a></p>";
                        
                    } else {
                        echo "<p>Informations du candidat non trouvées.</p>";
                    }

                    $conn->close();
                }
                ?>
            </div>                     
            <div class="rating-section">
                <h2>Noter le Candidat</h2>
                <div class="rating-grid">
                    <div class="rating-item">
                        <div class="progress-circle" data-percentage="0"></div>
                        <label for="linguistic">Linguistique :</label>
                        <input type="number" name="linguistic" min="0" max="10">
                    </div>
                    <div class="rating-item">
                        <div class="progress-circle" data-percentage="0"></div>
                        <label for="technical">Technique :</label>
                        <input type="number" name="technical" min="0" max="10">
                    </div>
                    <div class="rating-item">
                        <div class="progress-circle" data-percentage="0"></div>
                        <label for="managerial">Managerial :</label>
                        <input type="number" name="managerial" min="0" max="10">
                    </div>
                    <div class="rating-item">
                        <div class="progress-circle" data-percentage="0"></div>
                        <label for="transversal">Transversal :</label>
                        <input type="number" name="transversal" min="0" max="10">
                    </div>
                </div>
                <form method="POST" action="rate_candidate.php">
                    <input type="hidden" name="candidate_id" value="<?php echo isset($candidate_id) ? htmlspecialchars($candidate_id) : ''; ?>">
                    <button type="submit">Noter</button>
                </form>
            </div>




            <div class="meeting-section">
                <h2>Organiser une Rencontre</h2>
                
                <form method="POST" action="schedule_meeting.php">
                    <input type="hidden" name="candidate_id" value="<?php echo isset($candidate_id) ? htmlspecialchars($candidate_id) : ''; ?>">
                    <label for="meeting_time">Date et Heure :</label>
                    <input type="datetime-local" name="meeting_time"><br>
                    <label for="meeting_type">Type de Rencontre :</label>
                    <select name="meeting_type">
                        <option value="in_person">En personne</option>
                        <option value="online">En ligne</option>
                    </select><br>
                    <button type="submit">Organiser la Rencontre</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(info, successCallback, failureCallback) {
                    fetch('fetch_events.php')
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                }
            });

            calendar.render();
        });
    </script>

    <script>
        document.querySelectorAll('.progress-circle').forEach(circle => {
            const percentage = circle.getAttribute('data-percentage');
            circle.style.setProperty('--percentage', percentage);
        });
    </script>

</body>
</html>
