<?php
	/**********************************************************************
	*
	* Auteur : Jérôme Perciot
	* Date de création : 04/05/2010
	* Date de modification : 18/05/2011
	*
	***********************************************************************
	* Cette classe permet de gérer les notifications depuis un PC ou un 
	* PDA. On a utilisé l'implémentation de SMSSender pour envoyer un 
	* message à un téléphone.
	*
	* Suivi des notifications à gérer à la fois sur l'ensemble des gens se connectant au
	* BackOffice et aux administrateurs (vue globale). La notion de IsAdministrator est
	* faite pour ça.
	*/
	
	if (!defined ("CLASS_NOTIFICATIONS"))
	{
		define ("CLASS_NOTIFICATIONS", 1);
		
		@session_start ();
		// Ce header indique au serveur qu'on est en mode UTF8.
		header ("Content-type: text/html; character=UTF-8");
		
		class Notifications
		{
			// Pointeur vers la base de données.
			protected $db;
			
			// Status en cours.
			protected $IdStatusCurrent;
			
			// Indique si on est un administrateur (vu sur tout!) ou pas.
			protected $IsAdministrator;
			
			// Agence sur laquelle la personne connectée est déclarée.
			protected $CurrentAgence;
			
			/**
				Constructeur par défaut pour la gestion des notifications.
				Dans le constructeur, on indique quel utilisateur on souhaite analyser.
			*/
			function Notifications ($db)
			{
				$this->db = $db;
				
				$this->IdStatusCurrent = $this->db->GetIdStatusValidation ("dataCellOrange");
				
				// Si la personne connectée est non administrateur, on affichera alors UNIQUEMENT 
				// ses informations propres.
				$this->IsAdministrator = ($_SESSION["infoUser"]["classe"] == "AD") ? true : false;
				$sql = "select id_agence from t_salaries where idt_salaries=" . $_SESSION ["infoUser"]["id_salarie"];
				$res = $this->db->query ($sql);
				$res = $res->fetch();
				$this->CurrentAgence = $res [0];
			}
	
			/**
				Fonction qui permet d'indiquer qu'une notification a bien été prise en compte.
				
				$typeNotification => Il s'agit d'un type de notification.
				$status => On met CURRENT, VALID, INVALID, etc.
				$id => L'id correspondant au type de notification.
				
				@param string $typeNotification
				@param string $status
				@param int $id
				@param array $extra (optionnel)
				@return boolean
			*/
			public function SetNotificationStatus ($typeNotification, $status, $id, $extra = NULL)
			{
				$idStatus = $this->db->GetIdStatusValidation ($status);
				
				$idLogin = $_SESSION ["infoUser"]["idt_logins"];
				if ($status == "dataCellVert")
				{
					$nom_status = "validé(e)";
				}
				else if ($status == "dataCellRouge")
				{
					$nom_status = "refusé(e)";
				}
				$qui = $this->db->GetSalarieIdentite($_SESSION ["infoUser"]["id_salarie"]);
				$identite = $qui ["prenom"]." ".$qui ["nom"];
						
				if ($typeNotification == "ABSENCE")
				{
					// On ajoute dans ce cas un texte explicatif concernant l'alerte qui devra être affichée dans le téléphone.
					$info = $this->db->GetInfoAbsenceAttente ($id);
					
					// Si c'est validé ou validé avec modification.
					if ( in_array($status, array ("dataCellVert")) )
					{
						if ($info ["id_chantier"] == "")
						{
							$info ["id_chantier"] = "NULL";
						}
						
						$sql = "INSERT INTO t_referentiel_heures 
								(id_chantier, id_salarie, date_debut, date_fin, heure_debut, heure_fin, id_type_absence, id_heure_semainier, id_type_changement_heure, 
								remarques, id_pointage_origine) 
								VALUES (".$info ["id_chantier"].", ".$info ["id_salarie"].", 
								'".$info ["date_changement_horaire_debut"]."', '".$info ["date_changement_horaire_fin"]."', '".$info ["heure_debut"]."', 
								'".$info ["heure_fin"]."', ".$info ["id_type_absence"].", ".($info ["id_heure_semainier"] == "" ? "NULL" : $info ["id_heure_semainier"]).", ".$info ["id_type_changement_heure"].", '".str_replace ("'", "''", $info ["remarques"])."',
								$id)";
						$this->db->Execute ($sql);
					}
				}
				else if ($typeNotification == "SOUS_TRAITANCE")
				{
					// Mise à jour directement dans le backoffice avec les bonnes informations.
					$info = $this->db->GetInfoGestionSousTraitant ($id);
					$info ["sousTraitant"] = $this->db->GetInfoSousTraitant ($info ["id_sous_traitant"]);
					$info ["presta"] = $this->db->GetInfoPrestationSousTraitant ($info ["id_presta_sous_traitant"]);
					
					if ( in_array($status, array ("dataCellVert")) )
					{
						// Si on valide.
						$this->db->Execute ("UPDATE assoc_prestations_sous_traitants_chantiers SET is_affected=0 WHERE id_prestation_sous_traitant=" . $info ["id_presta_sous_traitant"]);
						$this->db->Execute ("UPDATE assoc_prestations_sous_traitants_chantiers SET is_affected=1, id_frequence=".$info ["id_frequence"].", date_debut_intervention='".$info ["date_debut"]."', date_fin_intervention='".$info ["date_fin"]."' WHERE id_prestation_sous_traitant=" . $info ["id_presta_sous_traitant"] . " and id_sous_traitant=" . $info ["id_sous_traitant"] . " and id_chantier=" . $info ["id_chantier"]);
					}
				}
				else if ($typeNotification == "DEVIS")
				{
					// Ajout du texte explicatif quant au devis refusé et non intégré dans le BackOffice.
					$sql = "select * from t_gestion_devis gd 
							left join t_logins l on l.idt_logins=gd.id_login
							left join t_salaries s on s.idt_salaries=l.id_salarie
							 where idt_gestion_devis=$id";
					$res = $this->db->query ($sql);
					$info = $res->fetch ();
					
					if ( in_array($status, array ("dataCellVert")) )
					{
						$idProspect = 0;
						$idClinique = 0;
						if ($extra["TypeDevis"] == 1)
						{
							$idProspect = $extra["IdProspect"];
						}
						else
						{
							$idClinique = $extra["IdChantier"];
						}
						// Le détail maintenant du devis, avec les bâtiments, et tout le reste.
						// Il sera affiché sous la forme d'un ul/li.
						$info ["details"] = $this->db->GetDetailsDevis ($info ["idt_gestion_devis"]);
						
						// On va donc ici créer le devis de toute pièce conformément à l'alerte.
						$numeroDevis = $this->db->GetAvailableNumeroDevis ();
						if ($extra["TypeDevis"] == 1)
							$sql = "INSERT INTO t_prospection (numero_devis, date_creation, finished, id_prospect, id_login) VALUES ('$numeroDevis', '".$info ["date_demande"]."', 0,  $idProspect, ".$info ["id_login"].")";
						else
							$sql = "INSERT INTO t_prospection (numero_devis, date_creation, finished, id_chantier, id_login) VALUES ('$numeroDevis', '".$info ["date_demande"]."', 0,  $idClinique, ".$info ["id_login"].")";
						
						error_log ($sql);
						$ok = $this->db->Execute ($sql);
						if ($ok)
						{
							// On peut donc gérer les détails de ce devis.
							$idDevis = $this->db->GetLastInsertedId ();
							foreach ($info ["details"] as $detail)
							{
								$idBatiment = $this->db->GetPkid ("t_prospection_batiments", "idt_prospection_batiments", array ("nom_batiment" => $detail ["NomBatiment"], "id_prospection" => $idDevis));
								if ($idBatiment == 0)
								{
									$sql = "INSERT INTO t_prospection_batiments (id_prospection, nom_batiment) VALUES ($idDevis, '".$detail ["NomBatiment"]."')";
									
									error_log ($sql);
									$ok &= $this->db->Execute ($sql);
									if ($ok)
									{
										$idBatiment = $this->db->GetLastInsertedId ();
									}
								}
								if ($ok)
								{
									// On peut donc maintenant, réaliser la zone liée à ce bâtiment.
									$idTypeEtage = $this->db->GetIdTypeEtageFromLevel ($detail ["NumeroNiveau"]);
									if ($idTypeEtage == "") $idTypeEtage = 3;
									$freq = $this->db->GetAllFrequences ();
									// La 1ère qui vient.
									$idFrequence = $freq [0]["idt_frequences"];
									$idTypeSol = $detail ["IdTypeSol"];
									$nomZone = str_replace ("'", "''", $detail ["NomZone"]);
									$superficie = $detail ["Superficie"];
									$superficie = ($superficie == "" ? "0" : $superficie);
									$idTypeZone = $detail ["IdTypeZone"];
									$cadence = $this->db->GetCadenceValue ( $idTypeZone, $detail ["Qualite"]);
									
									$sql = "INSERT INTO t_prospection_zones (id_prospection_batiment, id_frequence, cadence, id_type_sol, superficie, id_type_etage, nom_zone, id_type_zone) 
									VALUES ($idBatiment, $idFrequence, $cadence, $idTypeSol, '$superficie', $idTypeEtage, '$nomZone', $idTypeZone)";
									$ok &= $this->db->Execute ($sql);
									
									error_log ($sql);
									if ($ok)
									{
										// Les prestations également. Bug N°633.
										$idZone = $this->db->GetLastInsertedId ();
										
										$sql = "select id_prestation from assoc_prestations_types_locaux where id_type_local=$idTypeZone";
										$this->db->SetSql ($sql);
										$prestations = $this->db->FetchAllRows ();
										foreach ($prestations as $prest)
										{
											$this->db->Execute ("INSERT INTO t_prospection_prestations(id_prospection_zone, id_prestation) VALUES ($idZone, ".$prest ["id_prestation"].")");
										}
									}
								}
								else
								{
									error_log ("VALIDATION DEVIS (FAULT) : " . $sql);
								}
							}
						}
					}

					return $ok;
				}
				else if ($typeNotification == "DETACHEMENT")
				{
					// On ajoute dans ce cas un texte explicatif concernant l'alerte qui devra être affichée dans le téléphone.
					$info = $this->db->GetInfoDetachement ($id);
				}
				else if ($typeNotification == "NOUVEAU_SALARIE")
				{
					// On ajoute dans ce cas un texte explicatif concernant l'alerte qui devra être affichée dans le téléphone.
					$info = $this->db->GetInfoNouveauSalarie ($id);
					$ok = false;
					
					if ( in_array($status, array ("dataCellVert")) )
					{
						$idStatus = $this->db->GetIdStatusValidation ("dataCellVert");
						if ($this->db->SetAdresse (0, $info ["adresse"], "", $info ["code_postal"], $info ["ville"]))
						{
							// Création du nouvel employé directement dans le backoffice.
							$ok = $this->db->SetSalarie (0, $_POST ["civilite"], $info ["prenom"], $info ["nom"], $this->db->GetLastInsertedId (), $this->db->GetAvailableNumeroMatricule ($_SESSION["infoUser"]["id_agence"]), $info ["telephone"], "", 0, 
								$info ["email"], $_POST ["groupe_salarie"], $_POST ["numero_securite_sociale"], 0, FrenchDateToSQLDate($_POST ["date_naissance"]),
								"", "", $_POST ["nationalite"], "", "", $_SESSION["infoUser"]["id_agence"]);
							if ($ok)
							{
								$this->db->Execute ("update t_gestion_nouveau_salarie set id_status_demande=$idStatus, date_validation=CURRENT_TIMESTAMP, id_login_validation=" . $_SESSION["infoUser"]["idt_logins"] . " where idt_gestion_nouveau_salarie=$id");
							}
						}
					}
					return $ok;
				}
				else if ($typeNotification == "INCIDENT_MATERIEL")
				{
					// On valide et par la même occasion, on va indiquer s'il s'agit d'un succès ou d'un refus de validation.
					try
					{
						$this->db->beginTransaction ();
						
						$sql = "SELECT * from t_gestion_materiels WHERE idt_gestion_materiels=$id";
						$res = $this->db->query ($sql);
						$res = $res->fetch ();
						if ($res ["id_status_demande"] == $this->IdStatusCurrent)
						{
							$sql = "UPDATE t_gestion_materiels SET id_status_demande=$idStatus, date_validation=CURRENT_TIMESTAMP WHERE idt_gestion_materiels=$id";
							$this->db->Execute ($sql);
							$this->db->commit ();
						}
						else
							$this->db->rollBack ();
					}
					catch (PDOException $e)
					{
						$this->db->rollBack ();
						$mail = new Mail ();
					
						$mail->AddSubject("Surikat Nettoyage -- Fonction Notifications::SetNotificationStatus");
						$mail->AddRecipients(array ("Jérôme Perciot" => Configuration::getValue ("admin_mail")), "To");
						$body = " 
						<html>
						<head>
						</head>
						<body>
						<b><h2>Site Surikat Nettoyage</h2></b><br />
						Description de l'erreur :<br />".$e->getMessage()."
						<br />
						Fichier source : ".$e->getFile()."<br />
						Ligne : ".$e->getLine().".<br /><br /><br />
						L'équipe informatique
						</body>
						</html>";
						$mail->AddBody($body);
						$mail->sendMail();
					}
				}
				else if ($typeNotification == "HEURE_SUPPLEMENTAIRE")
				{
					// On ajoute dans ce cas un texte explicatif concernant l'alerte qui devra être affichée dans le téléphone.
					$info = $this->db->GetInfoHeureSupplementaireAttente ($id);
					
					// Si c'est validé ou validé avec modification.
					if ( in_array($status, array ("dataCellVert")) )
					{
						if ($info ["id_chantier"] == "")
						{
							$info ["id_chantier"] = "NULL";
						}
						
						$sql = "INSERT INTO t_referentiel_heures 
								(id_chantier, id_salarie, date_debut, date_fin, heure_debut, heure_fin, id_type_heure, id_heure_semainier, id_type_changement_heure, remarques, id_pointage_origine) 
								VALUES (".$info ["id_chantier"].", ".$info ["id_salarie"].", 
								'".$info ["date_changement_horaire_debut"]."', '".$info ["date_changement_horaire_fin"]."', '".$info ["heure_debut"]."', 
								'".$info ["heure_fin"]."', ".$info ["id_type_heure"].", ".($info ["id_heure_semainier"] != "" ? $info ["id_heure_semainier"] : "NULL").", ".$info ["id_type_changement_heure"].", '".str_replace ("'", "''", $info ["remarques"])."', $id)";
						$this->db->Execute ($sql);
					}
				}
				else if ($typeNotification == "DETACHEMENT")
				{
					// On ajoute dans ce cas un texte explicatif concernant l'alerte qui devra être affichée dans le téléphone.
					$info = $this->db->GetInfoDetachement ($id);
					// Si c'est validé ou validé avec modification.
					if ( in_array($status, array ("dataCellVert")) )
					{
						$idCliniqueOrigine = $info ["id_chantier"];
						$idCliniqueDetachement = $info ["id_chantier_detachement"];
						// Par contre, ce sont des heures normales. Donc, l'id est HN dans le type d'heure...
						/*$sql = "INSERT INTO t_referentiel_heures 
								(id_chantier, id_salarie, date_debut, date_fin, heure_debut, heure_fin, id_type_heure, id_heure_semainier, id_type_changement_heure, remarques) 
								VALUES (".$info ["id_chantier"].", ".$info ["id_salarie"].", 
								'".$info ["date_changement_horaire_debut"]."', '".$info ["date_changement_horaire_fin"]."', '".$info ["heure_debut"]."', 
								'".$info ["heure_fin"]."', ".$info ["id_type_heure"].", ".($info ["id_heure_semainier"] != "" ? $info ["id_heure_semainier"] : "NULL").", ".$info ["id_type_changement_heure"].", '".$info ["remarques"]."')";
						$this->db->Execute ($sql);*/
					}
				}
				else if ($typeNotification == "CONGE")
				{
					// On ajoute dans ce cas un texte explicatif concernant l'alerte qui devra être affichée dans le téléphone.
					$info = $this->db->GetInfoConge ($id);
					// Si c'est validé ou validé avec modification.
					if ( in_array($status, array ("dataCellVert")) )
					{
						$idTypeChangementHoraire = $this->db->GetIdTypeChangementHoraire ("HCNG");
						$sql = "INSERT INTO t_referentiel_heures 
								(id_salarie, date_debut, date_fin, heure_debut, heure_fin, id_type_conge, id_type_changement_heure, id_pointage_origine) 
								VALUES (".$info ["id_salarie"].", 
								'".$info ["date_changement_horaire_debut"]."', '".$info ["date_changement_horaire_fin"]."', NULL, 
								NULL, ".$info ["id_type_conge"].", $idTypeChangementHoraire, $id)";
						$this->db->Execute ($sql);
					}
				}
				else if ($typeNotification == "DOTATION")
				{
					// On ajoute dans ce cas un texte explicatif concernant l'alerte qui devra être affichée dans le téléphone.
					$info = $this->db->GetInfoDotation ($id);
					// Si c'est validé ou validé avec modification.
					if ( in_array($status, array ("dataCellVert")) )
					{
						/**
							On fait la validation de la demande de dotation ici.
						*/
						$reference = $info ["reference"];
						if ($this->db->Exists ("t_dotations_entete", array ("reference" => $reference)))
						{
							$reference = $this->db->GenerateRandomSID(25);
						}
						
						$sql = "INSERT INTO t_dotations_entete (id_salarie, id_motif, reference, remarques, id_status_demande, date) VALUES (".$info ["id_salarie_concerne"].", ".$info ["id_motif"].", '".$reference."', '".$info ["remarques"]."', $idStatus, '".$info ["date_demande"]."')";
						if ($this->db->Execute ($sql))
						{
							$pkid = $this->db->GetLastInsertedId ();
							$details = $this->db->GetDetailsDotation ($id);
							foreach ($details as $obj)
							{
								$this->db->Execute ("INSERT INTO t_dotations_details (id_dotation_entete, id_epi, quantite) VALUES ($pkid, ".$obj ["id_epi"].", ".$obj ["quantite"].")");
							}
							
							$this->db->Execute ("UPDATE t_gestion_dotations_entete SET date_validation=CURRENT_TIMESTAMP where idt_gestion_dotations_entete=$id");
						}
					}
				}
			}
			
			/**
			 * Fonction GetCountAlertes
			 * ------------------------
			 * Retourne le nombre d'alertes disponibles.
			 *
			 * @return decimal
			 */
			public function GetCountAlertes ()
			{
				$nb = $this->GetCountAlertesHeuresAbsence() + 
					$this->GetCountAlertesHeuresSupplementaires () + 
					$this->GetCountAlertesHeuresDetachement () + 
					$this->GetCountAlertesControles () + 
					$this->GetCountAlertesConges () + 
					$this->GetCountAlertesDotations () + 
					$this->GetCountNouveauxSalaries() + 
					$this->GetCountAlertesDevis () + 
					$this->GetCountAlertesContrats ();
					
				return $nb;
			}
			
			/**
				GetCountAlertesHeuresAbsence
				----------------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountAlertesHeuresAbsence ()
			{
				$and = "";
				
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_heures where id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='HABS')
				and id_login in (select distinct idt_logins from t_logins where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and))";
				
				//echo $sql."<br />";
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesHeuresSupplementaires
				------------------------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountAlertesHeuresSupplementaires ( $idClinique = 0)
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_heures where id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='HSUP')
				and id_login in (select distinct idt_logins from t_logins where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and))";
				
				if ($idClinique > 0) $sql .= " and id_chantier=$idClinique";
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountNouveauxSalaries
				------------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountNouveauxSalaries ()
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_nouveau_salarie where id_status_demande<>1 and id_login in (select distinct idt_logins from t_logins where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and))";
				
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesContrats
				-----------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountAlertesContrats ()
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_contrats where id_login in (select distinct idt_logins from t_logins where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and))";
				
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesConges
				---------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountAlertesConges ( $idClinique = 0)
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_heures gc
				where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and) and id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='HCNG') and gc.read=0";
				
				if ($idClinique > 0) $sql .= " and id_chantier=$idClinique";
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesHeuresDetachement
				--------------------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountAlertesHeuresDetachement ( $idClinique = 0)
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_heures where id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='HDET')
				and id_login in (select distinct idt_logins from t_logins where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and))";
				
				if ($idClinique > 0) $sql .= " and id_chantier=$idClinique";
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesControles
				------------------------
				Comptabilise le nombre d'alertes disponibles.
				
				ATTENTION, uniquement celles qui n'ont pas encore été lues.
			*/
			public function GetCountAlertesControles ()
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_controles_prestations_entete where id_login in (select distinct idt_logins from t_logins where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and)) and t_gestion_controles_prestations_entete.read=0 ";
				
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesDevis
				--------------------
				Comptabilise le nombre d'alertes disponibles.
				
				ATTENTION, uniquement celles qui n'ont pas encore été lues.
			*/
			public function GetCountAlertesDevis ()
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$idStatus = $this->db->GetIdStatusValidation ("dataCellOrange");
				$sql = "select count(*) as nb from t_gestion_devis where id_login in (select distinct idt_logins from t_logins where id_salarie in (select distinct idt_salaries from t_salaries where 1 $and)) and id_status_demande=$idStatus";
	
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesAbsences
				-----------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountAlertesAbsences ( $idClinique = 0)
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_heures where id_type_changement_heure=(select idt_types_horaires from t_types_horaires where abrev='HABS') and id_salarie in (select distinct idt_salaries from t_salaries where 1 $and) and t_gestion_heures.read=0 ";
				
				if ($idClinique > 0) $sql .= " and id_chantier=$idClinique";
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
			
			/**
				GetCountAlertesDotations
				------------------------
				Comptabilise le nombre d'alertes disponibles.
			*/
			public function GetCountAlertesDotations ()
			{
				if (!$this->IsAdministrator)
				{
					// Sur sur UNIQUEMENT l'agence en cours.
					$and = " and id_agence=" . $this->CurrentAgence;
				}
				$sql = "select count(*) as nb from t_gestion_dotations_entete where id_status_demande=1 and id_salarie_concerne in (select distinct idt_salaries from t_salaries where 1 $and)";
				
				$res = $this->db->query ($sql);
				if ($res)
				{
					$res = $res->fetch (PDO::FETCH_ASSOC);
					return $res ["nb"];
				}
				else
					return 0;
			}
		}
	}
?>