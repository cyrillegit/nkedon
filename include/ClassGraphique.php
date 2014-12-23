<?php
/** =====================================================================================================================
ClassGraphique
Version : 2.0
Date : 23/12/2011
-----------------
Mise en place des fonctions de génération des graphiques pour les différentes synthèses.

V1.0 : 23/12/2011
	Intégration des premiers types de graphiques.

V2.0 : 26/08/2012
	Mise en place des fonctions de pChart en v2.x
	Création des graphiques pour la gestion du Personnel.
===================================================================================================================== */
@session_start ();
include ("pChart/class/pData.class.php");
include ("pChart/class/pDraw.class.php");
include ("pChart/class/pPie.class.php");
include ("pChart/class/pImage.class.php");

class ModeGraphique
{
	const E_MOIS = 1;
	const E_JOUR = 2;
	const E_ANNEE = 3;
};

class CommonGraph
{
	// Mode d'affichage du graphique (pour les chiffres, et les filtrages).
	protected $ModeGraphique;
	// Pointeur vers la classe des bases de données.
	protected $db;
	// Pointeur vers la classe de gestion des infos de la synthèse.
	protected $Synthese;
	// Tableau contenant les valeurs des différents filtres.
	protected $filters;
	// Tableau de paramétrage.
	protected $config;
	
	// Les deux classes utilisant les graphiques.
	protected $Filename_GraphStd;
	protected $Filename_GraphBig;
	
	// Tailles de police
	protected $DefaultFontSize;
	
	// Tailles pour les différents graphiques. Ces tailles peuvent être modifiées à loisir.
	protected $WidthStd;
	protected $HeightStd;
	protected $WidthBig;
	protected $HeightBig;
	
	protected $zFactor;
	
	function __drawBarGraphs ($MyData)
	{
		$MyData->loadPalette("include/pChart/palettes/surikat.color", TRUE);
		
		/* Create the pChart object */
		$myPicture = new pImage($this->WidthStd,$this->HeightStd,$MyData);
		$myPicture->drawGradientArea(0,0,$this->WidthStd,$this->HeightStd,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
		$myPicture->drawGradientArea(0,0,$this->WidthStd,$this->HeightStd,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>8));
		
		/* Draw the scale  */
		$myPicture->setGraphArea(50,30,$this->WidthStd - 20,$this->HeightStd - 20);
		$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));
		
		/* Write the chart title */ 
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>11));
		$myPicture->drawText(200,20,$Title,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		
		/* Turn on shadow computing */ 
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Draw the chart */
		$settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>9));
		$myPicture->drawBarChart($settings);
		
		/* Write the chart legend */
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>8));
		$myPicture->drawLegend($this->WidthStd - 200,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
		
		$myPicture->Render(Configuration::getValue ("GraphSets") . $this->Filename_GraphStd);
		
		/* Create the pChart object */
		$myPictureZoom = new pImage($this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,$MyData);
		$myPictureZoom->drawGradientArea(0,0,$this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
		$myPictureZoom->drawGradientArea(0,0,$this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
		$myPictureZoom->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>8));
		
		/* Draw the scale  */
		$myPictureZoom->setGraphArea(50,30,($this->WidthStd * $this->zFactor) - 20,($this->HeightStd * $this->zFactor) - 20);
		$myPictureZoom->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));
		
		/* Write the chart title */ 
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>11));
		$myPicture->drawText(200,20,$Title,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		
		/* Turn on shadow computing */ 
		$myPictureZoom->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Draw the chart */
		$settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
		$myPictureZoom->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>13));
		$myPictureZoom->drawBarChart($settings);
		
		/* Write the chart legend */
		$myPictureZoom->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>12));
		$myPictureZoom->drawLegend(($this->WidthStd * $this->zFactor) - 200,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
		// On duplique ici le modèle standard pour en faire un agrandissement du graphique (ou ZOOM).
		$myPictureZoom->Render(Configuration::getValue ("GraphSets") . $this->Filename_GraphBig);
	}
	
	function __drawStackedBarGraphs ($MyData)
	{
		$MyData->loadPalette("include/pChart/palettes/surikat.color", TRUE);
		
		/* Create the pChart object */
		$myPicture = new pImage($this->WidthStd,$this->HeightStd,$MyData);
		$myPicture->drawGradientArea(0,0,$this->WidthStd,$this->HeightStd,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
		$myPicture->drawGradientArea(0,0,$this->WidthStd,$this->HeightStd,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		
		/* Draw the scale  */
		$myPicture->setGraphArea(50,30,$this->WidthStd - 20,$this->HeightStd - 20);
		$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Mode"=>SCALE_MODE_ADDALL));
		
		/* Write the chart title */ 
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>11));
		$myPicture->drawText(20,20,$Title,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		
		/* Turn on shadow computing */ 
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Draw the chart */
		$settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>7));
		$myPicture->drawStackedBarChart(array("Rounded"=>TRUE,"DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"DisplaySize"=>6,"BorderR"=>255,"BorderG"=>255,"BorderB"=>255));
		
		/* Write the chart legend */
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		$myPicture->drawLegend(/*$this->WidthStd - 200*/20,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
		
		$myPicture->Render(Configuration::getValue ("GraphSets") . $this->Filename_GraphStd);
		
		/* Create the pChart object */
		$myPictureZoom = new pImage($this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,$MyData);
		$myPictureZoom->drawGradientArea(0,0,$this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
		$myPictureZoom->drawGradientArea(0,0,$this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
		$myPictureZoom->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		
		/* Draw the scale  */
		$myPictureZoom->setGraphArea(50,30,($this->WidthStd * $this->zFactor) - 20,($this->HeightStd * $this->zFactor) - 20);
		$myPictureZoom->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Mode"=>SCALE_MODE_ADDALL));
		
		/* Write the chart title */ 
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>11));
		$myPicture->drawText(20,20,$Title,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		
		/* Turn on shadow computing */ 
		$myPictureZoom->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Draw the chart */
		$settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
		$myPictureZoom->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>7));
		$myPictureZoom->drawStackedBarChart(array("Rounded"=>TRUE,"DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"DisplaySize"=>6,"BorderR"=>255,"BorderG"=>255,"BorderB"=>255));
		
		/* Write the chart legend */
		$myPictureZoom->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		$myPictureZoom->drawLegend(/*($this->WidthStd * $this->zFactor) - 200*/20 * $this->zFactor,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
		// On duplique ici le modèle standard pour en faire un agrandissement du graphique (ou ZOOM).
		$myPictureZoom->Render(Configuration::getValue ("GraphSets") . $this->Filename_GraphBig);
	}
	
	function __draw3DPieGraphs ($MyData, $title)
	{
		$MyData->loadPalette("include/pChart/palettes/surikat.color", TRUE);
		
		/* Create the pChart object */
		$myPicture = new pImage($this->WidthStd,$this->HeightStd,$MyData,TRUE);
		
		/* Draw a solid background */
		$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
		$myPicture->drawFilledRectangle(0,0,$this->WidthStd,$this->HeightStd,$Settings);
		
		/* Draw a gradient overlay */
		$Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50);
		$myPicture->drawGradientArea(0,0,$this->WidthStd,$this->HeightStd,DIRECTION_VERTICAL,$Settings);
		$myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));
		
		/* Add a border to the picture */
		$myPicture->drawRectangle(0,0,$this->WidthStd - 1,$this->HeightStd - 1,array("R"=>0,"G"=>0,"B"=>0));
		
		/* Write the picture title */ 
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		$myPicture->drawText(10,13,$title,array("R"=>255,"G"=>255,"B"=>255));
		
		/* Set the default font properties */ 
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
		
		/* Create the pPie object */ 
		$PieChart = new pPie($myPicture,$MyData);
		
		/* Define the slice color */
		$PieChart->setSliceColor(0,array("R"=>143,"G"=>197,"B"=>0));
		$PieChart->setSliceColor(1,array("R"=>97,"G"=>77,"B"=>63));
		$PieChart->setSliceColor(2,array("R"=>97,"G"=>113,"B"=>63));
		
		/* Draw an AA pie chart */ 
		$PieChart->draw3DPie ($this->WidthStd / 2,$this->HeightStd / 2,array("WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));
		
		/* Enable shadow computing */ 
		$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Write the legend */
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
		
		/* Write the legend box */ 
		$myPicture->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6,"R"=>255,"G"=>255,"B"=>255));
		$PieChart->drawPieLegend($this->WidthStd - 400,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
		
		$myPicture->Render(Configuration::getValue ("GraphSets") . $this->Filename_GraphStd);
		
		/* Create the pChart object */
		$myPictureZOOM = new pImage($this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,$MyData,TRUE);
		
		/* Draw a solid background */
		$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
		$myPictureZOOM->drawFilledRectangle(0,0,$this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,$Settings);
		
		/* Draw a gradient overlay */
		$Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50);
		$myPictureZOOM->drawGradientArea(0,0,$this->WidthStd * $this->zFactor,$this->HeightStd * $this->zFactor,DIRECTION_VERTICAL,$Settings);
		$myPictureZOOM->drawGradientArea(0,0,$this->WidthStd * $this->zFactor,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));
		
		/* Add a border to the picture */
		$myPictureZOOM->drawRectangle(0,0,($this->WidthStd * $this->zFactor) - 1,($this->HeightStd * $this->zFactor) - 1,array("R"=>0,"G"=>0,"B"=>0));
		
		/* Write the picture title */ 
		$myPictureZOOM->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		$myPictureZOOM->drawText(10,13,$title,array("R"=>255,"G"=>255,"B"=>255));
		
		/* Set the default font properties */ 
		$myPictureZOOM->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
		
		/* Create the pPie object */ 
		$PieChart = new pPie ($myPictureZOOM,$MyData);
		
		/* Define the slice color */
		$PieChart->setSliceColor(0,array("R"=>143,"G"=>197,"B"=>0));
		$PieChart->setSliceColor(1,array("R"=>97,"G"=>77,"B"=>63));
		$PieChart->setSliceColor(2,array("R"=>97,"G"=>113,"B"=>63));
		
		/* Draw an AA pie chart */ 
		$PieChart->draw3DPie (($this->WidthStd / 2) + 60, ($this->HeightStd / 2) + 120,array("WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE, "Radius" => 240));
		
		/* Enable shadow computing */ 
		$myPictureZOOM->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		
		/* Write the legend */
		$myPictureZOOM->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6));
		$myPictureZOOM->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
		
		/* Write the legend box */ 
		$myPictureZOOM->setFontProperties(array("FontName"=>"include/pChart/Fonts/segoeui.ttf","FontSize"=>6,"R"=>255,"G"=>255,"B"=>255));
		$PieChart->drawPieLegend(($this->WidthStd * $this->zFactor) - 400,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
		
		$myPictureZOOM->Render(Configuration::getValue ("GraphSets") . $this->Filename_GraphBig);
	}
};
	
class Graphique extends CommonGraph
{
	/*******************************************************
	 * __construct
	 *******************************************************
	 * @param pointer $db
	 * @return nothing
	 ******************************************************/
	public function __construct ($db, $synth)
	{
		$this->db = $db;
		$this->Synthese = $synth;
		
		if (!isset ($_SESSION ["Graphs"]))
		{
			$_SESSION ["Graphs"] = array ();
		}
		if (!isset ($_SESSION ["SelectedValues"]["SyntheseMois"]))
		{
			$_SESSION ["SelectedValues"]["SyntheseMois"] = date ("m");
		}
		if (!isset ($_SESSION ["SelectedValues"]["SyntheseAnnee"]))
		{
			$_SESSION ["SelectedValues"]["SyntheseAnnee"] = date ("Y");
		}
		$this->filters = $_SESSION ["SelectedValues"];
		
		$this->config = $db->GetConfiguration ($_SESSION ["infoUser"]["id_agence"]);
		// Par défaut, le mois.
		$this->ModeGraphique = ModeGraphique::E_MOIS;
		// Tailles par défaut du graphique standard.
		$this->WidthStd = 660;
		$this->HeightStd = 400;
		// Tailles par défaut du graphique mode ZOOM.
		$this->WidthBig = 1650;
		$this->HeightBig = 1000;
		
		$this->zFactor = 2.5;
		
		// Au démarrage, les fichiers sont vides, on ne doit pas connaître leur nom. C'est dans la fonction Draw que c'est fait.
		$Filename_GraphStd = "";
		$Filename_GraphBig = "";
		
		// Tailles des polices pour rendre plus clair les graphiques.
		$this->DefaultFontSize = 10;
		$this->DefaultTitleFontSize = 18;
	}
	
	/*******************************************************
	 * GetGraphics
	 *******************************************************
	 * @param nothing
	 * @return array
	 ******************************************************/
	public function GetGraphics ()
	{
		if ( (file_exists (Configuration::getValue ("GraphSets") . $this->Filename_GraphStd)) && (file_exists (Configuration::getValue ("GraphSets") . $this->Filename_GraphBig)) )
		{
			return array ("std" => $this->Filename_GraphStd, "big" => $this->Filename_GraphBig);
		}
		else
		{
			return NULL;
		}
	}
	
	/*******************************************************
	 * DrawGraph_IncidentsMateriels
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_IncidentsMateriels ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Incidents matériels / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_incidents_materiels_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_incidents_materiels_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$out = array ();
		$in = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$out [] = $this->Synthese->GetNbIncidentsMateriels ($calendar [$i - 1]["date"]);
			$in [] = $this->Synthese->GetNbReparations($calendar [$i - 1]["date"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($out,"Pannes / Incidents");
		$MyData->addPoints($in,"Réparations");
		$MyData->setAxisName(0,"Nombre d'intervention");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_ConsommationProduits
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_ConsommationProduits ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Consommations de produits / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_consommations_produits_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_consommations_produits_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$out = array ();
		$in = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$out [] = $this->Synthese->GetNbProduit(false, $calendar [$i - 1]["date"]);
			$in [] = $this->Synthese->GetNbProduit(true, $calendar [$i - 1]["date"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($out,"Décaissements");
		$MyData->addPoints($in,"Réapprovisionnements");
		$MyData->setAxisName(0,"Nombre d'unités");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_SousTraitance
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_SousTraitance ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Sous-traitance / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_sous_traitance_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_sous_traitance_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$out = array ();
		$in = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$out [] = $this->Synthese->GetNbSousTraitantsActifs ($calendar [$i - 1]["date"]);
			$in [] = $this->Synthese->GetNbSousTraitantsInactifs($calendar [$i - 1]["date"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($out,"Sous-traitants (actifs)");
		$MyData->addPoints($in,"Sous-traitants (inactifs)");
		$MyData->setAxisName(0,"Nombre de sous-traitants");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_SalariesAbsences
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	function DrawGraph_SalariesAbsences ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Absences (par type) / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_salaries_absences_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_salaries_absences_".$sha1."_big.png";
		
		$calendar = get_month_year_days ($this->Synthese->GetMonth (), $this->Synthese->GetYear ());
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		$config = $this->db->GetConfiguration ($_SESSION ["infoUser"]["id_agence"]);
		$typesAbsences = $this->db->GetAllTypesAbsences ();
		// Création des points selon les informations.
		$year = date ("Y");
		$arr = array ();
		foreach ($typesAbsences as $obj)
		{
			$nbHeures = $this->Synthese->GetNbHeuresAbsences ($obj ["idt_types_absences"]);
			if ($nbHeures > 0)
			{
				$arr[] = $nbHeures;
			}
		}
		
		if (count($arr) == 0)
		{
			return;
		}
		else
		{
			$DataSet->AddPoint($arr, "Serie1");
			// Types d'absences.
			$arr2 = array ();
			foreach ($typesAbsences as $obj)
			{
				$arr2[] = $obj ["nom_type_absence"];
			}
			
			/* Create and populate the pData object */
			$MyData = new pData();  
			$MyData->addPoints($arr, "Serie1");
			$MyData->addPoints($arr2,"Postes");
			$MyData->setAxisName(0,"Nombre d'intervention");
			$MyData->setSerieDescription("Serie1","Valeurs");
			$MyData->setSerieDescription("Postes","Types d'absences");
			$MyData->setAbscissa("Postes");
			
			$this->__draw3DPieGraphs($MyData, "Gestion des heures");
		}
	}
	
	/*******************************************************
	 * DrawGraph_SalariesHeuresSupplementaires
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	function DrawGraph_SalariesHeuresSupplementaires ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Heures supp. (par type) / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_salaries_heures_supplementaires_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_salaries_heures_supplementaires_".$sha1."_big.png";
		
		$calendar = get_month_year_days ($this->Synthese->GetMonth (), $this->Synthese->GetYear ());
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		$config = $this->db->GetConfiguration ($_SESSION ["infoUser"]["id_agence"]);
		$typesHeures = $this->db->GetAllTypesHeuresSupplementaires ();
		// Création des points selon les informations.
		$year = date ("Y");
		$DataSet = new pData;  
		$arr = array ();
		foreach ($typesHeures as $obj)
		{
			$nbHeures = $this->Synthese->GetNbHeuresSupplementaires ($obj ["idt_types_heures_supplementaires"]);
			if ($nbHeures > 0)
			{
				$arr[] = $nbHeures;
			}
		}
		
		if (count($arr) == 0)
		{
			return;
		}
		else
		{
			// Types d'absences.
			$arr2 = array ();
			foreach ($typesHeures as $obj)
			{
				$arr2[] = $obj ["nom_type_heure_supplementaire"];
			}
			
			/* Create and populate the pData object */
			$MyData = new pData();  
			$MyData->addPoints($arr, "Serie1");
			$MyData->addPoints($arr2,"Postes");
			$MyData->setAxisName(0,"Nombre d'intervention");
			$MyData->setSerieDescription("Serie1","Valeurs");
			$MyData->setSerieDescription("Postes","Types d'heures supplémentaires");
			$MyData->setAbscissa("Postes");
			
			$this->__draw3DPieGraphs($MyData, "Gestion des heures");
		}
	}
	
	/*******************************************************
	 * DrawGraph_SalariesConges
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_SalariesConges ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Détachements / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_conges_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_conges_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$detachements = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$detachements [] = $this->Synthese->GetNbConges(false, 1, $calendar [$i - 1]["date"]);
		}
		
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($detachements,"Jours de congés");
		$MyData->setAxisName(0,"Nb de jours");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_Formations
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_Formations ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Formations / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_formations_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_formations_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$formations_standard = array ();
		$formations_securite = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$formations_standard [] = $this->Synthese->GetNbFormations(false, 1, $calendar [$i - 1]["date"]);
			$formations_securite [] = $this->Synthese->GetNbFormations(false, 2, $calendar [$i - 1]["date"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($formations_standard,"Formations métiers");
		$MyData->addPoints($formations_securite,"Formations de sécurité");
		$MyData->setAxisName(0,"Nombre de formations");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_VisitesMedicales
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_VisitesMedicales ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Visites médicales & Vaccinations / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_visites_medicales_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_visites_medicales_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$formations_standard = array ();
		$formations_securite = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$formations_standard [] = $this->Synthese->GetNbVisitesMedicales($calendar [$i - 1]["date"]);
			$formations_securite [] = $this->Synthese->GetNbVaccins($calendar [$i - 1]["date"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($formations_standard,"Visites médicales");
		$MyData->addPoints($formations_securite,"Vaccinations");
		$MyData->setAxisName(0,"Nombre de formations");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_Securite
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_Securite ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Sécurité / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_securite_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_securite_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$formations = array ();
		$visites_medicales = array ();
		$verifications = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$formations [] = $this->Synthese->GetSecuriteNbFormationsDay($calendar [$i - 1]["date"]);
			$visites_medicales [] = $this->Synthese->GetNbVisitesMedicalesDay($calendar [$i - 1]["date"]);
			$verifications [] = $this->Synthese->GetNbVerificationsPeriodiquesDay($calendar [$i - 1]["date"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($formations,"Formations de sécurité");
		$MyData->addPoints($visites_medicales,"Visites médicales");
		$MyData->addPoints($visites_medicales,"Vérifications périodiques");
		$MyData->setAxisName(0,"Nombre d'évènements");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_Dotations
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_Dotations ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Dotations en EPI&EPC / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_dotations_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_dotations_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$dotations_toutes = array ();
		$dotations_remises = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$dotations_toutes [] = $this->Synthese->GetNbDotations(false, $calendar [$i - 1]["date"]);
			$dotations_remises [] = $this->Synthese->GetNbDotations(true, $calendar [$i - 1]["date"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($dotations_toutes,"Dotations réservées");
		$MyData->addPoints($dotations_remises,"Dotations remises");
		$MyData->setAxisName(0,"Nombre de dotations");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_SuivisPrestations
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_SuivisPrestations ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Suivis des prestations / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_suivis_prestations_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_suivis_prestations_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			// Nb contrôles effectués.
			$mois[$index][] = $this->Synthese->GetCountPrestationsValideesDay ($calendar [$i - 1]["date"]);
			$mois[$index+1][] = $this->Synthese->GetCountPrestationsDecaleesDay ($calendar [$i - 1]["date"]);
			
			$index++;
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($mois[0],"Prestations validées");
		$MyData->addPoints($mois[1],"Prestations décalées");
		$MyData->setAxisName(0,"Nombre de prestations");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_ControlesPrestations
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_ControlesPrestations ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Contrôle des prestations / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_controles_prestations_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_controles_prestations_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			// Nb contrôles effectués.
			$mois[$index][] = $this->Synthese->GetCountDayControle (true, $calendar [$i - 1]["date"], $seuilPourcentageOK);
			$mois[$index+1][] = $this->Synthese->GetCountDayControle (false, $calendar [$i - 1]["date"], $seuilPourcentageOK);
			
			$index++;
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($mois[0],"Nb. contrôles conformes");
		$MyData->addPoints($mois[1],"Nb. contrôles non conformes");
		$MyData->setAxisName(0,"Nombre de contrôles");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_Epi_Epc
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_Epi_Epc ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "EPI et EPC consommés / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_epi_epc_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_epi_epc_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			// Nb contrôles effectués.
			$mois[$index][] = $this->Synthese->GetCountNbEpiReserves ($calendar [$i - 1]["date"]);
			$mois[$index+1][] = $this->Synthese->GetCountNbEpiRemis ($calendar [$i - 1]["date"]);
			
			$index++;
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($mois[0],"Nb. d'EPI réservés");
		$MyData->addPoints($mois[1],"Nb. d'EPI remis");
		$MyData->setAxisName(0,"Nombre d'EPI / EPC");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_Devis
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_Devis ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Devis & Prospection / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_prospection_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_prospection_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$devis_tovalid = array ();
		$devis_valides = array ();
		$devis_refuses = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$devis_tovalid [] = $this->Synthese->GetNbDevisByStatus($calendar [$i - 1]["date"], "ATT");
			$devis_valides [] = $this->Synthese->GetNbDevisByStatus($calendar [$i - 1]["date"], "VAL");
			$devis_refuses [] = $this->Synthese->GetNbDevisByStatus($calendar [$i - 1]["date"], "REF");
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($devis_tovalid,"Nb. devis à valider");
		$MyData->addPoints($devis_valides,"Nb. devis validés");
		$MyData->addPoints($devis_refuses,"Nb. devis refusés");
		$MyData->setAxisName(0,"Nombre de devis");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_Occasionnels
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_Occasionnels ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Suivi des occasionnels / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_occasionnels_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_occasionnels_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		$devis_tovalid = array ();
		$devis_valides = array ();
		$devis_refuses = array ();
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$devis_tovalid [] = $this->Synthese->GetNbOccasionnelsByStatus($calendar [$i - 1]["date"], "ADDED");
			$devis_valides [] = $this->Synthese->GetNbOccasionnelsByStatus($calendar [$i - 1]["date"], "SUIVI");
			$devis_refuses [] = $this->Synthese->GetNbOccasionnelsByStatus($calendar [$i - 1]["date"], "DONE");
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($devis_tovalid,"Nb. occas. à valider");
		$MyData->addPoints($devis_valides,"Nb. occas. validés");
		$MyData->addPoints($devis_refuses,"Nb. occas. refusés");
		$MyData->setAxisName(0,"Nombre d'occasionnels");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_TelephonesNombres
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_TelephonesNombres ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Nombre de téléphones actifs / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_nb_telephones_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_nb_telephones_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			$telephones = $this->db->GetAllTelephonesActifs ();
			$mois[$index++][] = count ($telephones);
			
			$index++;
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($mois[0],"Nombre de téléphones");
		$MyData->setAxisName(0,"Unité(s)");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_TelephonesConsommation
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	public function DrawGraph_TelephonesConsommation ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Consommation des téléphones / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_consommation_telephones_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_consommation_telephones_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		$calendar = get_month_year_days ($this->filters ["SyntheseMois"], $this->filters ["SyntheseAnnee"]);
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		// Création des points selon les informations.
		$year = date ("Y");
		for ($i = 1;$i <= $nbPoints;$i++)
		{
			$index = 0;
			// Nb contrôles effectués.
			$mois[$index][] = $this->Synthese->GetEchangeTotal ($calendar [$i - 1]["date"]);
			
			$index++;
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($mois[0],"Conso. téléphonique");
		$MyData->setAxisName(0,"Méga octets");
		$MyData->addPoints(explode (",", $abcisses),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_FluxFichiers
	 *******************************************************
	 * @return nothing
	 ******************************************************/
	function DrawGraph_FluxFichiers ()
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$Title = "Flux fichiers / Période : " . $this->Synthese->GetPeriodName ();
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_flux_fichiers_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_flux_fichiers_".$sha1."_big.png";
		
		$calendar = get_month_year_days ($this->Synthese->GetMonth (), $this->Synthese->GetYear ());
		$nbPoints = count ($calendar);
		$abcisses = "";
		foreach ($calendar as $tmp)
		{
			if ($abcisses != "") $abcisses .= ",";
			
			$abcisses .= $tmp ["day"];
		}
		
		$config = $this->db->GetConfiguration ($_SESSION ["infoUser"]["id_agence"]);
		
		// Création des points selon les informations.
		$year = date ("Y");
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints(array($this->Synthese->GetNbDocuments("mediatheque"), $this->Synthese->GetNbDocuments("signatures"), $this->Synthese->GetNbDocuments("photos_produits"), $this->Synthese->GetNbDocuments("photos_immobilisations"), $this->Synthese->GetNbDocuments("photos_epi")), "Serie1");
		$MyData->addPoints(array("Médiathèque", "Signatures", "Photos (Produits)", "Photos (Immobilisations)", "Photos (EPI)"),"Postes");
		$MyData->setSerieDescription("Serie1","Valeurs");
		$MyData->setSerieDescription("Types de fichiers","Postes");
		$MyData->setAbscissa("Postes");
		
		$this->__draw3DPieGraphs($MyData, "Médiathèque");
	}
	
	/*******************************************************
	 * DrawGraph_Personnel_HeuresAbsences
	 *******************************************************
	 * @param int $idSalarie
	 * @return boolean
	 ******************************************************/
	function DrawGraph_Personnel_HeuresAbsences ($idSalarie)
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$salarie = $this->db->GetInfoSalarie ($idSalarie);
		$Title = "Synthèse des heures d'absences du salarié : " . $salarie ["nom_civil"] . " " . $salarie ["prenom"];
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_absences_salarie_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_absences_salarie_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		// Périodes.
		$periodes = array ();		
		$current = date ("m-Y");
		for ($i = 5;$i >= 0;$i--)
		{
			$refDate = new DateTime(date ("Y-m-d"));
			$date = $refDate->sub (new DateInterval("P".$i."M"));
			$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		}
		$refDate = new DateTime(date ("Y-m-d"));
		$date = $refDate->add (new DateInterval("P1M"));
		$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		$abcisses = $periodes;
		$nbPoints = count ($abcisses);
		
		$abcissesX = "";
		foreach ($abcisses as $obj)
		{
			if ($abcissesX != "")
				$abcissesX .= ",";
			$abcissesX .= $obj["libelle"];
		}
		
		// Création des points selon les informations.
		$typesAbsences = $this->db->GetAllTypesAbsencesWithinDates ($idSalarie, $periodes);
		if (($typesAbsences == NULL) || empty($typesAbsences))
		{
			return false;
		}
		$datas = array ();
		foreach ($typesAbsences as $obj)
		{
			$datas [] = array ();
		}
		
		// Modification des tailles de graphiques ici.
		$this->WidthStd = 355;
		$this->HeightStd = 250;
		// Initialise the graph.
		// Création des points selon les informations.
		foreach ($abcisses as $periode)
		{
			$index = 0;
			foreach ($typesAbsences as $obj)
			{
				$datas[$index++][] = $this->db->GetCountPersonnelNbHeuresAbsences ($idSalarie, $obj ["idt_types_absences"], $periode ["periode"]);
			}
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$index = 0;
		foreach ($typesAbsences as $obj)
		{
			$MyData->addPoints($datas[$index++], $obj ["nom_type_absence"]);
		}
		
		$MyData->setAxisName(0,"Nb d'heures d'absences / jours");
		$MyData->addPoints(explode (",", $abcissesX),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
		return true;
	}
	
	/*******************************************************
	 * DrawGraph_Personnel_HeuresComplementaires
	 *******************************************************
	 * @param int $idSalarie
	 * @return boolean
	 ******************************************************/
	function DrawGraph_Personnel_HeuresComplementaires ($idSalarie)
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$salarie = $this->db->GetInfoSalarie ($idSalarie);
		$Title = "Synthèse des heures complémentaires du salarié : " . $salarie ["nom_civil"] . " " . $salarie ["prenom"];
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_heures_complementaires_salarie_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_heures_complementaires_salarie_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		// Périodes.
		$periodes = array ();		
		$current = date ("m-Y");
		for ($i = 5;$i >= 0;$i--)
		{
			$refDate = new DateTime(date ("Y-m-d"));
			$date = $refDate->sub (new DateInterval("P".$i."M"));
			$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		}
		$refDate = new DateTime(date ("Y-m-d"));
		$date = $refDate->add (new DateInterval("P1M"));
		$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		$abcisses = $periodes;
		$nbPoints = count ($abcisses);
		
		$abcissesX = "";
		foreach ($abcisses as $obj)
		{
			if ($abcissesX != "")
				$abcissesX .= ",";
			$abcissesX .= $obj["libelle"];
		}
		
		// Création des points selon les informations.
		$typesHeuresSupplementaires = $this->db->GetAllTypesHeuresSupplementairesWithinDates ($idSalarie, $periodes);
		if (($typesHeuresSupplementaires == NULL) || empty($typesHeuresSupplementaires))
		{
			return false;
		}
		$datas = array ();
		foreach ($typesHeuresSupplementaires as $obj)
		{
			$datas [] = array ();
		}
		
		// Modification des tailles de graphiques ici.
		$this->WidthStd = 355;
		$this->HeightStd = 250;
		// Initialise the graph.
		// Création des points selon les informations.
		foreach ($abcisses as $periode)
		{
			$index = 0;
			foreach ($typesHeuresSupplementaires as $obj)
			{
				$datas[$index++][] = $this->db->GetCountPersonnelNbHeuresSupplementaires ($idSalarie, $obj ["idt_types_heures_supplementaires"], $periode ["periode"]);
			}
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$index = 0;
		foreach ($typesHeuresSupplementaires as $obj)
		{
			$MyData->addPoints($datas[$index++], $obj ["nom_type_heure_supplementaire"]);
		}
		
		$MyData->setAxisName(0,"Nb d'heures d'absences / jours");
		$MyData->addPoints(explode (",", $abcissesX),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
		return true;
	}
	
	/*******************************************************
	 * DrawGraph_Personnel_Conges
	 *******************************************************
	 * @param int $idSalarie
	 * @return boolean
	 ******************************************************/
	function DrawGraph_Personnel_Conges ($idSalarie)
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$salarie = $this->db->GetInfoSalarie ($idSalarie);
		$Title = "Synthèse des heures complémentaires du salarié : " . $salarie ["nom_civil"] . " " . $salarie ["prenom"];
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_conges_salarie_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_conges_salarie_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		// Périodes.
		$periodes = array ();		
		$current = date ("m-Y");
		for ($i = 5;$i >= 0;$i--)
		{
			$refDate = new DateTime(date ("Y-m-d"));
			$date = $refDate->sub (new DateInterval("P".$i."M"));
			$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		}
		$refDate = new DateTime(date ("Y-m-d"));
		$date = $refDate->add (new DateInterval("P1M"));
		$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		$abcisses = $periodes;
		$nbPoints = count ($abcisses);
		
		$abcissesX = "";
		foreach ($abcisses as $obj)
		{
			if ($abcissesX != "")
				$abcissesX .= ",";
			$abcissesX .= $obj["libelle"];
		}
		
		// Création des points selon les informations.
		$typesConges = $this->db->GetAllTypesCongesWithinDates ($idSalarie, $periodes);
		if (($typesConges == NULL) || empty($typesConges))
		{
			return false;
		}
		$datas = array ();
		foreach ($typesConges as $obj)
		{
			$datas [] = array ();
		}
		
		// Modification des tailles de graphiques ici.
		$this->WidthStd = 355;
		$this->HeightStd = 250;
		// Initialise the graph.
		// Création des points selon les informations.
		foreach ($abcisses as $periode)
		{
			$index = 0;
			foreach ($typesConges as $obj)
			{
				$datas[$index++][] = $this->db->GetCountPersonnelNbJoursConges ($idSalarie, $obj ["idt_types_conges"], $periode ["periode"]);
			}
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$index = 0;
		foreach ($typesConges as $obj)
		{
			$MyData->addPoints($datas[$index++], $obj ["nom_type_conge"]);
		}
		
		$MyData->setAxisName(0,"Nb de jours de congés / mois");
		$MyData->addPoints(explode (",", $abcissesX),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
		return true;
	}
	
	/*******************************************************
	 * DrawGraph_Personnel_Dotations
	 *******************************************************
	 * @param int $idSalarie
	 * @return nothing
	 ******************************************************/
	function DrawGraph_Personnel_Dotations ($idSalarie)
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$salarie = $this->db->GetInfoSalarie ($idSalarie);
		$Title = "Synthèse des dotations en E.P.I./E.P.C. du salarié : " . $salarie ["nom_civil"] . " " . $salarie ["prenom"];
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_dotations_salarie_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_dotations_salarie_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		// Périodes.
		$periodes = array ();		
		$current = date ("m-Y");
		for ($i = 5;$i >= 0;$i--)
		{
			$refDate = new DateTime(date ("Y-m-d"));
			$date = $refDate->sub (new DateInterval("P".$i."M"));
			$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		}
		$refDate = new DateTime(date ("Y-m-d"));
		$date = $refDate->add (new DateInterval("P1M"));
		$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		$abcisses = $periodes;
		$nbPoints = count ($abcisses);
		
		$abcissesX = "";
		foreach ($abcisses as $obj)
		{
			if ($abcissesX != "")
				$abcissesX .= ",";
			$abcissesX .= $obj["libelle"];
		}
		
		// Création des points selon les informations.
		$data_DotationsReservees = array ();
		$data_DotationsRemises = array ();
		
		// Modification des tailles de graphiques ici.
		$this->WidthStd = 355;
		$this->HeightStd = 250;
		// Initialise the graph.
		// Création des points selon les informations.
		foreach ($abcisses as $periode)
		{
			$data_DotationsReservees [] = $this->db->GetCountPersonnelNbDotationsReservees ($idSalarie, $periode ["periode"]);
			$data_DotationsRemises [] = $this->db->GetCountPersonnelNbDotationsRemises ($idSalarie, $periode ["periode"]);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($data_DotationsReservees,"Dotations réservées");
		$MyData->addPoints($data_DotationsRemises,"Dotations remises");
		$MyData->setAxisName(0,"Nb de dotations / jours");
		$MyData->addPoints(explode (",", $abcissesX),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawBarGraphs($MyData);
	}
	
	/*******************************************************
	 * DrawGraph_Personnel_FeuillesDeRoute
	 *******************************************************
	 * @param int $idSalarie
	 * @return nothing
	 ******************************************************/
	function DrawGraph_Personnel_FeuillesDeRoute ($idSalarie)
	{
		/**
			Initialisation des fichiers où seront intégrés les graphiques.
		*/
		$salarie = $this->db->GetInfoSalarie ($idSalarie);
		$Title = "Synthèse des feuilles de route du salarié : " . $salarie ["nom_civil"] . " " . $salarie ["prenom"];
		$sha1 = sha1 (date ("Y-m-d H:i:s"));
		$this->Filename_GraphStd = "graph_feuille_de_route_salarie_".$sha1."_standard.png";
		$this->Filename_GraphBig = "graph_feuille_de_route_salarie_".$sha1."_big.png";
		
		/**
			Traitement du graphique.
		*/
		// Périodes.
		$periodes = array ();		
		$current = date ("m-Y");
		for ($i = 5;$i >= 0;$i--)
		{
			$refDate = new DateTime(date ("Y-m-d"));
			$date = $refDate->sub (new DateInterval("P".$i."M"));
			$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		}
		$refDate = new DateTime(date ("Y-m-d"));
		$date = $refDate->add (new DateInterval("P1M"));
		$periodes[] = array ("periode" => date("m-Y", strtotime ($date->format ("Y-m-d"))), "libelle" => strftime ("%b", strtotime (date("Y-m-d", strtotime ($date->format ("Y-m-d"))))));
		$abcisses = $periodes;
		$nbPoints = count ($abcisses);
		
		$abcissesX = "";
		foreach ($abcisses as $obj)
		{
			if ($abcissesX != "")
				$abcissesX .= ",";
			$abcissesX .= $obj["libelle"];
		}
		
		// Création des points selon les informations.
		$data_NbFeuilleRoute = array ();
		$data_Mobilisations = array ();
		$data_ZonesTerminees = array ();
		$data_UrgencesHygienes = array ();
		
		// Modification des tailles de graphiques ici.
		$this->WidthStd = 355;
		$this->HeightStd = 250;
		// Initialise the graph.
		// Création des points selon les informations.
		foreach ($abcisses as $periode)
		{
			$data_NbFeuilleRoute [] = $this->db->GetNbZonesPrevues ($idSalarie, $periode);
			$data_Mobilisations [] = $this->db->GetNbMobilisations ($idSalarie, $periode);
			$data_ZonesTerminees [] = $this->db->GetNbZonesRealisees ($idSalarie, $periode);
			$data_UrgencesHygienes [] = $this->db->GetNbUrgencesHygiene ($idSalarie, $periode);
		}
		
		/* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($data_NbFeuilleRoute,"Nb. Zones à faire");
		$MyData->addPoints($data_Mobilisations,"Nb. Mobilisations");
		$MyData->addPoints($data_ZonesTerminees,"NB. Zones terminées");
		$MyData->addPoints($data_UrgencesHygienes,"Nb. d'Urgences");
		$MyData->setAxisName(0,"Quantité / jours");
		$MyData->addPoints(explode (",", $abcissesX),"Months");
		$MyData->setSerieDescription("Months","Jours du mois");
		$MyData->setAbscissa("Months");
		
		$this->__drawStackedBarGraphs($MyData);
	}
	
	function SetGraphics ($fileStd, $fileBig)
	{
		$this->Filename_GraphStd = $fileStd;
		
		$this->Filename_GraphBig = $fileBig;
	}
};
?>