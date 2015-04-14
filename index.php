<!doctype html>
<html>
<head><title>Stat NBA</title><meta charset = "utf-8"></head>
<body>
<?php
echo 'test';
include 'utiles.php';
$date = $_GET['date'];
if (empty($date)) {
	$date = date("d/m/Y", time() - 60 * 60 * 24);
}
recupJSONFiles($date);
?>
<form name = "choixDate" action = "index.php" method = "GET">
	Choisir le jour 
	<input name = "date" value = "<?php echo $date; ?>" type = "text">
	<input type = "submit" value = "Go">
</form>

</body>
</html>
