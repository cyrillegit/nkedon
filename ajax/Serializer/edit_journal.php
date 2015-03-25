<?php
/* File: edit_journal.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier un journal.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_journal"] ) ? $id = $_POST ["id_journal"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["commentaire"] ) ? $commentaire = addslashes(htmlspecialchars($_POST ["commentaire"])) : $commentaire = "";
	//Mode création (post:insert)
	if( $id == 0 )
	{
        $ok = true;
        $okOperation = true;
        $id_user = $_SESSION["infoUser"]["idt_users"];
            // check unicity of the journal per day
//			$infoAllJournal = $db->getAllJournal();
//            $date_now = setLocalTime();
//			foreach ( $infoAllJournal as $info )
//			{
//				if( $info["date_journal"] == $date_now )
//				{
//					$ok &= false;
//				}
//			}

            // get the number of products of this bill
			$nombre_operation = $db->getNbOperationsJournal();

			if( $ok )
			{
                // get all products of this bill
				$infoAllOperationsJournal = $db->getAllOperationsJournal();
				$date_journal = setLocalTime();

				$sql = "INSERT INTO t_journal
							(date_journal,
							 commentaire,
							 id_user)
				VALUES ('$date_journal',
						'$commentaire',
						'$id_user')";

				if( $db->Execute ( $sql ) )
				{
					$id_journal = $db->lastInsertId();

					foreach ($infoAllOperationsJournal as $info)
					{
						$id_produit = $info["id_produit"];
						$quantite_vendue = $info["quantite_vendue"];
						$numero_operation = $info["numero_operation"];

						$sql1 = "INSERT INTO t_operations
									(numero_operation,
									 id_produit,
									 quantite_vendue,
							 		id_journal)
						VALUES ('$numero_operation',
						        '$id_produit',
								'$quantite_vendue',
								'$id_journal')";
						
						if($db->Execute($sql1))
						{
							$okOperation &= true;
						}
						else
						{
                            $okOperation &= false;
						}
					}

					if($okOperation)
					{
						$sql = "DELETE FROM t_produits_operations";

						if($db->Execute($sql))
						{
							$db->commit ();
							echo "({'result': 'SUCCESS'})";
						}
						else
						{
							$db->rollBack();
							echo "({'result': 'Une erreur est survenue lors de l \'insertion du journal en base de données.'})";
						}
					}
					else
					{
						$db->rollBack();
						echo "({'result': 'Une erreur est survenue lors de l \'insertion des operations du journal en base de données.'})";
					}
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion de la création du journal en base de données.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue. Impossible de réaliser plusieurs journaux pendant un même jour.'})";
			}
		
	}
	//Mode mise à jour (post:update)
	else
	{
		if( $numero_facture != NULL && $id_fournisseur != NULL && $date_facture != NULL)
		{
			$ok = true;
			$okFacture = true;

			$nombre_produit = $db->getNbProduitsDistintsAchetes();
			if($date_facture != "")
			{
				$ok &= validateDate($date_facture);
			}
			else
			{
				$date_facture = "00/00/0000";
			}

			if( $ok )
			{
				$infoAllProduitsAchetes = $db->getAllProduitsAchetes();
				$date_facture = FrenchDateToSQLDate($date_facture);
				$date_insertion_facture = setLocalTime();

				$sql = "UPDATE t_factures
						SET numero_facture = '$numero_facture',
							nombre_produit = '$nombre_produit',
							id_fournisseur = '$id_fournisseur',
							date_facture = '$date_facture',
							date_insertion_facture = '$date_insertion_facture'
						WHERE idt_factures = '$id_facture'";

				if( $db->Execute ( $sql ) )
				{
					$sql = "DELETE FROM t_achats WHERE id_facture = '$id_facture' ";
					if( $db->Execute ( $sql ) )
					{
						foreach ($infoAllProduitsAchetes as $info) 
						{
							$id_produit = $info["id_produit"];
							$quantite_achat = $info["quantite_achat"];
							$date_fabrication = $info["date_fabrication"];
							$date_peremption = $info["date_peremption"];

							$sql = "INSERT INTO t_achats
										(id_produit,
										 id_facture,
										 quantite_achat ,
								 		 date_fabrication,
								 		 date_peremption)
							VALUES ('$id_produit',
									'$id_facture',
									'$quantite_achat',
									'$date_fabrication',
									'$date_peremption')";
							
							if($db->Execute($sql))
							{
								$okFacture &= true;
							}
							else
							{
								$okFacture &= false;
							}
						}

						if( $okFacture )
						{
							$sql = "DELETE FROM t_produits_factures";

							if($db->Execute($sql))
							{
								$db->commit ();
								echo "({'result': 'SUCCESS'})";
							}
							else
							{
								$db->rollBack();
								echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
							}
						}
						else
						{
							$db->rollBack();
							echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
						}
					}
					else
					{
						$db->rollBack();
						echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données.'})";
					}
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données, car certaines valeurs de la facture sont invalides.'})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données car certaines valeurs sont nulles '})";
		}
	}
}
else
{
	@header("Location: ../index.php");
}
?>