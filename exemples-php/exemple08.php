<!doctype html>
<html>
<head>
	<title>Test 8 en PHP</title>
	<meta charset = "utf-8">
</head>
<body>
<h1>Huitième test en PHP : travail avec des fichiers</h1>
<hr>
<h2>Lecture du fichier</h2>
<?php
	// Travail avec des fichiers texte (écriture et lecture)
	// Ouverture d'un fichier texte et affichage du contenu
	$fic = 'exemple08-a.txt';
	if (file_exists($fic)) {
		date_default_timezone_set("Europe/Paris");
		echo "$fic a été accédé le : " . date("F d Y H:i:s.", fileatime($fic))."<br>";

		print "Le fichier $filename existe. Voila son contenu :";
		
		// directement en sortie 
		print "<div style = 'border: solid 1px black;'><h3>Lecture et affichage direct en sortie</h3><p>";
		readfile ($fic); 
		print "</p></div>";
		
		// tout le contenu dans une variable puis affichage de celle-ci
		$contenu = file_get_contents ($fic); 
		print "<div style = 'border: solid 1px black;'><h3>Lecture dans une variable et affichage de la celle-ci</h3><p>".$contenu."</p></div>";
		
		// le contenu dans un tableau
		print "<div style = 'border: solid 1px black;'><h3>Lecture dans une tableau et affichage de chaque ligne</h3><p>";
		$lignes = file ($fic);
		foreach ($lignes as $ligneN => $ligne) {
			echo 'Ligne No <strong>' . $ligneN . '</strong> : ' . htmlspecialchars($ligne) . '<br>'."\n";
		}
		print "</p></div>";

		} 
	else {
		print "Le fichier $fic n'existe pas";
	}
?>

<hr>
<h2>Si le fichier n'existe pas...</h2>
<?php
	$fic = 'exemple08-b.txt';
	if (file_exists($fic)) {
		print "Le fichier $fic existe. Voila son contenu : <hr>";
		} 
	else {
		print "Le fichier $fic n'existe pas";
	}
?>

<hr>
<h2>Ecriture dans un fichier</h2>
<?php
	$contenu = "Voici du contenu\n\nqu'on va mettre dans un fichier.";
	$fic = 'exemple08-c.txt';
	file_put_contents($fic, $contenu);
	readfile($fic);
?>