<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accepter'])) {
        // Assurez-vous de valider les données reçues et de prévenir les attaques par injection SQL
        $id_rendezvous = $_POST['id_rdv'];

        // Effectuez la mise à jour du statut du rendez-vous dans la base de données
        // Vous devrez utiliser votre connexion PDO pour effectuer la mise à jour
        // Remplacez "votre_connexion_pdo" par votre connexion réelle à la base de données
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projet_rdv', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparez la requête de mise à jour
            $query = "UPDATE rendezvous SET statut = 'accepté' WHERE id_rdv = :id_rdv";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_rdv', $id_rendezvous, PDO::PARAM_INT);

            // Exécutez la requête
            $stmt->execute();

            // Redirigez l'utilisateur vers la page de menu du professeur ou autre
            header('Location: menuprof.php');
            exit();
        } catch (PDOException $e) {
            // Gérez les erreurs de la base de données ici
            die("Erreur de base de données : " . $e->getMessage());
        }
    }
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['refuser'])) {
        // Assurez-vous de valider les données reçues et de prévenir les attaques par injection SQL
        $id_rendezvous = $_POST['id_rdv'];

        // Effectuez la mise à jour du statut du rendez-vous dans la base de données
        // Vous devrez utiliser votre connexion PDO pour effectuer la mise à jour
        // Remplacez "votre_connexion_pdo" par votre connexion réelle à la base de données
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projet_rdv', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparez la requête de mise à jour
            $query = "UPDATE rendezvous SET statut = 'refusé' WHERE id_rdv = :id_rdv";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_rdv', $id_rendezvous, PDO::PARAM_INT);

            // Exécutez la requête
            $stmt->execute();

            // Redirigez l'utilisateur vers la page de menu du professeur ou autre
            header('Location: menuprof.php');
            exit();
        } catch (PDOException $e) {
            // Gérez les erreurs de la base de données ici
            die("Erreur de base de données : " . $e->getMessage());
        }
    }
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['attente'])) {
        // Assurez-vous de valider les données reçues et de prévenir les attaques par injection SQL
        $id_rendezvous = $_POST['id_rdv'];

        // Effectuez la mise à jour du statut du rendez-vous dans la base de données
        // Vous devrez utiliser votre connexion PDO pour effectuer la mise à jour
        // Remplacez "votre_connexion_pdo" par votre connexion réelle à la base de données
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projet_rdv', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparez la requête de mise à jour
            $query = "UPDATE rendezvous SET statut = 'En attente' WHERE id_rdv = :id_rdv";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_rdv', $id_rendezvous, PDO::PARAM_INT);

            // Exécutez la requête
            $stmt->execute();

            // Redirigez l'utilisateur vers la page de menu du professeur ou autre
            header('Location: menuprof.php');
            exit();
        } catch (PDOException $e) {
            // Gérez les erreurs de la base de données ici
            die("Erreur de base de données : " . $e->getMessage());
        }
    }
}
?>
