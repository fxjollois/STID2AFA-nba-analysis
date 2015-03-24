<!doctype html>
<html>
<head><title>TP1</title><meta charset = "utf-8">
<body>
<?php
$date = $_GET['date'];
if (empty($date)) {
	$date = date("d/m/Y", time() - 60 * 60 * 24);
?>
<form name = "choixDate" action = "TP1.php" method = "GET">
	Choisir le jour 
	<input name = "date" value = "<?php echo $date; ?>" type = "text">
	<input type = "submit" value = "Go">
</form>
<?php
} else {
	// récupération des données
	$codeDate = substr($date, 6, 4).substr($date, 3, 2).substr($date, 0, 2);
	$dirGames = "games/".$codeDate;
	if (!is_dir($dirGames)) { // le jour n'a pas encore été chargé
		mkdir($dirGames);
		$urlGames = "http://data.nba.com/5s/json/cms/noseason/scoreboard/".$codeDate."/games.json";
		echo "\n<a href='".$urlGames."'>games.json</a> : <ul>";
		$fileGames = $dirGames."/games.json";
		copy($urlGames, $fileGames);
		$urlContent = json_decode(file_get_contents($fileGames), true);
		foreach($urlContent["sports_content"]["games"]["game"] as $game) {
			$idGame = $game["id"];
			$dirGame = $dirGames."/".$idGame;
			mkdir($dirGame);
			$urlGameBase = "http://data.nba.com/5s/json/cms/noseason/game/".$codeDate."/".$idGame;
			$urlGameBoxscore = $urlGameBase."/boxscore.json";
			echo "\n<li><a href='".$urlGameBoxscore."'>Boxscore</a> | ";
			$fileGameBoxscore = $dirGame."/boxscore.json";
			copy($urlGameBoxscore, $fileGameBoxscore);
			$nbperiod = $game["period_time"]["period_value"];
			for ($i = 0; $i < $nbperiod; $i++) {
				$urlGamePbp = $urlGameBase."/pbp_".($i+1).".json";
				echo "<a href='".$urlGamePbp."'>pbp_".($i+1)."</a> | ";
				$fileGamePbp = $dirGame."/pbp_".($i+1).".json";
				copy($urlGamePbp, $fileGamePbp);
			}  
		}
		echo "\n</ul>";
		// echo $urlGames;
	}
	// $info = file_get_contents("games/".$codeDate."/games.json");
	// var_dump($info);
?>
Matchs du <?php echo $date; ?>
<?php
}
?>
</body>
</html>
