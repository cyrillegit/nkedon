<?php
/* File: produits_facture.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier un produit dans une facture.
 */
@session_start();
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_operation_journal"] ) ? $id = $_POST ["id_operation_journal"] : $id = NULL;

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

            // get infos of the product
            $produit = $db->getInfoProduitByNom( $nom_produit );
            $id_produit = $produit["idt_produits"];

            // check if the product exists
            ($id_produit != NULL ) ? $ok &= true : $ok &= false;
			$ok &= isNumber( $quantite_vendue );
            isset( $_COOKIE["operation"] ) ? $numero_operation = $_COOKIE["operation"]: $numero_operation = 1;
            setcookie("operation", $numero_operation + 1 );

			if( $ok )
			{
				$sql = "INSERT INTO t_produits_operations
							(id_produit,
							 quantite_vendue,
							 numero_operation)
				VALUES ('$id_produit',
						'$quantite_vendue',
						'$numero_operation')";

				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
                    $_SESSION["numero"] = $_SESSION["numero"] + 1;
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion de cet opération dans le journal.'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car certaines valeurs de cet opération sont invalides.'})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values de cet opération sont nulles. '})";
		}

	}
	//Mode mise à jour (post:update)
	else
	{
		if( $nom_produit != NULL && $quantite_vendue != NULL )
		{
			$ok = true;

            // get infos of the product
            $produit = $db->getInfoProduitByNom( $nom_produit );
            $id_produit = $produit["idt_produits"];

            // check if the product exists
            ( $id_produit != NULL ) ? $ok &= true : $ok &= false;
            $ok &= isNumber( $quantite_vendue );

            $operation = $db->getOperationByIdOperation( $id );

            isset( $operation ) ? $numero_operation = $operation["numero_operation"]: $numero_operation = "1";

			if($ok)
			{
                $sql = "UPDATE t_produits_operations
						SET id_produit = '$id_produit',
							quantite_vendue = '$quantite_vendue',
							numero_operation = '$numero_operation'
						WHERE idt_produits_operations = $id";

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