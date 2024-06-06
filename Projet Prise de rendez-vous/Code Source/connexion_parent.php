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

// Fonction pour connecter un parent
function connectParent($email, $password){
    $link = connectDB();
    if(!$link){
        return false;
    } else {
        try {
            $stmt = $link->prepare("SELECT * FROM parents WHERE email_parent = ? AND motdepasse = ?");
            $stmt->execute(array($email, $password));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $_SESSION['parent'] = $row;
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

// Fonction pour vérifier si un parent est connecté
function isParentLoggedIn(){
    return isset($_SESSION['parent']);
}


?>

<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
</head>

<body>
<div class='container'>
    <form class="form" action="" method="post">
        <div class='form-group mb-2'>
            <div class='form-group mb-2'>
                <label> EMAIL</label>
                <input type="email" class="form-control" name='email_parent' required/>
            </div>
            <div class='form-group mb-2'>
                <label> Mot de passe</label>
                <input type="password" class="form-control" name='motdepasse' required/>
            </div>

            <button type="submit" name="valider" class="btn btn-primary">Confirmer</button>
        </div>
    </form>
</div>
</body>

<?php
if(isset($_POST['valider'])){
    $email = $_POST['email_parent'];
    $password = $_POST['motdepasse'];
    if(connectParent($email, $password)){
        header('Location: menuparent.php');
    } else {
        echo "ko";
    }
}
?>
</html>
