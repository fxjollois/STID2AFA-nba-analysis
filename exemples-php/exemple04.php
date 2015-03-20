<!doctype html>
<html>
<head>
	<title>Test 4 en PHP</title>
	<meta charset = "utf-8">
</head>
<body>
<h1>Quatrième test en PHP : Passage de paramètre dans l'adresse</h1>
<ul>
	<li>Contenu de la variable <code>GET</code> = <strong><?php echo $_GET['maVar']; ?></strong>
	<li>Contenu de la variable <code>POST</code> = <strong><?php echo $_POST['maVar']; ?></strong>
</ul>
<ul>
	<li>Lors l'on appelle la page directement (comme <a href = "exemple04.php">ici</a>), il n'y a rien dans la variable
	<li>Par contre, si on ajoute dans l'adresse <code>?maVar=TEST</code> (comme <a href="exemple04.php?maVar=TEST">ici</a>), 
	on va voir le contenu de la variable (ici donc <code>TEST</code>)
	<li>On peut même récupérer le contenu d'un formulaire HTML (en mode <code>GET</code>)
		<form method = "GET" action = "exemple04.php">
			<fieldset>
				<legend>Récupération en <strong>GET</strong> d'une valeur entrée par l'utilisateur</legend>
				Texte : <input type = "text" name = "maVar" value = "entrez votre texte ici">
				<input type = "submit" value = "Soumettre">
			</fieldset>
		</form>
	<li>On peut faire un passage de paramètres sans qu'ils soient visibles dans l'adresse (et donc invisible à l'utilisateur).
	On utilise donc la méthode <code>POST</code>. 
		<form method = "POST" action = "exemple04.php">
			<fieldset>
				<legend>Récupération en <strong>POST</strong> d'une valeur entrée par l'utilisateur</legend>
				Texte : <input type = "text" name = "maVar" value = "entrez votre texte ici">
				<input type = "submit" value = "Soumettre">
			</fieldset>
		</form>
</ul>
<p>Regardez le code source de la page.</p>
</body>
<html>