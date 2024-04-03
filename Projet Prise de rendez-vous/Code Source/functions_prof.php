<?php
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
		$req = "select * from enseignants";
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

function addProf($data){
    $link = connectDB();
    if(!$link){
        // Gérer l'erreur de connexion ici
        return false;
    }
    else{
        try {
            $data = array_values($data);
            $stmt = $link->prepare("INSERT INTO enseignants (nom_prof,prenom_prof,email_prof,matiere,motdepasse) VALUES (?, ?, ?, ?,?)");
            $rep = $stmt->execute(array_values($data));


			$_SESSION['id_prof']=$link->lastInsertId();

            return $rep;
        } catch (PDOException $e) {
            // Gérer l'erreur de requête ici

            return false;
        }
    }
}


?>
