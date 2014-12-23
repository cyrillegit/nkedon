<?php
/**
	Ce script va supprimer les fichiers dans le dossier output de Documents.
	Il exécutera ce script toutes les nuits à heure fixe.
*/
include ("../config/config.php");

$path = Configuration::getValue ("documents_root");
$path .= "graphs/";

$d = dir ($path);
while (false !== ($entry = $d->read())) 
{	
	if ((strstr ($entry, ".php") === FALSE) && ($entry !== ".") && ($entry !== ".."))
	{
   		//echo $entry."<br />";
		if (file_exists ($path . "/" . $entry))
		{
			unlink ($path . "/" . $entry);
		}
	}
}
$d->close();
echo "Les fichiers ont été correctement nettoyés.";
?>