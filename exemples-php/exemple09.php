<head>
	<title>Test 9 en PHP</title>
	<meta charset = "utf-8">
</head>
<body>
<h1>Neuvième test en PHP : Travail avec SQLite</h1>

<?php

	/* si le code ne fonctionne pas, faire dans un terminal : 
		$ sudo apt-get install php5-sqlite
		$ sudo /etc/init.d/apache2 restart
	*/
	
	// Travail avec SQLite
	// Le fichier doit être en r+w pour tous (666) et le répertoire dans lequel il est aussi (777 dans ce cas)
	// récupération du jeu de données
	$db = new PDO('sqlite:bases/games.sqlite3');
	echo "ok";
	if ($db) {
		// choix du jour ici
		$jour = "20150312";
		
		// premier pas : on cherche si le jour demandé est déjà dans la base
		// création de la chaîne de caractère contenant la requête (le ? indique qu'on devra mettre un paramètre)
		$dejala_sql = "select jour from games where jour = ?";
		// préparation de la requête
		$dejala_query = $db->prepare($dejala_sql);
		// exécution de la requête avec comme paramètre un tableau à une seule valeur, le jour voulu
		$dejala_query->execute(array($jour));
		// récupération de la taille du résultat
		$dejala = sizeof($dejala_query->fetchAll());
		
		if (!$dejala) { // i.e. taille = 0
			echo "Jour non présent dans la BD.";
			// récupération des données JSON
			$data_json = file_get_contents("http://data.nba.com/5s/json/cms/noseason/scoreboard/".$jour."/games.json");
			//var_dump($data_json);
			if (empty($data_json))
				echo " Problème pour récupérer les données.";
			else {
				$insertion_sql = "insert into games values (?, ?)";
				$insertion_query = $db->prepare($insertion_sql);
				$insertion_query->execute(array($jour, $data_json)); // $data_json
				echo " Données récupérées.";
			}
		}
		else { // i.e. taille > 0 (si on a bien fait les choses, le jour ne sera présent qu'une seule fois
			echo "Deja la.";
		}
		
		echo"<br><br>";
	
		// on peut récupérer les données présents dans la base donc
		foreach ($db->query('select * from games;') as $row) {
			print "Jour : ".$row['jour']." : ";
			// et même décoder le JSON pour lire les données dedans.
			$data = json_decode($row['json'], true);
			print sizeof($data["sports_content"]["games"]["game"])." matche(s)";
			print "<br>";
		}
		
		// fermeture de la connection
		unset($db);
	} 
	else {
		die ("Impossible d'ouvrir la base de données :");
	}
?>