<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom_parent']) && isset($_POST['date_time'])) {
    $nom_parent = $_POST['nom_parent'];
    $date_time = $_POST['date_time'];

    // Traitez la notification de rendez-vous reçue du menu parent
    // Affichez-la ou effectuez les actions nécessaires dans le menu du professeur.

    // Vous pouvez également stocker ces notifications dans une base de données pour un affichage ultérieur.

    $response = ['success' => true];
    echo json_encode($response);
} else {
    // Gérez le cas où la requête n'est pas de type POST
}
?>
