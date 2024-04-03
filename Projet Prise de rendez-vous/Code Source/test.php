<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu Parent</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        /* Styles CSS personnalisés */
        body {
            font-family: Arial, sans-serif;
            background-color: #333; /* Fond noir */
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .menu {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px; /* Hauteur de l'en-tête */
        }
        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .classes {
            display: none;
            position: absolute;
            top: 180px; /* Écart par rapport à l'en-tête */
            left: 20px;
            background-color: #fff;
            color: #333;
            border: 1px solid #ccc;
            z-index: 1;
            padding: 20px;
        }
        .table-container {
            display: flex;
            justify-content: center;
        }
        table {
            width: 50%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .class-option:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="menu">
    <h1>Bonjour, [Nom du parent]</h1>
</div>
<div class="button-container">
    <button class="button" onclick="showClasses()">Prise de Rendez-vous</button>
    <button class="button">Rappel de Rendez-vous</button>
</div>
<div id="classes" class="classes">
    <p>Quelle classe souhaitez-vous choisir ?</p>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nom de la classe</th>
                </tr>
            </thead>
            <tbody>
                <?php

                session_start();
                if (!isset($_SESSION['id_parent'])) {
                    header('Location: connexion_parent.php'); // Rediriger l'utilisateur vers la page de connexion si la session n'est pas active
                    exit();
                }
                // Code PHP pour récupérer les classes depuis la base de données
                try {
                    $conn = new PDO("mysql:host=localhost;dbname=projet_rdv", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("SELECT * FROM classes");
                    $stmt->execute();

                    while ($row = $stmt->fetch()) {
                        echo '<tr class="class-option" onmouseover="showProfessors(' . $row['id_classe'] . ')">';
                        echo '<td>' . $row['nom_classe'] . '</td>';
                        echo '</tr>';
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
                $conn = null;
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function showClasses() {
        var classes = document.getElementById("classes");
        classes.style.display = "block";
    }
</script>
</body>
</html>
