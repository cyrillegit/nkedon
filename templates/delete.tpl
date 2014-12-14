{include file='common/header.tpl'}
{literal}
<script language="javascript">
$(document).ready (function ()
{
	
});
</script>
{/literal}
    <div id="Content">
        <div class="Titre_page">{$type_delete}</div>
    	<div class="breadCrumbHolder module">
            <div id="filAriane" class="breadCrumb module">
                <ul>
                    <li>
                        <a href="index.php">Accueil</a>
                    </li>
                    <li>
                        <a href="index.php">Accueil</a>
                    </li>
                    <li><a href="gestion_sites.php">Gestion et organisation de sites</a> </li>
                    <li><strong>Suppression d'informations</strong>                    </li>
                </ul>
            </div>
        </div>
    	<br /><br />
        {$message}
        <br /><br />
    </div>
</div>
{include file='common/footer.tpl'}