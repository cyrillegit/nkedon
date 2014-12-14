<?php
/* File: compte_utilisateur.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier un compte utilisateur.
 */
@require_once ("../config/config.php");
@require_once ("../include/function.php");

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ["id_compte"] ) ? $id = $_POST ["id_compte"] : $id = NULL;
if( $id != NULL )
{
	isset( $_POST ["nom"] ) ? $nom = strtoupper(addslashes(htmlspecialchars($_POST ["nom"]))) : $nom = "";
	isset( $_POST ["prenom"] ) ? $prenom = addslashes(htmlspecialchars($_POST ["prenom"])) : $prenom = "";
	isset( $_POST ["adresse"] ) ? $adresse = addslashes(htmlspecialchars($_POST ["adresse"])) : $adresse = "";
	isset( $_POST ["login"] ) ? $login = addslashes(htmlspecialchars($_POST ["login"])) : $login = "";
	isset( $_POST ["email"] ) ? $email = addslashes(htmlspecialchars($_POST ["email"])) : $email = "";
	isset( $_POST ["id_type_user"] ) ? $id_type_user = $_POST ["id_type_user"]: $id_type_user = "";
	isset( $_POST ["password"] ) ? $password = addslashes(htmlspecialchars(md5($_POST ["password"]))) : $password = "";

	//Mode création (post:insert)
	if( $id == 0 )
	{
		if( $id_type_user != NULL && $nom != NULL && $prenom != NULL && $login != NULL && $password != NULL && $email != NULL && $adresse != NULL )
		{
			$ok = true;
			$ok &= isEmail($email);
			$infoAllUsers = $db->GetInfoAllUsers();
			foreach ($infoAllUsers as $infoUser)
			{
				if($infoUser["email_user"] == $email || $infoUser["login"] == $login)
				{
					$ok &=false;
				}
			}

			$sql = "INSERT INTO t_users
							(nom_user,
							 prenom_user,
							 adresse_user,
							 email_user,
							 login,
							 password,
							 id_type_user)
			VALUES ('$nom',
					'$prenom',
					'$adresse',
					'$email',
					'$login',
					'$password',
					$id_type_user)";

			if( $ok )
			{
				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de l \'insertion de l \'utilisateur en base de données...'})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue car ce login et/ou ce mot de passe existe déjà en base de données...'})";
			}				
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue car certaines values sont nulles... '})";
		}
		
	}
	//Mode mise à jour (post:update)
	else
	{
		if( $id_type_user != NULL && $nom != NULL && $prenom != NULL && $login != NULL && $email != NULL && $adresse != NULL)
		{
			$ok = true;
			$ok &= isEmail($email);

			$sql = "UPDATE t_users
					SET nom_user = '$nom',
						prenom_user ='$prenom',
						adresse_user = '$adresse',
						email_user = '$email',
						login = '$login',
						id_type_user = '$id_type_user' 
					WHERE idt_users = $id";
			if($ok)
			{
				if( $db->Execute ( $sql ) )
				{
					$db->commit ();
					echo "({'result': 'SUCCESS'})";
				}
				else
				{
					$db->rollBack();
					echo "({'result': 'Une erreur est survenue lors de la mise à jour de l \'utilisateur en base de données... '})";
				}
			}
			else
			{
				$db->rollBack();
				echo "({'result': 'Une erreur est survenue lors de la mise à jour de l \'utilisateur en base de données, car certaines valeurs sont invalides... '})";
			}
		}
		else
		{
			$db->rollBack();
			echo "({'result': 'Une erreur est survenue lors de la mise à jour de l \'utilisateur en base de données car certaines valeurs sont nulles '})";
		}
	}
}
else
{
	@header("Location: ../index.php");
}
?>