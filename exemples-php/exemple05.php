<?php
	// On peut aussi construire le code HTML totalement dans le code PHP
	// librairie pour DOM HTML ??
	
	$docImp = new DOMImplementation();
	
	$docType = $docImp->createDocumentType("html", "", "");
	$doc = $docImp->createDocument("", "", $docType);
	
	$html = $doc->createElement('html');
	
	// Création de l'en-tête
	$head = $doc->createElement("head");
	// le titre de la page
	$title = $doc->createElement('title', 'Test 5 en php');
	$head->appendChild($title);
	// la balise meta pour l'encodage
	$meta = $doc->createElement('meta');
	$meta->setAttribute('charset', "utf-8");
	$head->appendChild($meta);
	// ajout de l'en-tête au HTML
	$html->appendChild($head);
	
	// création du corps
	$body = $doc->createElement('body');
	// le titre
	$monTitre = $doc->createElement('h1', 'Cinquième test en php : génération du code HTML dans le code PHP');
	$body->appendChild($monTitre);
	// un texte quelconque
	$monParagraphe1 = $doc->createElement('p', "Ceci est un texte d'exemple, qui ne sert à rien d'autre qu'à montrer comment créer un code HTML directement dans le code PHP... Du coup, ce paragraphe est long pour montrer ce qu'il se passe, mais c'est tout de même bien inutile dans l'absolu.");
	$body->appendChild($monParagraphe1);
	// un div avec du code HTML directement
	$monDiv = $doc->createElement('div', 'Je fais un <strong>test</strong> de div');
	$monDiv->appendChild($doc->createElement('em', ' (encore un ajout inutile)'));	// auquel on ajoute directement encore quelchose
	$body->appendChild($monDiv);
	// ajout du corps au HTML
	$html->appendChild($body);
	
	// export du code HTML ainsi créé.
	$doc->appendChild($html);
	echo $doc->saveHTML();
	//var_dump($doc);
?>
