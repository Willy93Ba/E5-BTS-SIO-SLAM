<?php
require_once('functions_parent.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_prof']) && isset($_POST['meeting_time'])) {
    $id_prof = $_POST['id_prof'];
    $meeting_time = $_POST['meeting_time'];
    if(isset($_POST['commentaires'])){
    $commentaires = $_POST['commentaires'];
    }
    else{
        header("Location:menuparent.php");
    }

    // Enregistrez le rendez-vous dans la base de données avec le statut initial "En attente"
    $link = connectDB();

    if ($link) {
        try {
            $idparent = $_SESSION['parent']['id_parent'];
            $stmt = $link->prepare("INSERT INTO rendezvous (id_prof, id_parent, meeting_time, commentaires, statut) VALUES (?, ?, ?, ?, 'En attente')");
            $stmt->execute(array($id_prof, $idparent, $meeting_time, $commentaires));

            $success = true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $success = false;
        }
    } else {
        $success = false;
    }

    $response = array('success' => $success);
    echo json_encode($response);
} else {
    $response = array('success' => false);
    echo json_encode($response);
}
?>
