<?php
try {
    // Paramètres de connexion à la base de données
    $host = 'localhost'; // Adresse du serveur MySQL (localhost pour une utilisation locale)
    $dbname = 'projet_rdv'; // Nom de la base de données
    $user = 'root'; // Nom d'utilisateur MySQL
    $password = ''; // Mot de passe MySQL

    // Connexion à la base de données en utilisant PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);

    // Définir le mode d'erreur PDO à exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vous pouvez maintenant exécuter des requêtes SQL avec PDO

    // Exemple de requête pour récupérer des données d'une table
    $sql = "SELECT * FROM parents";
    $result = $pdo->query($sql);

    // Parcourir les résultats
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['id_parent'] . "</td>";
        echo "<td>" . $row['nom_parent'] . "</td>";
        echo "<td>" . $row['prenom_parent'] . "</td>";
        echo "<td>" . $row['email_parent'] . "</td>";
        echo "<td>" . $row['motdepasse'] . "</td>";
        echo "</tr>";
    }


} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
