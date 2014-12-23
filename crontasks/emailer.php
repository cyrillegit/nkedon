<?php
/** ========================================================================================================================================
Fichier emailer.php
-------------------
Script de gestion des emails, et envoi en rafale aux différentes personnes concernées.
======================================================================================================================================== */
require_once ("../config/config.php");
require_once ("../include/ClassDB.php");
require_once ("../include/ClassMail.php");
include ("../include/function.php");

function callback($buffer)
{
	$mail = new Mail ();
	$mail->AddBody(utf8_encode ($buffer));
	$mail->AddSubject("Script emailer.php (Nkedon)");
	$mail->AddRecipients(array ("Cyrille MOFFO" => "cyrille.moffo@nemand-soft.com"), "To");
	if (Configuration::getValue ("ActivateEmailerLog"))
	{
		$mail->sendMail();
	}
	return $buffer;
}
?>
<html>
<head>
<title>Suivi des emails à envoyer aux personnes concernées</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
session_start ();
// Base de données globale.
$master = new MasterDB ();
$clients = $master->GetAllClients ();
ob_start ("callback");
foreach ($clients as $client)
{
	$_SESSION ["CodeClient"] = $client ["code_clinique"];
	$connected = $master->ConnectNormal ($client ["code_clinique"]);
	$_SESSION ["ConnectionInfo"] = $master->GetConnectionInfo ();
	$db = new Database ();
	$mail = new Mail();
	?>

<div class="content" style="margin: 10px 0 0 10px;">
    <div class="t_titre">
        <div class="title"><strong>traitement</strong> <strong style="color:#1c9bd3">des emails du client <?php echo $client ["raison_sociale"]; ?></strong></div>
    </div>
<div style="clear: both;">&nbsp;</div>
    La connexion sur le backoffice du client a réussie.
      <p>&nbsp;</p>
		<?php $db->SetSql ("select * from t_cliniques"); 
			$cliniques = $db->FetchAllRows();
			foreach ($cliniques as $clinique)
			{
		?>
<strong><u><span style="font-size: 16px;">Gestion de la clinique : <?php echo $clinique ["raison_sociale"]; ?></span></u></strong><br /><br>
			<?php
				$idClinique = $clinique ["idt_cliniques"];
				$config = $db->GetCliniqueConfig($idClinique);
                $db->SetSql ("select * from t_types_emails");
                $types = $db->FetchAllRows();
                foreach ($types as $typeEmail) 
				{ 
            ?>
                <span class="subTitle">Envoi des emails de type : <strong><?php echo $typeEmail ["nom_type_email"]; ?></strong></span><br /><br />
            
                <?php
                    // Ici, on effectue le traitement d'envoi des données, et on compta le nombre d'emails envoyés.
                    $foundConfig = true;
                    
                    switch ($typeEmail ["nom_type_email"])
                    {
                        case "CONTROLE":
                            $email = $config ["email_alerte_controle"];
                            $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_controle.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
						case "DOTATION":
							$email = $config ["email_alerte_dotation"];
                            $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_dotation.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
						case "REMISE_DOTATION":
							$email = $config ["email_alerte_remise_dotation"];
                            $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_remise_dotation.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
                        case "MATERIEL":
							$email = $config ["email_alerte_immobilisations"];
                            $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_incident_materiel.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
                        case "HEURES":
							$email = $config ["email_alerte_heures"];
                            $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_heures.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
                        case "FORGOTTEN_PASSWORD":
							$email = "##Autogenerated##";
							$foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_forgotten_password.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
							break;
                        case "INCIDENT_SERVICE_MAINTENANCE":
							$email = $config ["email_service_maintenance"];
							// ATTENTION, ceci est pour la gestion des incicents matériels.
							 $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_service_maintenance.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
						case "URGENCE_HYGIENE":
							$email = $config ["email_alerte_urgence_hygiene"];
							// ATTENTION, ceci est pour la gestion des urgences hygiène.
							 $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_urgence_hygiene.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
						case "URGENCE_MAINTENANCE":
							$email = $config ["email_alerte_urgence_maintenance"];
							// ATTENTION, ceci est pour la gestion des urgences maintenance.
							 $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_urgence_maintenance.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
						case "MAINTENANCE":
							$email = $config ["email_alerte_urgence_maintenance"];
							// ATTENTION, ceci est pour la gestion des urgences maintenance.
							 $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_urgence_maintenance.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
                            break;
						case "SUIVI_PERIODIQUES":
							$email = $config ["email_alerte_suivi_periodiques"];
							 $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_suivi_periodiques.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
							break;
						case "RDM_ZONE_FINISHED":
							$email = $config ["email_roadmap_zone_realisee"];
							 $foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_roadmap_zone_realisee.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
							break;
						case "STOCK":
							$email = $config ["email_alerte_stock"];
							$foundConfig = ($email !== "");
                            // Nom du fichier template.
                            $template = "notif_mouvement_stock.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
							break;
						case "RECLAMATION":
							$foundConfig = true;
                           // Nom du fichier template.
                            $template = "notif_reclamation.php";
                            // Liste des envois à effectuer.
                            $mailq = $db->GetMailq ($typeEmail ["nom_type_email"], true);
							break;
						default:
                            $email = "";
                            $foundConfig = false;
                            break;
                    };
                    
                    if ($foundConfig)
                    {
						// Ajout de la cible...
						$mail->AddRecipients($email, "To");
                        // On fait donc l'envoi.
						$nbFault = 0;
                        $nb = 0;
                        foreach ($mailq as $obj)
                        {
                            $id = $obj ["id"];
                            if ($typeEmail["nom_type_email"] == "CONTROLE")
                            {
                                include ("emailer/controle.php");
                            }
							else if ($typeEmail["nom_type_email"] == "DOTATION")
                            {
								include ("emailer/dotation.php");
							}
							else if ($typeEmail["nom_type_email"] == "REMISE_DOTATION")
                            {
								include ("emailer/remise_dotation.php");
							}
							else if ($typeEmail["nom_type_email"] == "MATERIEL")
                            {
								include ("emailer/incident_materiel.php");
							}
							else if ($typeEmail["nom_type_email"] == "HEURES")
                            {
								include ("emailer/heures.php");
							}
							else if ($typeEmail["nom_type_email"] == "FORGOTTEN_PASSWORD")
                            {
								include ("emailer/forgotten_password.php");
							}
							else if ($typeEmail["nom_type_email"] == "INCIDENT_SERVICE_MAINTENANCE")
                            {
								include ("emailer/service_maintenance.php");
							}
							else if ($typeEmail["nom_type_email"] == "URGENCE_HYGIENE")
                            {
								include ("emailer/urgence_hygiene.php");
							}
							else if (($typeEmail["nom_type_email"] == "URGENCE_MAINTENANCE") || ($typeEmail["nom_type_email"] == "MAINTENANCE"))
                            {
								include ("emailer/urgence_maintenance.php");
							}
							else if ($typeEmail["nom_type_email"] == "SUIVI_PERIODIQUES")
                            {
								include ("emailer/suivi_periodiques.php");
							}
							else if ($typeEmail["nom_type_email"] == "RDM_ZONE_FINISHED")
                            {
								include ("emailer/roadmap_zone_realisee.php");
							}
							else if ($typeEmail["nom_type_email"] == "RECLAMATION")
                            {
								include ("emailer/reclamation.php");
							}
							else if ($typeEmail["nom_type_email"] == "STOCK")
                            {
								include ("emailer/stock.php");
							}
                        }
                    }
                ?>
                <?php if ($foundConfig) { ?>Email à qui envoyer les informations : <?php echo $email; ?>. (Nb envoyés : <?php echo $nb; ?> / Nb ignorés : <?php echo $nbFault; ?>)<br><br>
                <?php } else { ?>
                    L'email n'a pas été trouvé dans la configuration. Aucun mail ne sera envoyé pour ce type d'email.<br><br>
                <?php } ?>
            <?php } ?>
		<?php
			}		// foreach cliniques.
		?>
	</div>
	<?php
} // foreach
ob_end_flush ();
?>
</body>
</html>	