<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu Professeur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <?php
    require_once('functions_prof.php');
    if (!isset($_SESSION['prof']['id_prof'])) {
        header('Location: connexion_prof.php'); // Rediriger l'utilisateur vers la page de connexion si la session n'est pas active
        exit();
    }
    // Code PHP pour récupérer les demandes de rendez-vous depuis la base de données
    $demandesDeRendezVous = getDemandesDeRendezVous(); // Assurez-vous d'avoir cette fonction définie

    // Séparez les rendez-vous en fonction de leur statut
    $demandesAcceptees = array();
    $demandesEnAttente = array();
    $demandesRefusees = array();

    if (!empty($demandesDeRendezVous)) {
        foreach ($demandesDeRendezVous as $demande) {
            if ($demande['statut'] === 'accepté') {
                $demandesAcceptees[] = $demande;
            } elseif ($demande['statut'] === 'En attente') {
                $demandesEnAttente[] = $demande;
            } elseif ($demande['statut'] === 'refusé') {
                $demandesRefusees[] = $demande;
            }
        }
    }
    ?>
    <style>
        /* Styles CSS personnalisés */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Fond gris clair */
            margin: 0;
            padding: 0;
        }
        .menu {
            background-color: #007bff; /* Bleu vif */
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .container {
            padding: 20px;
        }
        .inbox-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        .btn-container {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="menu">
    <h1>Bonjour, <?php echo $_SESSION['prof']['nom_prof']; ?></h1>
    <h1>Boîte de Réception Professeur</h1>
    <a href="session.php" class="btn btn-primary">Déconnexion</a>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h2>Rendez-vous Acceptés</h2>
            <?php
            if (!empty($demandesAcceptees)) {
                foreach ($demandesAcceptees as $demande) {
                    echo '<div class="inbox-item">';
                    echo "<p>Demande de rendez-vous de {$demande['nom_parent']} - {$demande['meeting_time']}</p>
                    <p>Commentaires : {$demande['commentaires']}</p>";
                    // Formulaire pour accepter le rendez-vous
                    echo '<div class="btn-container">';
                    echo '<form method="POST" action="traitement_rendezvous.php">';
                    echo '<input type="hidden" name="id_rdv" value="' . $demande['id_rdv'] . '">';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Aucun rendez-vous accepté.</p>";
            }
            ?>
        </div>
        <div class="col-md-4">
            <h2>Rendez-vous en Attente</h2>
            <?php
            if (!empty($demandesEnAttente)) {
                foreach ($demandesEnAttente as $demande) {
                    echo '<div class="inbox-item">';
                    echo "<p>Demande de rendez-vous de {$demande['nom_parent']} - {$demande['meeting_time']}</p>
                    <p>Commentaires : {$demande['commentaires']}</p>";
                    // Formulaire pour accepter le rendez-vous
                    echo '<div class="btn-container">';
                    echo '<form method="POST" action="traitement_rendezvous.php">';
                    echo '<input type="hidden" name="id_rdv" value="' . $demande['id_rdv'] . '">';
                    echo '<button type="submit" class="btn btn-success" name="accepter">Accepter</button>';
                    echo '<button type="submit" class="btn btn-danger" name="refuser">Refuser</button>';
                    echo '<button type="submit" class="btn btn-warning" name="en_attente">En Attente</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Aucun rendez-vous en attente.</p>";
            }
            ?>
        </div>
        <div class="col-md-4">
            <h2>Rendez-vous Refusés</h2>
            <?php
            if (!empty($demandesRefusees)) {
                foreach ($demandesRefusees as $demande) {
                    echo '<div class="inbox-item">';
                    echo "<p>Demande de rendez-vous de {$demande['nom_parent']} - {$demande['meeting_time']}</p>
                    <p>Commentaires : {$demande['commentaires']}</p>";
                    // Formulaire pour accepter le rendez-vous
                    echo '<div class="btn-container">';
                    echo '<form method="POST" action="traitement_rendezvous.php">';
                    echo '<input type="hidden" name="id_rdv" value="' . $demande['id_rdv'] . '">';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Aucun rendez-vous refusé.</p>";
            }
            ?>
        </div>
    </div>
</div>
<form method="POST" action="">
    <button type="submit" name="Historique" class="btn btn-primary">Historique</button>
</form>
<?php
if (isset($_POST['Historique'])) {
    $historique = getHistorique();
    if ($historique) {
        echo '<div class="container">';
        echo '<table class="table">';
        echo '<thead class="thead-dark">';
        echo '<tr><th>Nom du Prof</th><th>Nom du Parent</th><th>Date du Rendez-vous</th><th>Commentaires</th><th>Statuts</th><th>Action</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($historique as $rdv) {
            echo '<tr>';
            echo '<td>' . $rdv['nom_prof'] . '</td>';
            echo '<td>' . $rdv['nom_parent'] . '</td>';
            echo '<td>' . $rdv['meeting_time'] . '</td>';
            echo '<td>' . $rdv['commentaires'] . '</td>';
            echo '<td>' . $rdv['statut'] . '</td>';
            echo '<td>';
            echo '<form action="traitement_prise_rdv.php" method="post">';
            echo '<input name="id_prof" type="hidden" value="' . $rdv['nom_prof'] . '" />';
            echo '<textarea name="commentaires" rows="4" placeholder="Récapitulatif du Rendez-vous" required></textarea>';
            echo '<button type="submit" name="saverdv" class="btn btn-primary">Envoyer</button>';
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
