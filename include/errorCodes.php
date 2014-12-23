<?php
/** =====================================================================================================
Fichier errorCodes
------------------
Définition des codes d'erreurs gérés dans le site Internet du BackOffice.
Les erreurs commencent par 10000 et sont ensuite indéxées par cran de 1.
====================================================================================================== */
define ("ERROR_SUCCESS"									, 0);
define ("ERROR_JOB_UNDONE"								, 99999);

// Erreur dédiées réellement aux différents traitements.
define ("E_NOIMEI" 										, 1001);
define ("E_UNKNOWN_ORDER"								, 1002);
define ("ERROR_GATEWAY_BAD_CREDENTIALS"					, 10000);
define ("ERROR_GATEWAY_FORBIDDEN_ACCESS"				, 10001);
define ("ERROR_GATEWAY_DUPLICATE_HORODATE_JOB"			, 10002);
define ("ERROR_GATEWAY_CANNOT_HORODATE_JOB"				, 10003);
define ("ERROR_GATEWAY_CANNOT_CONTROL_JOB"				, 10004);
define ("ERROR_GATEWAY_UNKNOWN_TARGET_TYPE"				, 10005);
define ("ERROR_CONTROLE_HEADER"							, 10006);
define ("ERROR_CONTROLE_DETAILS"						, 10007);
define ("ERROR_DOTATION_HEADER"							, 10008);
define ("ERROR_DOTATION_DETAILS"						, 10009);
define ("ERROR_REMISE_DOTATION"							, 10010);
define ("ERROR_REMISE_DOTATION_UNKNOWN"					, 10011);
define ("ERROR_INCIDENT_MATERIEL"						, 10012);
define ("ERROR_POINTAGE"								, 10013);
define ("ERROR_SUIVI_PERIODIQUES"						, 10014);
define ("ERROR_URGENCE_HYGIENE"							, 10015);
define ("ERROR_URGENCE_MAINTENANCE"						, 10016);
define ("ERROR_ZONE_FINISHED"							, 10017);
define ("ERROR_MAINTENANCE"								, 10018);
define ("ERROR_CONSOMMABLE"								, 10019);
define ("ERROR_MOUVEMENT_STOCK"							, 10020);
?>