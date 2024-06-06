<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// Fonction pour se connecter à la base de données avec UTF-8
function connectDB() {
    // Paramètres de connexion au serveur de base de données
    $host = 'localhost';
    $dbname = 'u967421408_DASILVA';
    $username = 'u967421408_DASILVA';
    $password = '66y9pD%ditS!5hNmcm8fLVq36cU%Fxzr#!RtMnBN';
    try {
        // Utilisation de l'extension PDO pour la connexion
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}


if (!isset($_SESSION['modo'])) {
    header('Location: connexion_modo.php');
    exit();
}

echo "<h3>Bonjour " . $_SESSION['modo']['Identifiant_modo'] . "</h3>";


// Fonction pour récupérer tous les rendez-vous en attente de validation
function getAllPendingAppointments() {
    $link = connectDB();
    if(!$link){
        return false;
    } else {
        try {
            $stmt = $link->prepare("SELECT * FROM rendezvous WHERE Verification = 'EN ATTENTE'");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

// Fonction pour valider ou refuser un rendez-vous
function validateAppointment($id_rdv, $verification_status) {
    $link = connectDB();
    if(!$link){
        return false;
    } else {
        try {
            $stmt = $link->prepare("UPDATE rendezvous SET Verification = ? WHERE id_rdv = ?");
            $stmt->execute(array($verification_status, $id_rdv));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

// Logique pour traiter le formulaire de validation
if(isset($_POST['validate'])) {
    $id_rdv = $_POST['id_rdv'];
    $verification_status = $_POST['verification_status'];
    if(validateAppointment($id_rdv, $verification_status)) {
        echo "<p>Statut de validation mis à jour avec succès.</p>";
    } else {
        echo "<p>Erreur lors de la mise à jour du statut de validation.</p>";
    }
}

// Récupérer tous les rendez-vous en attente
$pending_appointments = getAllPendingAppointments();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu Modérateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class='container'>
    <h1>Rendez-vous en attente de validation</h1>
    <?php if ($pending_appointments && count($pending_appointments) > 0): ?>
        <ul>
            <?php foreach ($pending_appointments as $appointment): ?>
                <li>
                    <?php echo "Rendez-vous avec le parent numéro " . $appointment['id_parent'] . " - " . $appointment['commentaires']; ?>
                    <form action="" method="post">
                        <input type="hidden" name="id_rdv" value="<?php echo $appointment['id_rdv']; ?>">
                        <select name="verification_status">
                            <option value="ACCEPTE">Accepter</option>
                            <option value="REFUSE">Refuser</option>
                        </select>
                        <button type="submit" name="validate">Valider le statut</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun rendez-vous en attente de validation.</p>
    <?php endif; ?>
</div>
</body>
</html>
