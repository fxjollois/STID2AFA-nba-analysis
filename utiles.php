<?php
function recupJSONFiles($date) {
	// récupération des données
	$codeDate = substr($date, 6, 4).substr($date, 3, 2).substr($date, 0, 2);
	$dirGames = "games/".$codeDate;
	if (!is_dir($dirGames)) { // le jour n'a pas encore été chargé
		mkdir($dirGames);
		$urlGames = "http://data.nba.com/5s/json/cms/noseason/scoreboard/".$codeDate."/games.json";
		$fileGames = $dirGames."/games.json";
		copy($urlGames, $fileGames);
		$urlContent = json_decode(file_get_contents($fileGames), true);
		foreach($urlContent["sports_content"]["games"]["game"] as $game) {
			$idGame = $game["id"];
			$dirGame = $dirGames."/".$idGame;
			mkdir($dirGame);
			$urlGameBase = "http://data.nba.com/5s/json/cms/noseason/game/".$codeDate."/".$idGame;
			$urlGameBoxscore = $urlGameBase."/boxscore.json";
			$fileGameBoxscore = $dirGame."/boxscore.json";
			copy($urlGameBoxscore, $fileGameBoxscore);
			$nbperiod = $game["period_time"]["period_value"];
			for ($i = 0; $i < $nbperiod; $i++) {
				$urlGamePbp = $urlGameBase."/pbp_".($i+1).".json";
				$fileGamePbp = $dirGame."/pbp_".($i+1).".json";
				copy($urlGamePbp, $fileGamePbp);
			}  
		}
	}
}
?>