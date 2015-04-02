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

if(isset($_SESSION["id_facture"])) unset( $_SESSION["id_facture"] );

isset( $_POST ["id_facture"] ) ? $id = $_POST ["id_facture"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["numero_facture"] ) ? $numero_facture = addslashes(htmlspecialchars($_POST ["numero_facture"])) : $numero_facture = "";
	isset( $_POST ["id_fournisseur"] ) ? $id_fournisseur = addslashes(htmlspecialchars($_POST ["id_fournisseur"])) : $id_fournisseur = "";
	isset( $_POST ["date_facture"] ) ? $date_facture = addslashes(htmlspecialchars($_POST ["date_facture"])) : $date_facture = "";
    isset( $_POST ["commentaire"] ) ? $commentaire = addslashes(htmlspecialchars($_POST ["commentaire"])) : $commentaire = "";
    $id_user = $_SESSION["infoUser"]["idt_users"];
	//Mode création (post:insert)
	if( $id == 0 )
	{
		if( $numero_facture != NULL && $id_fournisseur != NULL && $date_facture != NULL)
		{
			$ok = true;
			$okFacture = true;

            // check unicity of the bill
			$infoAllFactures = $db->getAllFactures();
			foreach ( $infoAllFactures as $infoFacture ) 
			{
				if( $infoFacture["numero_facture"] == $numero_facture && $infoFacture["id_fournisseur"] == $id_fournisseur )
				{
					$ok &= false;
				}
			}

            // get the number of products of this bill
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
                // get all products of this bill
				$infoAllProduitsAchetes = $db->getAllProduitsAchetes();
				$date_facture = FrenchDateToSQLDate( $date_facture );
				$date_insertion_facture = setLocalTime();

				$sql = "INSERT INTO t_factures
							(numero_facture,
							 nombre_produit,
							 id_fournisseur,
							 date_facture,
							 date_insertion_facture,
							 id_user,
							 commentaire,
							 id_inventaire)
				VALUES ('$numero_facture',
						'$nombre_produit',
						'$id_fournisseur',
						'$date_facture',
						'$date_insertion_facture',
						'$id_user',
						'$commentaire',
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
			echo "({'result': 'Une erreur est survenue car certaines valeurs de la facture sont nulles. '})";
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
							date_insertion_facture = '$date_insertion_facture',
							id_user = '$id_user',
							commentaire = '$commentaire'
						WHERE idt_factures = '$id'";

				if( $db->Execute ( $sql ) )
				{
					$sql = "DELETE FROM t_achats WHERE id_facture = '$id' ";
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
									'$id',
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