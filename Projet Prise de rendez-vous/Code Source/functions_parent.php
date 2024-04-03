<<?php
session_start();

function connectDB(){
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

function disconnectDB($link){
	$link=null;
}

function getAllEquipe(){
	// connect to database
	$link = connectDB();
	if(!$link){
		echo "server down !";
		return false;
	}
	else{
		$req = "select * from parents";
		$stmt = $link->prepare($req);
		$rep = $stmt->execute();
		if(!$rep){
			var_dump($stmt->errorInfo());
			return false;
		}
		else{
		$tabEquipe = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $tabEquipe;
		}
	}

}

function connectParent($email, $password){
    $link = connectDB();
    if(!$link){

        return false;
    }
    else{
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



//fonction prof parent
function getProfParent(){
    $link = connectDB();
    if(!$link){

        return false;
    }
    else{
        try {
			$stmt = $link->prepare("SELECT enseignants.* FROM enseignants
			INNER JOIN classesenseignants ON enseignants.id_prof = classesenseignants.id_prof
			INNER JOIN enfants ON classesenseignants.id_classe = enfants.id_classe
			WHERE enfants.id_parent = ?");
 			$param = array($_SESSION['parent']['id_parent']);
			 $stmt->execute($param);
		 	$tabProf = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if ($tabProf) {


                return $tabProf;
            } else {

                return false;
            }
        } catch (PDOException $e) {

            echo $e->getMessage();
            return false;
        }
    }
}
function getStatutDemandes(){
    $link = connectDB();
    if(!$link){
        return false;
    } else {
        try {
            $stmt = $link->prepare("SELECT enseignants.nom_prof, enseignants.prenom_prof, rendezvous.meeting_time, rendezvous.statut, rendezvous.motif_refus FROM rendezvous
                INNER JOIN enseignants ON enseignants.id_prof = rendezvous.id_prof
                WHERE rendezvous.id_parent = ?");
            $stmt->execute(array($_SESSION['parent']['id_parent']));
            $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $demandes;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
// Dans functions_parent.php

function getStatutDemandesParent($id_parent) {
 // Assurez-vous que la connexion à la base de données est correctement établie

 try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet_rdv', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $link = $pdo; // Affectez la connexion PDO à la variable $link
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}

try {
    // Utilisez la requête SQL corrigée
    $query = "SELECT rendezvous.meeting_time, rendezvous.statut, rendezvous.commentaires, enseignants.nom_prof
              FROM rendezvous
              INNER JOIN enseignants ON rendezvous.id_prof = enseignants.id_prof
              WHERE rendezvous.id_parent = :id_parent";

    $stmt = $link->prepare($query);
    $stmt->bindParam(':id_parent', $id_parent, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gérez les erreurs de la base de données ici
    die("Erreur de base de données : " . $e->getMessage());
}

}


?>
