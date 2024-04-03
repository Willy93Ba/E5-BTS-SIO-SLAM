<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
<?php

require_once("functions.php");

?>
</head>

<body>
<div class='container'>
<form class="form" action="" method="post">
<div class='form-group mb-2'>



	<div class='form-group mb-2'>
	<label> Nom</label>
	<input type="text" class="form-control" name='nom_parent' required/>
	</div>
	<div class='form-group mb-2'>
	<label> Prenom</label>
	<input type="text" class="form-control" name='prenom_parent' required/>
	</div>

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
</body>
<?php
if(isset($_POST['valider'])){
	array_pop($_POST);
	if(addParent($_POST)){

	header('Location: test.php');

	}
	else{
		echo "ko";
	}

}


?>
</html>
