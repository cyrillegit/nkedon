<?php
/** ===========================================================================================================================
	Fichier ClassAlertes.php
	------------------------
	Auteur : Jérôme Perciot
	Date : 29/06/2011
	
	Version : 1.0
		- Création du script principal.
		- Lecture des différentes alertes et envoi aux interlocuteurs.
=========================================================================================================================== */

class Alertes
{
	// Pointeur vers la base de données.
	protected $db;
	
	function Alertes ()
	{
		$this->db = NULL;
	}
	
	/**
		Fonction SetDb
		--------------
		Initialisation du pointeur de base de données.
		
		@param pointer $db
		@return null
	*/
	public function SetDb ($db)
	{
		$this->db = $db;
	}
	
	/**
		Fonction GetCountAlertes
		------------------------
		Retourne le nombre d'alertes du backoffice selon ses données.
		Pour chacune de ces alertes, on va afficher le nécessaire dans les alertes.
		UNIQUEMENT pour la date du jour.
		
		@param string $CodeAlerte				// Ce code est du type planning, controle, etc. Cf table t_types_alertes
		@return int
	*/
	public function GetCountAlertes ($CodeAlerte)
	{
		$info = $this->GetAlertes($CodeAlerte);
		if (($info != NULL) && (!empty ($info)))
		{
			return count($info);
		}
		else
		{
			return 0;
		}
	}
	
	/**
		Fonction GetAlertesPersonnel
		----------------------------
		Retourne le nombre d'alertes du salarié du backoffice selon ses données.
		Pour chacune de ces alertes, on va afficher le nécessaire dans les alertes.
		UNIQUEMENT pour la date du jour.
		
		@param int $idSalarie
		@param string $CodeAlerte				// Ce code est du type planning, controle, etc. Cf table t_types_alertes
		@return array
	*/
	public function GetAlertesPersonnel ($idSalarie, $CodeAlerte)
	{
		$info = array ();
		
		$dateDebut = date ("Y-m-d") . " 00:00:00";
		$dateFin = date ("Y-m-d") . " 23:59:59";
		switch ($CodeAlerte)
		{
			case "conges":
				$this->db->SetSql ("select * from t_pointages where id_salarie=$idSalarie and id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='CNG') and ( (date_debut_modif between '$dateDebut' and '$dateFin') or (date_fin_modif between '$dateDebut' and '$dateFin') )");
				
				$info = $this->db->FetchAllRows ();
				break;
			case "absences":
				$this->db->SetSql ("select * from t_pointages where id_salarie=$idSalarie and id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='ABS') and ( (date_debut_modif between '$dateDebut' and '$dateFin') or (date_fin_modif between '$dateDebut' and '$dateFin') )");
				
				$info = $this->db->FetchAllRows ();
				break;
			case "supplementaires":
				$this->db->SetSql ("select * from t_pointages where id_salarie=$idSalarie and id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='SUP') and ( (date_debut_modif between '$dateDebut' and '$dateFin') or (date_fin_modif between '$dateDebut' and '$dateFin') )");
				
				$info = $this->db->FetchAllRows ();
				break;
			case "feuilles_de_route":
				$this->db->SetSql ("SELECT * FROM t_roadmap_zones tleft join t_roadmap_entete on idt_roadmap_entete=id_roadmap left join t_status_zones on idt_status_zones=id_status where abrev='DONE' and id_salarie=$idSalarie and ( (date between '$dateDebut' and '$dateFin') )");
				
				$info = $this->db->FetchAllRows ();
				break;
			case "dotations":
				$this->db->SetSql ("SELECT * FROM t_dotations_entete where id_salarie=$idSalarie and ( (date_demande between '$dateDebut' and '$dateFin') )");
				
				$info = $this->db->FetchAllRows ();
				break;
			case "planning":
				$this->db->SetSql ("SELECT * FROM t_plannings where id_salarie=$idSalarie and ( (date_debut between '$dateDebut' and '$dateFin') or ( date_fin is null or date_fin between '$dateDebut' and '$dateFin') )");
				
				$info = $this->db->FetchAllRows ();
				break;
			case "formations":
				$this->db->SetSql ("SELECT * FROM t_formations left join assoc_salaries_formations on id_formation=idt_formations where id_salarie=$idSalarie and ( (date_debut_formation between '$dateDebut' and '$dateFin') or (date_fin_formation between '$dateDebut' and '$dateFin') )");
				
				$res1 = $this->db->FetchAllRows ();
				
				$this->db->SetSql ("SELECT * FROM t_visites_medicales where id_salarie=$idSalarie and ( (date_visite between '$dateDebut' and '$dateFin') )");
				
				$res2 = $this->db->FetchAllRows ();
				
				$info = @array_merge ($res1, $res2);
				break;
			case "depart":
				$id_clinique = $_SESSION["infoUser"]["idt_cliniques"];
				$idOptionZoneDepart = $this->db->getIdOptionZoneDepart();
				$this->db->SetSql("SELECT 'depart' as keycode_name, heure_fin_interv AS date, nom_sous_zone AS identite FROM t_roadmap_entete re
									JOIN t_roadmap_zones rz on re.idt_roadmap_entete = 
									rz.id_roadmap
									JOIN t_roadmap_sous_zone rsz ON rsz.id_roadmap_zone = rz.idt_roadmap_zones
									JOIN t_sous_zones sz ON sz.idt_sous_zones = rsz.id_sous_zone
									JOIN t_zones z ON z.idt_zones = rz.id_zone
									JOIN t_option_roadmap opt on opt.idt_option_roadmap=rz.id_option_zone
									JOIN t_services_types_zones stz ON stz.idt_services_types_zones = z.id_service_type_zone
									JOIN t_services s on s.idt_services=stz.id_service
									WHERE idt_option_roadmap = $idOptionZoneDepart
									AND date = CURRENT_DATE()
									AND id_clinique = $id_clinique");
				$res1 = $this->db->FetchAllRows ();
				$info = @array_merge ($res1);
			default:
				break;
		};
		return $info;
	}
	
	/**
		Fonction GetAlertes
		-------------------
		Retourne le nombre d'alertes du backoffice selon ses données.
		Pour chacune de ces alertes, on va afficher le nécessaire dans les alertes.
		UNIQUEMENT pour la date du jour.
		
		@param string $CodeAlerte				// Ce code est du type planning, controle, etc. Cf table t_types_alertes
		@return array
	*/
	public function GetAlertes ($CodeAlerte, $idClinique = "")
	{
		$info = array ();
		
		$dateDebut = date ("Y-m-d") . " 00:00:00";
		$dateFin = date ("Y-m-d") . " 23:59:59";
		
		if($idClinique == "")
			$idClinique = $_SESSION["infoUser"]["id_clinique"];
		
		switch ($CodeAlerte)
		{
			case "planning":
				/**
					Pour le planning, nous allons afficher l'alerte, uniquement lorsque le planning est terminé de créer sur le BO ET envoyé. ET aussi dès lors qu'au moins 1 des zones a été signalée terminée...
				*/
				$isAdmin = $this->db->isSalarieAssocManyCliniques($_SESSION["infoUser"]["id_salarie"]);
				if( !$isAdmin )
					$filter = " AND id_clinique = $idClinique";
				else
					$filter = "";
				/*$this->db->SetSql ("select *, 'Feuille de route' as keycode_name, 'ALERT_FEUILLE_DE_ROUTE' as Tip, idt_roadmap_entete as pkid, date_transmission as date 
									from t_roadmap_entete as re
									join t_roadmap_zones as rz on rz.id_roadmap = re.idt_roadmap_entete
									join t_zones as z on z.idt_zones = rz.id_zone
									join t_services_types_zones as stz on stz.idt_services_types_zones = z.id_service_type_zone
									join t_services as s on s.idt_services = stz.id_service
									where date between '$dateDebut' and '$dateFin'
									and re.IsSent=1
									and idt_roadmap_entete in (select distinct id_roadmap from t_roadmap_zones where id_status = (select idt_status_zones from t_status_zones where abrev in ('DONE')))$filter
									GROUP BY idt_roadmap_entete");*/
				$this->db->SetSql ("select *, 'Feuille de route' as keycode_name, 'ALERT_FEUILLE_DE_ROUTE' as Tip, idt_roadmap_entete as pkid, date_transmission as date 
									from t_roadmap_entete as re
									join t_roadmap_zones as rz on rz.id_roadmap = re.idt_roadmap_entete
									join t_zones as z on z.idt_zones = rz.id_zone
									join t_services_types_zones as stz on stz.idt_services_types_zones = z.id_service_type_zone
									join t_services as s on s.idt_services = stz.id_service
									where date between '$dateDebut' and '$dateFin'
									and re.IsSent=1
									and idt_roadmap_entete in (select distinct id_roadmap from t_roadmap_zones)$filter
									GROUP BY idt_roadmap_entete");
				
				$res1 = $this->db->FetchAllRows ();
				if (!empty ($res1))
				{
					foreach ($res1 as &$obj)
					{
						//$obj ["identite"] = $this->db->GetIdentiteSalarieFromIdLogin ($obj ["id_login"], false);
						$obj ["identite"] = $this->db->GetIdentiteSalarieFromIdSalarie ($obj ["id_salarie"], false);
					}
				}
				
				$info = @array_merge ($res1);
				break;
			case "controle":
				$this->db->SetSql ("select *, date_controle as date, 'Contrôle' as keycode_name, 'ALERT_CONTROLE' as Tip, idt_controles_prestations_entete as pkid from t_controles_prestations_entete where date_controle between '$dateDebut' and '$dateFin'");
				$res1 = $this->db->FetchAllRows ();
				if (!empty ($res1))
				{
					foreach ($res1 as &$obj)
					{
						$obj ["identite"] = $this->db->GetIdentiteSalarieFromIdLogin ($obj ["id_login"], false);
					}
				}
				
				$info = @array_merge ($res1);
				break;
			case "personnel":
				break;
			case "heure":
				$this->db->SetSql ("select *, date_demande as date, 'Pointage' as keycode_name, 'ALERT_POINTAGE' as Tip, idt_pointages as pkid from t_pointages where date_demande between '$dateDebut' and '$dateFin'");
				$res1 = $this->db->FetchAllRows ();
				if (!empty ($res1))
				{
					foreach ($res1 as &$obj)
					{
						$obj ["identite"] = $this->db->GetIdentiteSalarieFromIdSalarie ($obj ["id_salarie"], false);
					}
				}
				
				$info = @array_merge ($res1);
				break;
			case "suivi":
				break;
			case "stock":
				$this->db->SetSql ("select *, date_demande as date, 'Mouvement de stock' as keycode_name, 'ALERT_STOCK' as Tip, idt_mouvements_stocks as pkid from t_mouvements_stocks where date_demande between '$dateDebut' and '$dateFin'");
				$res1 = $this->db->FetchAllRows ();
				if (!empty ($res1))
				{
					foreach ($res1 as &$obj)
					{
						$article = $this->db->GetInfoProduit ($obj ["id_article"]);
						if ($obj ["IsReapprovisionnement"])
						{
							$suffixe = "Réappro.";
						}
						else
						{
							$suffixe = "Conso.";
						}
						$obj ["identite"] = $article ["designation"] . "(<em><strong>" . $suffixe . "</strong></em>)";
					}
				}
				
				$info = @array_merge ($res1);
				break;
			case "securite":
				break;
			case "immo":
				$this->db->SetSql ("select *, date_demande as date, 'Incident matériel' as keycode_name, 'ALERT_INCIDENT_MATERIEL' as Tip, idt_incidents_materiels as pkid from t_incidents_materiels where date_demande between '$dateDebut' and '$dateFin'");
				$res1 = $this->db->FetchAllRows ();
				if (!empty ($res1))
				{
					foreach ($res1 as &$obj)
					{
						$data = $this->db->GetInfoMateriel ($obj ["id_materiel"]);
						$obj ["identite"] = $data ["designation"];
					}
				}
				
				$info = @array_merge ($res1);
				break;
			case "urgence":
				// 1°) Urgences de type "Hygiène".
				$isAdmin = $this->db->isSalarieAssocManyCliniques($_SESSION["infoUser"]["id_salarie"]);
				if( !$isAdmin )
					$filter = " AND id_clinique = $idClinique";
				else
					$filter = "";
				$this->db->SetSql ("select *, date_demande as date, 'Urgence Hygiène' as keycode_name, 'ALERT_URGENCE_HYGIENE' as Tip, idt_urgences_hygiene as pkid
									from t_urgences_hygiene as uh
									join t_logins as l on l.idt_logins = uh.id_login
									JOIN assoc_salaries_cliniques as assoc_sc ON assoc_sc.id_salarie = l.id_salarie
									left join t_types_urgences on idt_types_urgences=id_type_urgence
									where date_demande between '$dateDebut' and '$dateFin'$filter
									group by uh.idt_urgences_hygiene");
				$res1 = $this->db->FetchAllRows ();
				if (!empty ($res1))
				{
					foreach ($res1 as &$obj)
					{
						$obj ["identite"] = $obj ["nom_type_urgence"];
					}
				}
				
				// 2°) Urgences de type "Maintenance".
				$this->db->SetSql ("select *, date_demande as date, 'Urgence Maintenance' as keycode_name, 'ALERT_URGENCE_MAINTENANCE' as Tip, idt_urgences_maintenance_entete as pkid
									from t_urgences_maintenance_entete as ugm
									left join t_zones on idt_zones=id_zone
									join t_logins as l on l.idt_logins = ugm.id_login
									JOIN assoc_salaries_cliniques as assoc_sc ON assoc_sc.id_salarie = l.id_salarie
									where date_demande between '$dateDebut' and '$dateFin'$filter
									GROUP BY ugm.idt_urgences_maintenance_entete");
				$res2 = $this->db->FetchAllRows ();
				if (!empty ($res2))
				{
					foreach ($res2 as &$obj)
					{
						$obj ["identite"] = $obj ["nom_zone"];
					}
				}
				
				$info = @array_merge ($res1, $res2);
				break;
			case "cahier_liaison":
				$this->db->SetSql ("select *, date_question as date, 'Cahier de liaison' as keycode_name, 'ALERT_CAHIER_LIAISON' as Tip, idt_cahier_liaison as pkid from t_cahier_liaison where date_question between '$dateDebut' and '$dateFin'");
				
				$res1 = $this->db->FetchAllRows ();
				foreach ($res1 as &$obj)
				{
					if ($obj ["Sens"] == 1)
					{
						$obj ["identite"] = $this->db->GetIdentiteAccreditation ($obj ["id_accreditation_question"]);
					}
					else
					{
						$obj ["identite"] = $this->db->GetIdentiteSalarieFromIdLogin ($obj ["id_login_question"], false);
					}
				}
				$info = @array_merge ($res1);
				break;
			case "depart":
				$id_clinique = $_SESSION["infoUser"]["idt_cliniques"];
				$idOptionZoneDepart = $this->db->getIdOptionZoneDepart();
				$this->db->SetSql("SELECT 'depart' as keycode_name, heure_fin_interv AS date, nom_sous_zone AS identite FROM t_roadmap_entete re
									JOIN t_roadmap_zones rz on re.idt_roadmap_entete = 
									rz.id_roadmap
									JOIN t_roadmap_sous_zone rsz ON rsz.id_roadmap_zone = rz.idt_roadmap_zones
									JOIN t_sous_zones sz ON sz.idt_sous_zones = rsz.id_sous_zone
									JOIN t_zones z ON z.idt_zones = rz.id_zone
									JOIN t_option_roadmap opt on opt.idt_option_roadmap=rz.id_option_zone
									JOIN t_services_types_zones stz ON stz.idt_services_types_zones = z.id_service_type_zone
									JOIN t_services s on s.idt_services=stz.id_service
									WHERE idt_option_roadmap = $idOptionZoneDepart
									AND date = CURRENT_DATE()
									AND id_clinique = $id_clinique");
				$res1 = $this->db->FetchAllRows ();
				$info = @array_merge ($res1);
			
		};
		return $info;
	}
}
?>