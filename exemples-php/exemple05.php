<?php
	// On peut aussi construire le code HTML totalement dans le code PHP
	// librairie pour DOM HTML ??
	
	$docImp = new DOMImplementation();
	$docType = $docImp->createDocumentType("html", "", "");
	$doc = $docImp->createDocument("", "", $docType);
	$doc->encoding = "utf-8"; // pas utile a priori...
	echo "<hr>".$doc->saveHTML()."<hr>";
	//var_dump($doc);
?>