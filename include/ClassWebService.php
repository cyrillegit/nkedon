<?php
/** =============================================================================================================
 * Fichier ClassWebService
 * ==============================================================================================================
 * Auteur : Cyrille MOFFO
 * Date création : 12/02/2014
 *
 * Description :
 * -------------
 * Ce script constitue la base d'accès aux données. La passerelle publique, elle est gérée dans le fichier
 * gateway.php.
 * Une fonction de vérification de connectivité est réalisée directement depuis le téléphone.
 * =========================================================================================================== */
require_once "../config/config.php";
require_once "ClassDB.php";

header ("Content-type: text/html; character=UTF-8");

class ClassWebService extends Database
{
	protected $imeiCode = "";
	
}
// Fin de document.
?>