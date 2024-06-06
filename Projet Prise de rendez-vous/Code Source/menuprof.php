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

if (!isset($_SESSION['prof'])) {
    header('Location: connexion_prof.php');
    exit;
}

// Affichage de bienvenue
echo "<h3>Bonjour " . htmlspecialchars($_SESSION['prof']['nom_prof']) . "</h3>";

// Récupération des rendez-vous validés
function getValidatedAppointments($id_prof) {
    $link = connectDB();
    if (!$link) {
        return false;
    } else {
        try {
            $stmt = $link->prepare("SELECT * FROM rendezvous WHERE id_prof = ? AND Verification = 'ACCEPTE'");
            $stmt->execute(array($id_prof));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des rendez-vous : " . $e->getMessage();
            return false;
        }
    }
}

// Mise à jour du statut du rendez-vous
function updateAppointmentStatus($id_rdv, $status, $comment) {
    $link = connectDB();
    if (!$link) {
        return false;
    } else {
        try {
            $stmt = $link->prepare("UPDATE rendezvous SET statut_prof = ?, commentaires = ? WHERE id_rdv = ?");
            $stmt->execute(array($status, $comment, $id_rdv));
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du rendez-vous : " . $e->getMessage();
            return false;
        }
    }
}

// Gestion de la mise à jour des statuts via le formulaire
if (isset($_POST['update_status'])) {
    $id_rdv = $_POST['id_rdv'];
    $status = $_POST['statut'];
    $comment = $_POST['commentaire'];
    if (updateAppointmentStatus($id_rdv, $status, $comment)) {
        echo "<p>Statut du rendez-vous mis à jour avec succès.</p>";
    } else {
        echo "<p>Erreur lors de la mise à jour du statut du rendez-vous.</p>";
    }
}

// Récupérer les rendez-vous validés, excluant ceux refusés par le prof
$validated_appointments = getValidatedAppointments($_SESSION['prof']['id_prof']);
?>

<div class='container'>
    <h1>Rendez-vous validés</h1>
    <?php if (!empty($validated_appointments)): ?>
        <ul>
            <?php foreach ($validated_appointments as $appointment): ?>
                <?php if ($appointment['statut_prof'] !== 'REFUSE'): ?>
                <li><?php echo "Rendez-vous avec le parent numéro " . $appointment['id_parent'] . " - " . htmlspecialchars($appointment['commentaires']); ?>
                    <form action="" method="post">
                        <input type="hidden" name="id_rdv" value="<?php echo $appointment['id_rdv']; ?>">
                        <input type="text" name="commentaire" placeholder="Motif de refus (si applicable)">
                        <select name="statut">
                            <option value="ACCEPTE">Accepter</option>
                            <option value="REFUSE">Refuser</option>
                        </select>
                        <button type="submit" name="update_status">Mettre à jour le statut</button>
                    </form>
                </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun rendez-vous validé.</p>
    <?php endif; ?>
</div>
