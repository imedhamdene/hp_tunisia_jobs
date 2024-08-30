<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HP Tunisie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            background-color: #ddd;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #333;
            text-decoration: none;
            margin: 0 10px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #eee;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: relative; /* Use relative for smoother scrolling */
            bottom: 0;
            width: 100%;
        }

        .hp-logo {
            width: 150px;
            height: auto;
            margin: 0 auto;
        }

        section {
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .contact-info {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }

        .contact-info a {
            margin: 0 5px;
            color: white;
            text-decoration: none;
        }

        .contact-info i { /* Icon styling */
            font-size: 1.5em; /* Adjust icon size */
        }

        .auth-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .auth-buttons a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .auth-buttons a:hover {
            background-color: #555;
        }

        .description-block {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .description-block h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

    <header>
        <img src="HP_logo.png" alt="HP Logo" class="hp-logo">
        <h1>HP Tunisie</h1>
        <div class="contact-info">
            <a href="tel:+21655555555" title="Numéro de Téléphone"><i class="fas fa-phone"></i></a>
            <a href="mailto:hp.tunisie@example.com" title="Email"><i class="fas fa-envelope"></i></a>
            <a href="https://www.facebook.com/HPTunisie" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/HPTunisie" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/company/hp-tunisie" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </header>

    <nav>
        <a href="#accueil">Accueil</a>
        <a href="#a-propos">À propos de nous</a>
        <a href="#recrutement">Recrutement</a>
        <a href="#contact">Contact</a>
    </nav>

    <main>
        <section id="accueil">
            <h2>Bienvenue chez HP Tunisie</h2>
            <p>Chez HP Tunisie, nous sommes à la pointe de l'innovation technologique et du service client. Nous nous engageons à offrir des solutions informatiques de qualité supérieure qui répondent aux besoins uniques de nos clients en Tunisie et au-delà. Avec une présence locale forte et une équipe dédiée, nous visons à améliorer l'efficacité et la performance des entreprises grâce à nos produits et services de pointe.</p>
            <p>Nous proposons une large gamme de produits, allant des ordinateurs personnels aux imprimantes, ainsi que des solutions d'impression 3D. Chaque produit est conçu pour offrir une performance exceptionnelle et une durabilité à long terme. Notre équipe locale est prête à vous aider avec un support technique expert et des conseils personnalisés pour vous aider à tirer le meilleur parti de nos technologies.</p>
            <p>Nous croyons en l'innovation continue et en l'amélioration constante. En tant qu'entreprise citoyenne, nous investissons également dans des initiatives qui favorisent le développement durable et la responsabilité sociale. Explorez nos offres d'emploi pour rejoindre une équipe passionnée et engagée dans la création de solutions technologiques qui façonnent l'avenir.</p>
        </section>

        <section id="a-propos">
            <h2>À propos de nous</h2>
            Nous sommes une entreprise technologique née de la conviction que les entreprises devraient faire plus que simplement réaliser des bénéfices. Elles devraient rendre le monde meilleur.
            <br>
            Nos efforts en matière d'action climatique, de droits de l'homme et d'équité numérique prouvent que nous faisons tout notre possible pour y parvenir. Avec plus de 80 ans d'actions qui prouvent nos intentions, nous avons la confiance nécessaire pour imaginer un monde où l'innovation conduit à des contributions extraordinaires à l'humanité.
            <br>
            Et notre technologie - un portefeuille de produits et de services comprenant des systèmes personnels, des imprimantes et des solutions d'impression 3D - a été créée pour inspirer ce progrès significatif.
            <br>
            Nous savons que des idées réfléchies peuvent venir de n'importe qui, n'importe où, à n'importe quel moment. Et il suffit d'une seule pour changer le monde.
        </section>

        <section id="recrutement">
            <h2>Recrutement</h2>

            <h3>Offres d'emploi disponibles :</h3>
            <div id="position-descriptions">
                <?php
                // Fetch available positions with descriptions
                $conn = new mysqli('localhost', 'root', '', 'hp_tunisia_jobs');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT title, description FROM positions";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='description-block'>";
                        echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";
                        echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Aucune offre d'emploi disponible.</p>";
                }

                $conn->close();
                ?>
            </div>

            <div class="auth-buttons">
                <a href="create-account.php" class="button">Créer un compte</a>
                <a href="login.php" class="button">Se connecter</a>
            </div>
        </section>

        <section id="contact">
            <h2>Contact</h2>
            Contactez-nous ici.
        </section>
    </main>

    <footer>
        &copy; 2023 HP Tunisie
    </footer>

    <script>
        // Smooth scrolling for navigation links
        const navLinks = document.querySelectorAll('nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                targetElement.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>

    <!-- Font Awesome CDN (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</body>
</html>
