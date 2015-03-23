<!doctype html>
<html>
<head>
	<title>Test 6 en PHP</title>
	<meta charset = "utf-8">
</head>
<body>
<h1>Sixième test en PHP : Travail avec des données du type JSON</h1>
<?php
	// Accès direct avec l'URL possible, mais pour développer, mieux vaut enregistrer le fichier et le lire en local
	// $data_json = file_get_contents("http://data.nba.com/5s/json/cms/noseason/scoreboard/20150310/games.json");
	$data_json = file_get_contents("20150310/matchs_20150310.json");
	$data = json_decode($data_json, true);
	//var_dump($data["sports_content"]);
?>
<p>Matchs du <strong>
<?php 
	$date = $data["sports_content"]["sports_meta"]["date_time"];
	$annee = substr($date, 0, 4);
	$mois = substr($date, 4, 2);
	$jour = substr($date, 6, 2);
	date_default_timezone_set("Europe/Paris");
	$date_php = mktime(0, 0, 0, $mois, $jour, $annee);
	setlocale(LC_TIME, "fr_FR");
	echo strftime("%A %e %B %Y", $date_php);
?></strong> (<?php echo sizeof($data["sports_content"]["games"]["game"]); ?> match(s)) :</p>
<table>
<tr><th>Match</th><th>Score</th></tr>
<?php
	$matchs = $data["sports_content"]["games"]["game"];
	foreach($matchs as $match) {
		$nomV = $match['visitor']['city']." ".$match['visitor']['nickname'];
		$nomH = $match['home']['city']." ".$match['home']['nickname'];
		$scoreV = $match['visitor']['score'];
		$scoreH = $match['home']['score'];
		if ($scoreV > $scoreH) {
			$match = "<strong>".$nomV."</strong> @ ".$nomH;
			$score = "<strong>".$scoreV."</strong>-".$scoreH;
		}	
		else {
			$match = $nomV." @ <strong>".$nomH."<strong>";
			$score = $scoreV."-<strong>".$scoreH."</strong>";
		}
		echo "<tr><td>".$match."</td><td>".$score."</td></tr>\n";
	}
?>
</table>
</body>
</html>