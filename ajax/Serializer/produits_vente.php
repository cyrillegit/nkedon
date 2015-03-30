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

isset( $_POST ["id_produit_vente"] ) ? $id = $_POST ["id_produit_vente"] : $id = NULL;

if( $id != NULL )
{
	isset( $_POST ["nom_produit_search"] ) ? $nom_produit = strtoupper(addslashes(htmlspecialchars($_POST ["nom_produit_search"]))) : $nom_produit = "";
	isset( $_POST ["quantite_vendue"] ) ? $quantite_vendue = addslashes(htmlspecialchars($_POST ["quantite_vendue"])) : $quantite_vendue = "";

	//Mode création (post:insert)
	if( $id == 0 )
	{
		if( $nom_produit != NULL && $quantite_vendue != NULL )
		{
			$ok = true;

            $produit = $db->getInfoProduitByNom( $nom_produit );
            $id_produit = $produit["idt_produits"];

			if( $id_produit != NULL )
			{
				$ok &= true;
			}

			$ok &= isNumber( $quantite_vendue );

			if( $ok )
			{
				$sql = "INSERT INTO t_produits_ventes
							(id_produit,
							 quantite_vendue)
				VALUES ('$id_produit',
						'$quantite_vendue')";

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
		if( $nom_produit != NULL && $quantite_vendue != NULL )
		{
			$ok = true;

			$id_produit = $db->getIdProduitByNom( $nom_produit );

			$ok &= isNumber($quantite_vendue);

			if($ok)
			{
				$sql = "UPDATE t_produits_ventes
						SET id_produit = '$id_produit',
							quantite_vendue = '$quantite_vendue'
						WHERE idt_produits_ventes = $id";

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