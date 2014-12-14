<?php
/* File: compte_utilisateur.php
 * Author: Cyrille MOFFO (cyrille.moffo@nmand-soft.com)
 * -------------------------------------------------
 * Enregistrer et modifier un mot de passe de compte utilisateur.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_compte"] ) ? $id = $_POST ["id_compte"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["password"] ) ? $password = addslashes(htmlspecialchars(md5($_POST ["password"]))) : $password = "";

	if( $password != NULL)
	{
		$sql = "UPDATE t_users
				SET password = '$password'
				WHERE idt_users = $id";

		if( $db->Execute ( $sql ) )
		{
			$db->commit ();
			echo "({'result': 'SUCCESS'})";
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour du mot de passe de l \'utilisateur en base de données... '})";
		}
	}
	else
	{
		$db->rollBack();
		echo "({'result': 'Une erreur est survenue lors de la mise à jour du mot de passe de l \'utilisateur en base de données car la valeur est nulle '})";
	}
}
else
{
	@header("Location: ../index.php");
}
?>