<!doctype html>
<html>
<head><title>Récupération des données de la saison régulière 2014-2015</title><meta charset = "utf-8"></head>
<body>
<?php
echo '<p>Début du code</p><ul>'.PHP_EOL;
include 'utiles.php';
date_default_timezone_set('UTC');
$debut = mktime(0, 0, 0, 10, 28, 2014); // 28 octobre 2014
$fin = mktime(0, 0, 0, 04, 15, 2015); // 15 avril 2015
$date = $debut;
while ($date <= $fin) {
    $dateOK = date("d-m-Y", $date);
    echo '<li>'.$dateOK.PHP_EOL;
    recupJSONFiles($dateOK);
	$date = $date + (60 * 60 * 24);
    sleep(10);
}
echo '</ul><p>Fin du code</p>';
?>

</body>
</html>
