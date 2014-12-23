<?php
$info = $db->GetInfoLogin ($id);
// Si le contrôle est celui de la clinique en cours, on peut l'envoyer par email.
if ($info)
{
	$salarie = $db->GetInfoSalarie ($info ["id_salarie"]);
	$mail->SetBodyFromFile(Configuration::getValue ("html_templates") . $template, 
		array 
		(
			"IDENTITE_GV"			=> $db->GetIdentiteSalarieFromIdLogin ($info ["id_login"], true),
			"LOGIN"					=> $info ["login"],
			"PASSWORD"				=> $info ["temp_password"],
			"NOM"					=> $salarie ["nom_civil"],
			"PRENOM"				=> $salarie ["prenom"],
			"HTTP_HOME"				=> Configuration::getValue ("http_home")
		));
	$mail->AddSubject("Surik@ Santé > Perte de votre mot de passe");
	if ($mail->sendMail())
	{
		// On notifie que le mail est bien parti, pour ne pas le renvoyer inutilement
		if ($db->Execute ("UPDATE t_mailq SET sent=1, date_envoi=CURRENT_TIMESTAMP WHERE idt_mailq=" . $obj ["idt_mailq"]))
		{
			// On modifie ici le mdp de base (temp_password) pour le remettre à NULL.
			$db->Execute ("UPDATE t_logins SET temp_password=NULL where idt_logins=" . $info ["idt_logins"]);
		}
		$nb++;
	}
	else
	{
		$nbFault++;
	}
}
?>