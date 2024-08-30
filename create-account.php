<?php
// Start a session
session_start();

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error variable
$error = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($checkEmail) {
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            $error = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
        } else {
            // Insert into the users table
            $sql = "INSERT INTO users (firstname, lastname, email, password, role, created_at) VALUES (?, ?, ?, ?, 'candidate', NOW())";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);

                if ($stmt->execute()) {
                    // Get the ID of the newly inserted user
                    $user_id = $conn->insert_id;

                    // Insert into the candidates table
                    $sql = "INSERT INTO candidates (id, phone, address, position_id ) VALUES (?, ?, ? ,1)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("iss", $user_id, $phone, $address);
                        
                        if ($stmt->execute()) {
                            // Redirect to login or profile page
                            header("Location: login.php");
                            exit;
                        } else {
                            $error = "Erreur lors de la création du profil candidat.";
                        }
                        $stmt->close();
                    } else {
                        $error = "Erreur lors de la préparation de la requête pour la table candidates.";
                    }
                } else {
                    $error = "Erreur lors de la création de l'utilisateur.";
                }
                $stmt->close();
            } else {
                $error = "Erreur lors de la préparation de la requête pour la table users.";
            }
        }
        $checkEmail->close();
    } else {
        $error = "Erreur lors de la préparation de la requête pour vérifier l'email.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte candidat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .signup-link, .home-link {
            text-align: center;
            margin-top: 20px;
        }

        .signup-link a, .home-link a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover, .home-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Créer un compte candidat</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST" action="">
            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" required>

            <label for="address">Adresse :</label>
            <input type="text" id="address" name="address" required>

            <button type="submit">Créer un compte</button>
        </form>
        <div class="signup-link">
            <p>Vous avez déjà un compte ? 
            <br>
            <a href="login.php">Se connecter</a></p>
        </div>
        <div class="home-link">
            <p><a href="index.php">Retour à l'accueil</a></p>
        </div>
    </div>
</body>
</html>
