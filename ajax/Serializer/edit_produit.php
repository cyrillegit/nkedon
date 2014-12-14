<?php
/* File: edit_produit.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier un produit.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_produit"] ) ? $id = $_POST ["id_produit"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["nom_produit"] ) ? $nom_produit = strtoupper(addslashes(htmlspecialchars($_POST ["nom_produit"]))) : $nom_produit = "";
	isset( $_POST ["prix_achat"] ) ? $prix_achat = addslashes(htmlspecialchars($_POST ["prix_achat"])) : $prix_achat = "";
	isset( $_POST ["prix_vente"] ) ? $prix_vente = addslashes(htmlspecialchars($_POST ["prix_vente"])) : $prix_vente = "";

	//Mode création (post:insert)
	if( $id == 0 )
	{
		if( $nom_produit != NULL && $prix_achat != NULL && $prix_vente != NULL)
		{
			str_replace( "  ", " ", trim( $nom_produit ));
			$ok = true;
			$infoAllProduits = $db->getAllProduits();
			foreach ($infoAllProduits as $infoProduit)
			{
				if($infoProduit["nom_produit"] == $nom_produit)
				{
					$ok &=false;
				}
			}

			$ok &= isNumber($prix_achat);
			$ok &= isNumber($prix_vente);

			if( $ok )
			{
				$sql = "INSERT INTO t_produits
							(nom_produit,
							 stock_initial,
							 stock_physique,
							 prix_achat,
							 prix_vente)
				VALUES ('$nom_produit',
						0,
						0,
						'$prix_achat',
						'$prix_vente')";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion du produit en base de données...'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car certaines valeurs de ce produit sont invalides...'})";
			}				
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values du produit sont nulles... '})";
		}
		
	}
	//Mode mise à jour (post:update)
	else
	{
		if( $nom_produit != NULL && $prix_achat != NULL && $prix_vente != NULL )
		{
			str_replace( "  ", " ", trim( $nom_produit ));
			$ok = true;

			$ok &= isNumber($prix_achat);
			$ok &= isNumber($prix_vente);

			if($ok)
			{
				$sql = "UPDATE t_produits
						SET nom_produit = '$nom_produit',
							prix_achat = '$prix_achat',
							prix_vente = '$prix_vente'
						WHERE idt_produits = $id";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données... '})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données, car les dates sont invalides... '})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données car certaines valeurs sont nulles '})";
		}
	}
}
else
{
	@header("Location: ../index.php");
}
?>