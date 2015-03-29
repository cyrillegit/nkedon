{include file="common/header.tpl"}
{literal}
<script language="javascript">
$(document).ready (function ()
{

});

</script>
{/literal}
<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Contacts</strong> <strong style="color:black;">utiles</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Quelques contacts en cas de suggestions.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Veuillez adresser vos suggestions aux contacts ci-dessous.
                </td>
                <td>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div style="width: 100%;">
        <form name="form_popup" id="form_popup" method="post">

            <style type="text/css">
                .blocInfoBis
                {
                    background-image: url("css/images/bg_bloc_alertes.png");
                    background-repeat: repeat;
                    border: 1px solid #313131;
                    padding: 5px 5px 5px;
                }
                .maindiv{ 
                    width:690px; 
                    margin:0 auto; 
                    padding:20px; 
                    background:#CCC;
                }
                .innerbg{ 
                    padding:6px; 
                    background:#FFF;
                }
                .link{ 
                    font-weight:bold; 
                    color:#ff0000; 
                    text-decoration:none; 
                    font-size:12px;
                }
            </style>
            <div style="clear: both;">&nbsp;</div>
            <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                <tr>
                    <!--PARTIE GAUCHE-->
                    <td>
                        <table cellspacing="5" cellpadding="2" width="100%">
                            <tr class="blocInfoBis">
                                <td> Hervé FOFOU : Attaché commercial </td>
                            <tr class="blocInfoBis">
                                <td> Numéro de téléphone : 00237 77 59 78 63 </td>
                            </tr>
                            <tr class="blocInfoBis">
                                <td> E-mail : hervejulio2004@gmail.com </td>
                            </tr>
                            <tr class="blocInfoBis">
                                <td> Adresse : Bépanda, Douala, Cameroun </td>
                            </tr>                       
                        </table>
                    </td>
                    <td>
                        <table cellspacing="5" cellpadding="2" width="100%">
                            <tr>    
                                <td align="left" valign="middle"><img src="assets/images/admin/herve.jpg" alt="photo du concepteur , developpeur" width="81" height="108" /></td>       
                            </tr>                               
                        </table>
                    </td>                    
                </tr>
            </table>            
            <div style="clear: both;">&nbsp;</div>
            <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                <tr>
                    <!--PARTIE GAUCHE-->
                    <td>
                        <table cellspacing="5" cellpadding="2" width="100%">
                            <tr class="blocInfoBis">
                                <td> Cyrille MOFFO : Concepteur, développeur </td>
                            <tr class="blocInfoBis">
                                <td> Numéro de téléphone : 0033 6 58 06 38 46 </td>
                            </tr>
                            <tr class="blocInfoBis">
                                <td> E-mail : cyrille.moffo@gmail.com</td>
                            </tr>
                            <tr class="blocInfoBis">
                                <td> Adresse : 9 Rue Flachet 69100 Villeurbanne, France </td>
                            </tr>                       
                        </table>
                    </td>
                    <td>
                        <table cellspacing="5" cellpadding="2" width="100%">
                            <tr>    
                                <td align="left" valign="middle"><img src="assets/images/admin/cyrille.jpg" alt="photo du concepteur , developpeur" width="81" height="108" /></td>       
                            </tr>                               
                        </table>
                    </td>                    
                </tr>
            </table>
        </form>
    </div>
    <br /> 

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='contact.php';"></div>
    <a href="administration_magasin.php?sub=backupdb" style="color:white;">Backup DB.</a>
</div>

{include file="common/footer.tpl"}