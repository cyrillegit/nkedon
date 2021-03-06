<?php
/* File: produits_facture.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier un produit dans une facture.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_produit_achat"] ) ? $id = $_POST ["id_produit_achat"] : $id = NULL;

if( $id != NULL )
{
	isset( $_POST ["nom_produit_search"] ) ? $nom_produit = strtoupper(addslashes(htmlspecialchars($_POST ["nom_produit_search"]))) : $nom_produit = "";
	isset( $_POST ["quantite_achat"] ) ? $quantite_achat = addslashes(htmlspecialchars($_POST ["quantite_achat"])) : $quantite_achat = "";
	isset( $_POST ["date_fabrication"] ) ? $date_fabrication = addslashes(htmlspecialchars($_POST ["date_fabrication"])) : $date_fabrication = "";
	isset( $_POST ["date_peremption"] ) ? $date_peremption = addslashes(htmlspecialchars($_POST ["date_peremption"])) : $date_peremption = "";

	//Mode création (post:insert)
	if( $id == 0 )
	{
		if( $nom_produit != NULL && $quantite_achat != NULL )
		{
			$ok = true;

            $produit = $db->getInfoProduitByNom( $nom_produit );
            $id_produit = $produit["idt_produits"];

			if( $id_produit != NULL )
			{
				$ok &= true;
			}

			$ok &= isNumber( $quantite_achat );

			if( $date_fabrication != "" )
			{
				$ok &= validateDate( $date_fabrication );
			}
			else
			{
				$date_fabrication = "0000/00/00";
			}

			if( $date_peremption != "" )
			{
				$ok &= validateDate( $date_peremption );
			}
			else
			{
				$date_peremption = "0000/00/00";
			}

			if( $ok )
			{
				$date_fabrication = FrenchDateToSQLDate( $date_fabrication );
				$date_peremption = FrenchDateToSQLDate( $date_peremption );

				$sql = "INSERT INTO t_produits_achats
							(id_produit,
							 quantite_achat,
							 date_fabrication,
							 date_peremption)
				VALUES ('$id_produit',
						'$quantite_achat',
						'$date_fabrication',
						'$date_peremption')";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion du produit dans la facture.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car certaines valeurs de ce produit sont invalides.'})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values du produit sont nulles. '})";
		}

	}
	//Mode mise à jour (post:update)
	else
	{
		if( $nom_produit != NULL && $quantite_achat != NULL )
		{
			$ok = true;

			$id_produit = $db->getIdProduitByNom( $nom_produit );

			$ok &= isNumber($quantite_achat);
			if( $date_fabrication != "" )
			{
				$ok &= validateDate( $date_fabrication );
			}
			else
			{
				$date_fabrication = "000/00/00";
			}

			if( $date_peremption != "" )
			{
				$ok &= validateDate( $date_peremption );
			}
			else
			{
				$date_peremption = "000/00/00";
			}

			if($ok)
			{
				$date_fabrication = FrenchDateToSQLDate( $date_fabrication );
				$date_peremption = FrenchDateToSQLDate( $date_peremption );

				$sql = "UPDATE t_produits_achats
						SET id_produit = '$id_produit',
							quantite_achat = '$quantite_achat',
							date_fabrication = '$date_fabrication',
							date_peremption = '$date_peremption'
						WHERE idt_produits_factures = $id";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit dans la facture. '})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car certaines valeurs de ce produit sont invalides.'})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values du produit sont nulles. '})";
		}
	}
}
else
{
	@header("Location: ../index.php");
}
?>