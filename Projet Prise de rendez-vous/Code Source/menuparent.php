<?php
session_start();
header('Content-Type: text/html; charset=utf-8');


function isParentLoggedIn() {
    return isset($_SESSION['parent']);
}

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

if (!isset($_SESSION['parent'])) {
    header('Location: connexion_parent.php');
    exit;
}

// Affichage de bienvenue
echo "<h3>Bonjour " . htmlspecialchars($_SESSION['parent']['nom_parent']) . "</h3>";


// Fonction pour récupérer la liste des professeurs liés à l'enfant du parent connecté
function getProfessorsForParent($parent_id){
    $link = connectDB();
    if(!$link){
        return false;
    } else {
        try {
            $stmt = $link->prepare("SELECT e.* FROM enseignants e INNER JOIN classesenseignants ce ON e.id_prof = ce.id_prof INNER JOIN enfants en ON ce.id_classe = en.id_classe WHERE en.id_parent = ?");
            $stmt->execute(array($parent_id));
            $professors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $professors;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

// Fonction pour enregistrer un rendez-vous
function saveAppointment($parent_id, $prof_id, $meeting_time, $comment){
    $link = connectDB();
    if(!$link){
        return false;
    } else {
        try {
            // Enregistrement du rendez-vous avec le statut "ENVOYE" et la vérification vide
            $stmt = $link->prepare("INSERT INTO rendezvous (id_parent, id_prof, meeting_time, commentaires, statut, Verification) VALUES (?, ?, ?, ?, 'ENVOYE', 'EN ATTENTE')");
            $stmt->execute(array($parent_id, $prof_id, $meeting_time, $comment));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

// Fonction pour récupérer les rendez-vous du parent
function getAppointmentsForParent($parent_id){
    $link = connectDB();
    if(!$link){
        return false;
    } else {
        try {
            $stmt = $link->prepare("SELECT * FROM rendezvous WHERE id_parent = ?");
            $stmt->execute(array($parent_id));
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $appointments;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}


var_dump(function_exists('isParentLoggedIn'));

if (isParentLoggedIn()) {
    $parent_id = $_SESSION['parent']['id_parent'];

    // Si le formulaire pour prendre un rendez-vous est soumis
    if(isset($_POST['valider_rdv'])){
        $prof_id = $_POST['prof_id'];
        $meeting_time = $_POST['meeting_time'];
        $comment = $_POST['commentaire'];
        if(saveAppointment($parent_id, $prof_id, $meeting_time, $comment)){
            echo "<div style='color: green; text-align: center;'><h3>Rendez-vous enregistré avec succès!</h3></div>";
        } else {
            echo "<div style='color: red; text-align: center;'><h3>Erreur lors de l'enregistrement du rendez-vous.</h3></div>";
        }
    }
} else {
    echo 'Erreur : Parent non connecté.';
}

    // Récupérer la liste des professeurs pour cet parent
    $professors = getProfessorsForParent($parent_id);

    // Récupérer les rendez-vous de cet parent
    $appointments = getAppointmentsForParent($parent_id);

?>

<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">

</head>

<body>
<div class='container'>
    <?php if(isParentLoggedIn()): ?>
        <div style='text-align: center;'>
            <h1 style='color: blue;'>Menu parent</h1>
            <div style='text-align: center;'>
            <h3 style='color: green;'>Bonjour <?php echo $_SESSION['parent']['nom_parent']; ?></h3>
        </div>
        </div>

        <h2>Liste des professeurs</h2>
        <ul>
            <?php foreach($professors as $professor): ?>
                <li><?php echo $professor['nom_prof']; ?> <?php echo $professor['prenom_prof']; ?> <?php echo $professor['matiere']; ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Prendre un rendez-vous</h2>
        <form class="form" action="" method="post">
            <div class='form-group mb-2'>
                <select name="prof_id" class="form-control" required>
                    <option value="">Sélectionner un professeur</option>
                    <?php foreach($professors as $professor): ?>
                        <option value="<?php echo $professor['id_prof']; ?>"><?php echo $professor['nom_prof']; ?>  <?php echo $professor['prenom_prof']; ?>  <?php echo $professor['matiere']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class='form-group mb-2'>
                <label>Date et heure</label>
                <input type="datetime-local" class="form-control" name="meeting_time" required/>
            </div>
            <div class='form-group mb-2'>
                <label>Commentaires</label>
                <textarea class="form-control" name="commentaire"></textarea>
            </div>
            <button type="submit" name="valider_rdv" class="btn btn-primary">Confirmer le rendez-vous</button>
        </form>

        <h2>Mes rendez-vous</h2>
        <ul>
            <?php foreach($appointments as $appointment): ?>
                <li>Rendez-vous avec <?php echo $appointment['id_prof']; ?> le <?php echo $appointment['meeting_time']; ?> (Statut: <?php echo ($appointment['Verification'] == 'EN ATTENTE' ? 'En attente de vérification du modérateur' : ($appointment['statut_prof'] == 'ACCEPTE' ? 'Accepté par le modérateur' : 'Refusé par le modérateur')) ?>) Reponse du prof: <?php echo ($appointment['statut_prof'] == 'EN ATTENTE' ? 'En attente de vérification du professeur' : ($appointment['statut_prof'] == 'ACCEPTE' ? 'Accepté par le professeur' : 'Refusé par le professeur')) ?>)</li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p style='color: red; text-align: center;'>Veuillez vous connecter en tant que parent pour accéder à cette page.</p>
    <?php endif; ?>
</div>
</body>
</html>
