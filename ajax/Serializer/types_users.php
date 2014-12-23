<?php
/* File: types_users.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistre/Modifie un profil utilisateur
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();
$ok = true;
if( isset( $_POST ["id_type_user"] ) )
{
	$id_type_user = $_POST ["id_type_user"];
	$nom_type_user = isset($_POST ["nom_type_user"]) ? addslashes($_POST ["nom_type_user"]) : "";
	//Nouveau profil : MODE INSERT
	if( $id_type_user == 0 )
	{
		if( $nom_type_user != NULL )
		{
			$sql = "INSERT INTO t_types_users (nom_type_user)
								VALUES ('$nom_type_user')";
			if( $db->Execute ( $sql ) )
			{
				$db->commit ();
				echo "({'result': 'SUCCESS'})";
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de l \'insertion du profil utilisateur en base de données... ";
			}
		} 
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de l \'insertion du profil utilisateur en base de données, car certaines values sont nulles.";
		}			
	}
	//Mode édition.
	else 
	{
		if( $nom_type_user != NULL )
		{
			$sql = "UPDATE t_types_users SET nom_type_user = '$nom_type_user' WHERE idt_types_users = $id_type_user";
			if( $db->Execute ( $sql ) )
			{
				$db->commit ();
				echo "({'result': 'SUCCESS'})";
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour du profil utilisateur en base de données... )";
			}
		} 
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour du profil utilisateur en base de données, car certaines values sont nulles. )";
		}
	}
}
else
{
	//Redirection, on a rien à faire ici.
	@header ("Location: ../index.php");
}
?>