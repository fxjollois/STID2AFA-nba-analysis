<!doctype html>
<html>
<head>
	<title>Test 7 en PHP</title>
	<meta charset = "utf-8">
</head>
<body>
<h1>Septième test en PHP : Travail avec les librairies graphiques (Google Charts et D3, voire Raphael)</h1>
<?php
	// http://data.nba.com/10s/json/cms/noseason/game/20150310/0021400946/pbp_1.json
?>
<h2>Avec Google Charts</h2>
<p>Regarder le script JS pour comprendre le fonctionnement de l'API Google Charts. Et le code PHP pour comprendre comment on le génère à partir des données JSON. On aurait pu éventuellement le générer à partir de JS directement.</p>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load('visualization', '1.1', {packages: ['line']});
	google.setOnLoadCallback(drawChart);
	
	function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Seconds');
        data.addColumn('number', 'Visitor');
        data.addColumn('number', 'Home');
        
<?php
        $boxscore_json = file_get_contents("20150310/match_20150310_ORLIND_boxscore.json");
        $boxscore = json_decode($boxscore_json, true);
        $nbperiod = $boxscore["sports_content"]["game"]["period_time"]["total_periods"];
        
        for ($i = 0; $i < $nbperiod; $i++) {
			$data_json = file_get_contents("20150310/match_20150310_ORLIND_pbp_".($i+1).".json");
			$data = json_decode($data_json, true);
			$play = $data["sports_content"]["game"]["play"];
			foreach($play as $action) {
				$clock = $action["clock"];
				if (empty($clock)) $clock = "12:00";
				$seconds = ($i*12*60) + (12*60 - (intval(substr($clock, 0, 2))*60 + intval(substr($clock, 3, 2))));
				// echo $clock." - ".$seconds."\n";
				$scoreV = $action["visitor_score"];
				$scoreH = $action["home_score"];
				echo "data.addRows([[".$seconds.",".$scoreV.",".$scoreH."]]);\n";
			}
			
        }
?>
        var options = {
        	chart: {
        		title: 'Evolution du score',
        		subtitle: 'à chaque seconde'
        	}
        };

        var chart = new google.charts.Line(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>

</body>
</html>
