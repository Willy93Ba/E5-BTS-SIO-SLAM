<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu Professeur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        /* Styles CSS personnalisés */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Fond gris clair */
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .menu {
            background-color: #007bff; /* Bleu vif */
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
            background-color: #ff5722; /* Couleur orange */
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #f44336; /* Rouge foncé au survol */
        }
        .inbox {
            display: none;
            position: absolute;
            top: 180px; /* Écart par rapport à l'en-tête */
            left: 20px;
            background-color: #fff;
            color: #333;
            border: 1px solid #ccc;
            z-index: 1;
            padding: 20px;
            width: 50%;
        }
        .inbox h2 {
            margin-bottom: 20px;
        }
        .inbox-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .reminder {
            display: none;
            position: absolute;
            top: 180px; /* Écart par rapport à l'en-tête */
            left: 20px;
            background-color: #fff;
            color: #333;
            border: 1px solid #ccc;
            z-index: 1;
            padding: 20px;
            width: 50%;
        }
        .reminder h2 {
            margin-bottom: 20px;
        }
        .reminder-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .history {
            display: none;
            position: absolute;
            top: 180px; /* Écart par rapport à l'en-tête */
            left: 20px;
            background-color: #fff;
            color: #333;
            border: 1px solid #ccc;
            z-index: 1;
            padding: 20px;
            width: 50%;
        }
        .history h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php
session_start();
?>
<div class="menu">
    <h1>Boîte de Réception Professeur</h1>
</div>
<div class="button-container">
    <button class="button" onclick="showInbox()">Boîte de Réception</button>
    <button class="button" onclick="showReminders()">Rappel</button>
    <button class="button" onclick="showHistory()">Historique des Tickets</button>
</div>
<div id="inbox" class="inbox">
    <h2>Boîte de Réception</h2>
    <!-- Affichage des demandes de rendez-vous des parents -->
    <div class="inbox-item">
        <p>Demande de rendez-vous de [Nom du Parent] - [Date et Heure]</p>
        <button class="btn btn-primary">Accepter</button>
        <button class="btn btn-danger">Refuser</button>
        <button class="btn btn-warning">Mettre en Attente</button>
    </div>
    <!-- Vous pouvez ajouter plus d'éléments de boîte de réception ici -->
</div>
<div id="reminder" class="reminder">
    <h2>Rappel des Rendez-vous</h2>
    <!-- Affichage des rendez-vous à venir avec les détails -->
    <div class="reminder-item">
        <p>Rendez-vous avec [Nom du Parent] - [Date et Heure]</p>
    </div>
    <!-- Vous pouvez ajouter plus d'éléments de rappel ici -->
</div>
<div id="history" class="history">
    <h2>Historique des Tickets</h2>
    <table>
        <thead>
            <tr>
                <th>Date et Heure</th>
                <th>Nom du Parent</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <!-- Remplacez les lignes ci-dessous par les données de votre historique -->
            <tr>
                <td>[Date et Heure]</td>
                <td>[Nom du Parent]</td>
                <td>[Statut]</td>
            </tr>
            <tr>
                <td>[Date et Heure]</td>
                <td>[Nom du Parent]</td>
                <td>[Statut]</td>
            </tr>
            <!-- Vous pouvez ajouter plus de lignes ici -->
        </tbody>
    </table>
</div>

<script>
    function showInbox() {
        var inbox = document.getElementById("inbox");
        var reminder = document.getElementById("reminder");
        var history = document.getElementById("history");
        inbox.style.display = "block";
        reminder.style.display = "none";
        history.style.display = "none";
    }

    function showReminders() {
        var inbox = document.getElementById("inbox");
        var reminder = document.getElementById("reminder");
        var history = document.getElementById("history");
        inbox.style.display = "none";
        reminder.style.display = "block";
        history.style.display = "none";
    }

    function showHistory() {
        var inbox = document.getElementById("inbox");
        var reminder = document.getElementById("reminder");
        var history = document.getElementById("history");
        inbox.style.display = "none";
        reminder.style.display = "none";
        history.style.display = "block";
    }
</script>
</body>
</html>
