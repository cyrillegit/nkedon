<?php
/* File: edit_produit.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier une facture.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_facture"] ) ? $id_facture = $_POST ["id_facture"] : $id_facture = NULL;
if( $id_facture != NULL )
{
	isset( $_POST ["numero_facture"] ) ? $numero_facture = addslashes(htmlspecialchars($_POST ["numero_facture"])) : $numero_facture = "";
	isset( $_POST ["id_fournisseur"] ) ? $id_fournisseur = addslashes(htmlspecialchars($_POST ["id_fournisseur"])) : $id_fournisseur = "";
	isset( $_POST ["date_facture"] ) ? $date_facture = addslashes(htmlspecialchars($_POST ["date_facture"])) : $date_facture = "";

	//Mode création (post:insert)
	if( $id_facture == 0 )
	{
		if( $numero_facture != NULL && $id_fournisseur != NULL && $date_facture != NULL)
		{
			$ok = true;
			$okFacture = true;

			$infoAllFactures = $db->getAllFactures();
			foreach ( $infoAllFactures as $infoFacture ) 
			{
				if( $infoFacture["numero_facture"] == $numero_facture && $infoFacture["id_fournisseur"] == $id_fournisseur )
				{
					$ok &= false;
				}
			}


			$nombre_produit = $db->getNbProduitsDistintsAchetes();

			if( $date_facture != "" )
			{
				$ok &= validateDate( $date_facture );
			}
			else
			{
				$date_facture = "00/00/0000";
			}

			if( $ok )
			{
				$infoAllProduitsAchetes = $db->getAllProduitsAchetes();
				$date_facture = FrenchDateToSQLDate( $date_facture );
				$date_insertion_facture = setLocalTime();

				$sql = "INSERT INTO t_factures
							(numero_facture,
							 nombre_produit,
							 id_fournisseur,
							 date_facture,
							 date_insertion_facture,
							 status)
				VALUES ('$numero_facture',
						'$nombre_produit',
						'$id_fournisseur',
						'$date_facture',
						'$date_insertion_facture',
						0)";

				if( $db->Execute ( $sql ) )
				{
					$id_facture = $db->lastInsertId();

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

					if($okFacture)
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
					echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car la date est invalide ou il existe déja une facture avec le même numéro et le même fournisseur.'})";
			}				
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values de la facture sont nulles. '})";
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