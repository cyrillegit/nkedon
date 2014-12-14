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

isset( $_POST ["id_facture"] ) ? $id = $_POST ["id_facture"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["numero_facture"] ) ? $numero_facture = addslashes(htmlspecialchars($_POST ["numero_facture"])) : $numero_facture = "";
	isset( $_POST ["nombre_produit"] ) ? $nombre_produit = addslashes(htmlspecialchars($_POST ["nombre_produit"])) : $nombre_produit = "";
	isset( $_POST ["id_fournisseur"] ) ? $id_fournisseur = addslashes(htmlspecialchars($_POST ["id_fournisseur"])) : $id_fournisseur = "";
	isset( $_POST ["date_facture"] ) ? $date_facture = addslashes(htmlspecialchars($_POST ["date_facture"])) : $date_facture = "";

	//Mode création (post:insert)
	if( $id == 0 )
	{
		if( $numero_facture != NULL && $nombre_produit != NULL && $id_fournisseur != NULL && $date_facture != NULL)
		{
			$ok = true;
			if($date_facture != "")
			{
				$ok &= validateDate($date_facture);
			}
			else
			{
				$date_facture = "00/00/0000";
			}

			$ok &= isNumber($nombre_produit);

			if( $ok )
			{
				$date_facture = FrenchDateToSQLDate($date_facture);
				$date_insertion_facture = setLocalTime();

				$sql = "INSERT INTO t_factures
							(numero_facture,
							 nombre_produit,
							 id_fournisseur,
							 date_facture,
							 date_insertion_facture)
				VALUES ('$numero_facture',
						'$nombre_produit',
						'$id_fournisseur',
						'$date_facture',
						'$date_insertion_facture')";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion de la facture en base de données...'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car certaines valeurs de la facture sont invalides...'})";
			}				
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values de la facture sont nulles... '})";
		}
		
	}
	//Mode mise à jour (post:update)
	else
	{
		if( $numero_facture != NULL && $nombre_produit != NULL && $id_fournisseur != NULL && $date_facture != NULL && $date_insertion_facture != NULL)
		{
			$ok = true;
			if($date_facture != "")
			{
				$ok &= validateDate($date_facture);
			}
			else
			{
				$date_facture = "00/00/0000";
			}

			if($ok)
			{
				$date_facture = FrenchDateToSQLDate($date_facture);
				$sql = "UPDATE t_factures
						SET numero_facture = '$numero_facture',
							nombre_produit = '$nombre_produit',
							id_fournisseur = '$id_fournisseur',
							date_facture = '$date_facture',
							date_insertion_facture = '$date_insertion_facture'
						WHERE idt_factures = $id";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données... '})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour de la facture en base de données, car la date est invalide... '})";
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