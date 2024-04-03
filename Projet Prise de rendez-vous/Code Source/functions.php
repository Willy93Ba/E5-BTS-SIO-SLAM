<?php
session_start();
function connectDB(){
	$link = new PDO('mysql:host=localhost;dbname=projet_rdv', 'root', '');
	if($link){
		return $link;
	}
	else{
		return null;
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

function addParent($data){
    $link = connectDB();
    if(!$link){
        // Gérer l'erreur de connexion ici
        return false;
    }
    else{
        try {
            $data = array_values($data);
            $stmt = $link->prepare("INSERT INTO parents (nom_parent,prenom_parent,email_parent,motdepasse) VALUES (?, ?, ?, ?)");
            $rep = $stmt->execute(array_values($data));

$_SESSION['id_parent']=$link->lastInsertId();


            return $rep;


        } catch (PDOException $e) {
            // Gérer l'erreur de requête ici
			echo $e->Message();
            return false;
        }
    }
}


?>
