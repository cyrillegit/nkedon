<?php
session_start ();

if ($_POST ["id"] == "ERROR_LOGIN")
{
	include ("errors/bad_login.tpl");
}
?>