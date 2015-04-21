<?php
@require_once ("../../config/config.php");
@include ("../../include/ClassDB.php");

$db = new Database ();

if( isset( $_POST ["id_operation"] ) )
    $id_operation = $_POST ["id_operation"];
//Mode création
if( $id_operation == 0 )
{
    $infos = false;
}
//Mode édition
else
{
    $infos = $db->getInfoFournisseur ( $id_operation );
}
?>

<script language="javascript">
    $(document).ready (function ()
    {
        $("#btnAnnuler").click (function ()
        {
            // On ferme la boîte de dialogue affichée juste avant.
            $.modal.close ();
        });

        $("#btnOK").click (function ()
        {
            var ok = false;
            if ( $("#nom_produit").val () == "" )
            {
                ShowPopupError  ("Veuillez saisir le nom du produit.");

                $("#nom_produit").focus ();
                ok = false;
            }
            else if ( $("#quantite_vendue").val () == "" )
            {
                ShowPopupError  ("Veuillez saisir la quantité vendue.");

                $("#quantite_vendue").focus ();
                ok = false;
            }
            else if ( $("#telephone_fournisseur").val () == "" )
            {
                ShowPopupError  ("Veuillez saisir le numéro de téléphone du fournisseur.");

                $("#telephone_fournisseur").focus ();
                ok = false;
            }
            else
            {
                ok = true;
            }

            if (ok)
            {
                var param = $("#form_popup").serialize ();

                var responseText = Serialize (param);

                if (responseText != "")
                {
                    response = eval (responseText);
                    if (response.result == "SUCCESS")
                    {
                        ShowSuccess ("Le produit (<strong>" + $("#nom_fournisseur").val () + "</strong>) a bien été enregistré.");
                        $.modal.close ();
                        document.location.href="../../magasin.php";
                    }
                    else
                    {
                        ShowPopupError  (response.result);
                    }
                }
                else
                {
                    ShowPopupError  ("Une erreur est survenue.");
                }
            }
            else
            {
            }
        });
    });
</script>

<div class="content">
    <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">une opération du journal</strong></div>
    <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du produit en remplissant les champs obligatoires.</div>
    <br style="clear: both; " />
    <div style="width: 100%;">
        <form name="form_popup" id="form_popup" method="post">
            <table width="100%">
                <tr>
                    <td colspan="2">
                        <div class="warnings" id="warnings_popup" style="display: none;">
                            <b>Certains champs n'ont pas &eacute;t&eacute; remplis correctement :</b>
                            <div></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <!--PARTIE GAUCHE-->
                    <td>
                        <table>
                            <tr>
                                <td>Nom du produit :<span class="champObligatoire">*</span></td>
                                <td><input type="text" name="nom_produit" id="nom_produit" value="<?php if( $infos ) { echo $infos ["nom_produit"]; } ?>"/></td>
                            </tr>
                            <tr>
                                <td>Quantité vendue :<span class="champObligatoire">*</span></td>
                                <td><input type="text" name="quantite_vendue" id="quantite_vendue" value="<?php if( $infos ) { echo $infos ["quantite_vendue"]; } ?>"/></td>
                            </tr>
                        </table>
                    </td>
                    <!--PARTIE DROITE-->
                    <td>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="target" name="target" value="operations_journal" />
            <input type="hidden" id="id_operation" name="id_operation" value="<?=$id_operation;?>" />
        </form>
    </div>
    <hr size="1" style="margin-top: 25px;" />
    <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
    <div style="float: right; text-align: right;">
        <table border="0" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                <td>&nbsp;</td>
                <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
            </tr>
        </table>
    </div>
</div>    