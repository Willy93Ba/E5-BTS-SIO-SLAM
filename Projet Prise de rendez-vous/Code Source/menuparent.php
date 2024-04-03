<tbody>
                <?php
                require_once('functions_parent.php');
                if (!isset($_SESSION['parent']['id_parent'])) {
                    header('Location: connexion_parent.php'); // Rediriger l'utilisateur vers la page de connexion si la session n'est pas active
                    exit();
                }
                // Code PHP pour récupérer les classes depuis la base de données

                ?>
            </tbody>
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
            background-color: beige;
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
<h1>Bonjour, <?php echo $_SESSION['parent']['nom_parent']; ?></h1>
<a href="session.php">Déconnexion</a>
</div>
<div class="button-container">
    <form action="" method="post">
    <button class="submit" name="prise">Prise de Rendez-vous</button>
    <button class="submit" name="statut">Statut de la demande de rendez-vous</button>
</form> <?php
if (isset($_POST['statut'])) {
   $demandes = getStatutDemandesParent($_SESSION['parent']['id_parent']); // Assurez-vous d'avoir une fonction getStatutDemandesParent pour récupérer les demandes du parent

    if ($demandes) {
        echo '<div class="table-container">';
        echo '<table>';
        echo '<thead><tr><th>Nom Professeur</th><th>Calendrier</th><th>Statut</th><th>Motif du Refus</th></tr></thead>';
        echo '<tbody>';
        foreach ($demandes as $demande) {
            echo '<tr>';
            echo '<td>' . $demande['nom_prof'] . '</td>';
            echo '<td>' . $demande['meeting_time'] . '</td>';
            echo '<td>' . $demande['statut'] . '</td>';
            echo '<td>' . $demande['commentaires'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'Aucune demande de rendez-vous trouvée.';
    }
}
?>

    </form>
</div>
<?php
if (isset($_POST['prise'])) {
    $tab_prof = getProfParent();
    if ($tab_prof) {
        echo '<div class="table-container">';
        echo '<table>';
        echo '<thead><tr><th>Nom</th><th>Prénom</th><th>Calendrier</th></tr></thead>';
        echo '<tbody>';
        foreach ($tab_prof as $prof) {
            echo '<tr>';
            echo '<td>' . $prof['nom_prof'] . '</td>';
            echo '<td>' . $prof['prenom_prof'] . '</td>';
            echo '<td>';
            echo '<form action="traitement_prise_rdv.php" method="post">';
            echo '<input name="id_prof" type="hidden" value="' . $prof['id_prof'] . '" />';
            echo '<input type="datetime-local" id="meeting-time-' . $prof['id_prof'] . '" name="meeting_time" min="2023-01-01T00:00" max="2024-12-31T00:00" />';
            echo '<textarea name="commentaires" rows="4" placeholder="Motif du rendez-vous" required></textarea>';
            echo '<button type="submit" name="saverdv">Prendre RDV</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'Aucun professeur trouvé.';
    }
}
?>
</body>
</html>
