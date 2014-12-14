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
	isset( $_POST ["stock_physique"] ) ? $stock_physique = addslashes(htmlspecialchars($_POST ["stock_physique"])) : $stock_physique = "";

	$ok = true;
	$ok &= isNumber($stock_physique);

	if($ok)
	{
		$sql = "UPDATE t_produits
				SET stock_physique = '$stock_physique'
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
		echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données car certaines valeurs sont nulles '})";
	}
}
else
{
	@header("Location: ../index.php");
}
?>