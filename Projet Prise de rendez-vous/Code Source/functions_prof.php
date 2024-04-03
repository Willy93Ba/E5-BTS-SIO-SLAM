<?php
session_start();

// Fonction de connexion à la base de données
function connectDB() {
    $host = 'localhost';
    $dbname = 'u967421408_DASILVA';
    $username = 'u967421408_DASILVA';
    $password = '66y9pD%ditS!5hNmcm8fLVq36cU%Fxzr#!RtMnBN';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Définissez les options PDO ici si nécessaire
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}


// Initialisation de la connexion PDO
$pdo = connectDB();

// Vérifiez si la connexion à la base de données a réussi
if (!$pdo) {
    echo "La connexion à la base de données a échoué.";
    exit;
}

// Fonction pour récupérer toutes les équipes (enseignants)
function getAllEquipe() {
    global $pdo; // Utilisez l'objet PDO initialisé dans votre code

    try {
        $query = "SELECT * FROM enseignants";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $tabEquipe = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $tabEquipe;
    } catch (PDOException $e) {
        die("Erreur de base de données : " . $e->getMessage());
    }
}

// Fonction pour connecter un professeur
function connectProf($email, $password) {
    global $pdo; // Utilisez l'objet PDO initialisé dans votre code

    try {
        $query = "SELECT * FROM enseignants WHERE email_prof = :email AND motdepasse = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $_SESSION['prof'] = $row;
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur de base de données : " . $e->getMessage());
    }
}

// Fonction pour récupérer les demandes de rendez-vous du professeur
function getDemandesDeRendezVous() {
    global $pdo; // Utilisez l'objet PDO initialisé dans votre code

    try {
        $id_prof = $_SESSION['prof']['id_prof'];
        $query = "SELECT rendezvous.*, parents.nom_parent FROM rendezvous
		JOIN parents ON rendezvous.id_parent = parents.id_parent
		WHERE rendezvous.id_prof = :id_prof";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id_prof", $id_prof, PDO::PARAM_INT);
        $stmt->execute();
        $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $demandes;
    } catch (PDOException $e) {
        die("Erreur de base de données : " . $e->getMessage());
    }
}
function getHistoriqueRendezVous() {
    global $pdo;

    try {
        $id_prof = $_SESSION['prof']['id_prof'];
        $query = "SELECT * FROM rendezvous WHERE id_prof = :id_prof AND (statut = 'Accepté' OR statut = 'Refusé') AND commentaires";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id_prof", $id_prof, PDO::PARAM_INT);
        $stmt->execute();
        $historique = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $historique;
    } catch (PDOException $e) {
        die("Erreur de base de données : " . $e->getMessage());
    }
}
function getHistorique(){
    global $pdo; // Assurez-vous que $pdo est correctement initialisé dans votre code.

    try {
        $id_prof = $_SESSION['prof']['id_prof'];
        $query = "SELECT rendezvous.id_rdv,rendezvous.meeting_time,rendezvous.statut,rendezvous.commentaires,enseignants.nom_prof,parents.nom_parent FROM `rendezvous`,enseignants,parents WHERE CURRENT_TIMESTAMP() > meeting_time AND rendezvous.id_prof = :id_prof and rendezvous.id_prof=enseignants.id_prof and rendezvous.id_parent=parents.id_parent";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_prof', $id_prof, PDO::PARAM_INT);
        $stmt->execute();
        $historique = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $historique;
    } catch (PDOException $e) {
        die("Erreur de base de données : " . $e->getMessage());
    }
}
?>


