CREATE DATABASE IF NOT EXISTS nkedon_db_dev;

USE nkedon_db_dev;

DROP TABLE IF EXISTS t_achats;

CREATE TABLE `t_achats` (
  `idt_achats` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `id_facture` int(11) NOT NULL,
  `quantite_achat` int(11) NOT NULL,
  `date_fabrication` date NOT NULL,
  `date_peremption` date NOT NULL,
  PRIMARY KEY (`idt_achats`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

INSERT INTO t_achats VALUES("38","225","2","45","0000-00-00","0000-00-00");
INSERT INTO t_achats VALUES("39","321","2","12","2014-07-01","2014-07-31");
INSERT INTO t_achats VALUES("40","7","2","8","0000-00-00","0000-00-00");
INSERT INTO t_achats VALUES("41","121","2","12","0000-00-00","0000-00-00");
INSERT INTO t_achats VALUES("42","217","2","12","0000-00-00","0000-00-00");
INSERT INTO t_achats VALUES("43","301","1","4","2014-07-09","0000-00-00");
INSERT INTO t_achats VALUES("44","271","1","78","0000-00-00","0000-00-00");
INSERT INTO t_achats VALUES("45","240","1","14","2014-07-01","2014-07-31");
INSERT INTO t_achats VALUES("46","748","1","4","0000-00-00","0000-00-00");



DROP TABLE IF EXISTS t_factures;

CREATE TABLE `t_factures` (
  `idt_factures` int(11) NOT NULL AUTO_INCREMENT,
  `numero_facture` varchar(255) NOT NULL,
  `nombre_produit` int(11) NOT NULL,
  `id_fournisseur` int(11) NOT NULL,
  `date_facture` date NOT NULL,
  `date_insertion_facture` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`idt_factures`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO t_factures VALUES("1","45812568974","4","6","2014-07-14","2014-07-16 10:18:57","0");
INSERT INTO t_factures VALUES("2","1483266","5","2","2014-07-15","2014-07-16 10:14:38","0");



DROP TABLE IF EXISTS t_fournisseurs;

CREATE TABLE `t_fournisseurs` (
  `idt_fournisseurs` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fournisseur` varchar(255) NOT NULL,
  `adresse_fournisseur` varchar(255) NOT NULL,
  `telephone_fournisseur` varchar(255) NOT NULL,
  `date_insertion` datetime NOT NULL,
  PRIMARY KEY (`idt_fournisseurs`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO t_fournisseurs VALUES("2","CHOCOCAM","Douala","33 69 65 68","0000-00-00 00:00:00");
INSERT INTO t_fournisseurs VALUES("3","HYSACAM","YaoundÃ©","33 56 58 13","0000-00-00 00:00:00");
INSERT INTO t_fournisseurs VALUES("4","CIMENCAM","Douala","33 25 47 69","0000-00-00 00:00:00");
INSERT INTO t_fournisseurs VALUES("5","ALUCAM","Edea","32 65 98 74","0000-00-00 00:00:00");
INSERT INTO t_fournisseurs VALUES("6","SOCSUBA","Douala","45 69 32 14","0000-00-00 00:00:00");
INSERT INTO t_fournisseurs VALUES("7","BOLLORE","Douala","23 56 41 78","2014-02-22 12:51:47");
INSERT INTO t_fournisseurs VALUES("8","DARTY","Lyon","25 36 69 87","2014-06-16 19:43:57");



DROP TABLE IF EXISTS t_groupes_factures;

CREATE TABLE `t_groupes_factures` (
  `idt_groupes_factures` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `nombre_factures` int(11) NOT NULL,
  `date_synthese` datetime NOT NULL,
  PRIMARY KEY (`idt_groupes_factures`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO t_groupes_factures VALUES("1","Janvier 2014","0","2014-01-16 00:00:00");
INSERT INTO t_groupes_factures VALUES("2","Février 2014","0","2014-02-16 00:00:00");
INSERT INTO t_groupes_factures VALUES("3","Mars 2014","0","2014-03-16 00:00:00");
INSERT INTO t_groupes_factures VALUES("4","Avril 2014","0","2014-04-16 00:00:00");
INSERT INTO t_groupes_factures VALUES("5","Mai 2014","0","2014-05-16 00:00:00");
INSERT INTO t_groupes_factures VALUES("6","Juin 2014","0","2014-06-16 00:00:00");



DROP TABLE IF EXISTS t_historiques_achats;

CREATE TABLE `t_historiques_achats` (
  `idt_historiques_achats` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `id_facture` int(11) NOT NULL,
  `quantite_achat` int(11) NOT NULL,
  `date_fabrication` date NOT NULL,
  `date_peremption` date NOT NULL,
  PRIMARY KEY (`idt_historiques_achats`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

INSERT INTO t_historiques_achats VALUES("1","322","23","54","2014-02-11","2014-02-28");
INSERT INTO t_historiques_achats VALUES("2","441","24","4","2014-02-18","2014-03-28");
INSERT INTO t_historiques_achats VALUES("3","218","25","14","2014-02-06","2014-02-28");
INSERT INTO t_historiques_achats VALUES("4","24","25","8","2014-02-01","2014-02-28");
INSERT INTO t_historiques_achats VALUES("5","7","26","17","2014-02-06","2014-04-27");
INSERT INTO t_historiques_achats VALUES("6","240","26","19","2014-02-11","2014-03-31");
INSERT INTO t_historiques_achats VALUES("7","217","27","12","2014-02-12","2014-03-07");
INSERT INTO t_historiques_achats VALUES("8","269","27","45","2014-02-12","2014-03-13");
INSERT INTO t_historiques_achats VALUES("9","221","28","52","2014-02-05","2014-02-24");
INSERT INTO t_historiques_achats VALUES("10","441","29","36","2014-03-04","2014-03-31");
INSERT INTO t_historiques_achats VALUES("11","531","30","12","2014-03-01","2014-03-15");
INSERT INTO t_historiques_achats VALUES("12","322","31","54","2014-02-11","2014-02-28");
INSERT INTO t_historiques_achats VALUES("13","441","32","4","2014-02-18","2014-03-28");
INSERT INTO t_historiques_achats VALUES("14","218","33","14","2014-02-06","2014-02-28");
INSERT INTO t_historiques_achats VALUES("15","24","33","8","2014-02-01","2014-02-28");
INSERT INTO t_historiques_achats VALUES("16","7","34","17","2014-02-06","2014-04-27");
INSERT INTO t_historiques_achats VALUES("17","240","34","19","2014-02-11","2014-03-31");
INSERT INTO t_historiques_achats VALUES("18","271","34","47","2014-03-04","2014-03-29");
INSERT INTO t_historiques_achats VALUES("19","217","35","12","2014-02-12","2014-03-07");
INSERT INTO t_historiques_achats VALUES("20","269","35","45","2014-02-12","2014-03-13");
INSERT INTO t_historiques_achats VALUES("21","221","36","52","2014-02-05","2014-02-24");
INSERT INTO t_historiques_achats VALUES("22","441","37","36","2014-03-04","2014-03-31");
INSERT INTO t_historiques_achats VALUES("23","531","38","12","2014-03-01","2014-03-15");



DROP TABLE IF EXISTS t_historiques_factures;

CREATE TABLE `t_historiques_factures` (
  `idt_historiques_factures` int(11) NOT NULL AUTO_INCREMENT,
  `numero_facture` int(11) NOT NULL,
  `id_fournisseur` int(11) NOT NULL,
  `date_facture` date NOT NULL,
  `date_insertion_facture` datetime NOT NULL,
  `id_groupes_factures` int(11) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  PRIMARY KEY (`idt_historiques_factures`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

INSERT INTO t_historiques_factures VALUES("23","887","3","2014-02-10","2014-02-19 21:47:00","2","");
INSERT INTO t_historiques_factures VALUES("24","114422","3","2014-02-11","2014-03-03 20:48:48","2","");
INSERT INTO t_historiques_factures VALUES("25","10214","2","2014-02-13","2014-02-19 19:25:50","2","");
INSERT INTO t_historiques_factures VALUES("26","55889778","4","2014-02-14","2014-03-03 20:51:47","2","");
INSERT INTO t_historiques_factures VALUES("27","778","3","2014-02-19","2014-02-22 23:55:44","2","");
INSERT INTO t_historiques_factures VALUES("28","458796","7","2014-02-22","2014-02-22 23:56:41","2","");
INSERT INTO t_historiques_factures VALUES("29","7856","2","2014-03-03","2014-03-03 21:17:35","3","");
INSERT INTO t_historiques_factures VALUES("30","458","2","2014-03-08","2014-03-08 14:16:09","3","");
INSERT INTO t_historiques_factures VALUES("31","887","3","2014-02-10","2014-02-19 21:47:00","2","");
INSERT INTO t_historiques_factures VALUES("32","114422","3","2014-02-11","2014-03-03 20:48:48","3","");
INSERT INTO t_historiques_factures VALUES("33","10214","2","2014-02-13","2014-02-19 19:25:50","2","");
INSERT INTO t_historiques_factures VALUES("34","55889778","4","2014-02-14","2014-03-09 20:05:43","2","");
INSERT INTO t_historiques_factures VALUES("35","778","3","2014-02-19","2014-02-22 23:55:44","2","");
INSERT INTO t_historiques_factures VALUES("36","458796","7","2014-02-22","2014-02-22 23:56:41","2","");
INSERT INTO t_historiques_factures VALUES("37","7856","2","2014-03-03","2014-03-03 21:17:35","3","");
INSERT INTO t_historiques_factures VALUES("38","458","2","2014-03-08","2014-03-08 14:16:09","3","");



DROP TABLE IF EXISTS t_historiques_syntheses;

CREATE TABLE `t_historiques_syntheses` (
  `idt_historiques_syntheses` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `achats_mensuels` float NOT NULL,
  `ventes_mensuelles` float NOT NULL,
  `montant_stock` float NOT NULL,
  `montant_charges_diverses` float NOT NULL,
  `fonds_especes` float NOT NULL,
  `patrimoine` float NOT NULL,
  `recettes_percues` float NOT NULL,
  `benefice_brut` float NOT NULL,
  `benefice_net` float NOT NULL,
  `ecart` float NOT NULL,
  `date_inventaire` datetime NOT NULL,
  `ration` float NOT NULL,
  `dette_fournisseur` float NOT NULL,
  `depenses_diverses` float NOT NULL,
  `avaries` float NOT NULL,
  `credit_client` float NOT NULL,
  `capsules` float NOT NULL,
  `solde` float NOT NULL,
  `filepath` varchar(255) NOT NULL,
  PRIMARY KEY (`idt_historiques_syntheses`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

INSERT INTO t_historiques_syntheses VALUES("18","2","0","0","0","0","0","0","0","0","0","0","2014-02-12 22:16:48","0","0","0","0","0","0","0","Inventaire_20140212/inventaire_221654.pdf");
INSERT INTO t_historiques_syntheses VALUES("19","2","7920","806838","6580960","0","0","6580960","0","90225","90225","806838","2014-02-14 10:12:56","0","0","0","0","0","0","0","Inventaire_20140214/inventaire_101535.pdf");
INSERT INTO t_historiques_syntheses VALUES("20","3","7920","6592610","0","942900","767700","767700","4562100","1207080","439378","1262810","2014-02-17 10:26:48","0","0","0","0","0","0","0","Inventaire_20140217/inventaire_102703.pdf");
INSERT INTO t_historiques_syntheses VALUES("21","7","104228","126400","2400","0","0","2400","0","24092","24092","126400","2014-03-08 13:39:10","0","0","0","0","0","0","0","Inventaire_20140308/inventaire_133928.pdf");
INSERT INTO t_historiques_syntheses VALUES("22","6","104228","131200","0","0","0","0","0","25052","25052","131200","2014-03-08 14:01:17","0","0","0","0","0","0","0","Inventaire_20140308/inventaire_140127.pdf");
INSERT INTO t_historiques_syntheses VALUES("23","6","104972","130000","0","0","0","0","0","25028","25028","130000","2014-03-08 23:03:02","0","0","0","0","0","0","0","Inventaire_20140308/inventaire_230744.pdf");
INSERT INTO t_historiques_syntheses VALUES("24","7","104972","130000","0","0","0","0","0","25028","25028","130000","2014-03-09 02:51:34","0","0","0","0","0","0","-130000","Inventaire_20140309/inventaire_030121.pdf");
INSERT INTO t_historiques_syntheses VALUES("25","6","104972","130000","0","19","1","3","8","25028","25009","129991","2014-03-09 03:13:51","8","5","1","2","3","2","-129972","Inventaire_20140309/inventaire_031413.pdf");
INSERT INTO t_historiques_syntheses VALUES("26","7","104972","130000","0","138","89","114","458","25028","24890","129453","2014-03-09 15:12:20","45","5","78","8","2","25","-129315","Inventaire_20140309/inventaire_151233.pdf");
INSERT INTO t_historiques_syntheses VALUES("27","6","104972","130000","0","610","336","1299","288","25028","24418","129376","2014-03-09 15:27:26","455","28","45","58","24","963","-128766","Inventaire_20140309/inventaire_152735.pdf");
INSERT INTO t_historiques_syntheses VALUES("28","7","104972","130000","0","5962260","564880","1249730","484848","25028","-5937240","-919728","2014-03-09 17:09:40","18484","18948","189848","5668470","66516","684848","6881990","Inventaire_20140309/inventaire_170953.pdf");
INSERT INTO t_historiques_syntheses VALUES("29","6","134347","167600","0","320633","315","1846","513","33253","-287380","166772","2014-03-09 20:06:35","315135","115","5315","53","15","1531","153861","Inventaire_20140309/inventaire_200645.pdf");
INSERT INTO t_historiques_syntheses VALUES("30","7","0","0","0","3508710","69284","118578","94438","0","-3508710","-163722","2014-03-14 22:24:21","984849","24984","44998","2448950","4928","49294","3672430","Inventaire_20140315/inventaire_003527.pdf");
INSERT INTO t_historiques_syntheses VALUES("31","7","0","0","0","45","0","0","0","0","-45","0","2014-07-03 22:35:36","45","0","0","0","0","0","45","Inventaire_20140703/inventaire_230133.pdf");
INSERT INTO t_historiques_syntheses VALUES("32","6","0","0","0","0","0","0","0","0","0","0","2014-07-05 06:08:55","0","0","0","0","0","0","0","Inventaire/inventaire_20140705_074315.pdf");
INSERT INTO t_historiques_syntheses VALUES("33","6","110259","140650","0","0","0","0","0","30391","30391","140650","2014-07-16 22:21:06","0","0","0","0","0","0","-140650","");



DROP TABLE IF EXISTS t_produits;

CREATE TABLE `t_produits` (
  `idt_produits` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(255) NOT NULL,
  `stock_initial` int(11) NOT NULL,
  `stock_physique` int(11) NOT NULL,
  `prix_achat` float NOT NULL,
  `prix_vente` float NOT NULL,
  PRIMARY KEY (`idt_produits`)
) ENGINE=InnoDB AUTO_INCREMENT=783 DEFAULT CHARSET=latin1;

INSERT INTO t_produits VALUES("1","1664 33CL","0","0","625","800");
INSERT INTO t_produits VALUES("2","1664 50CL","0","0","646","1000");
INSERT INTO t_produits VALUES("3","33 EXPORT 65CL","0","0","450","500");
INSERT INTO t_produits VALUES("4","AIR    FRESH","0","0","600","1000");
INSERT INTO t_produits VALUES("5","AJAX    350  G","0","0","634","700");
INSERT INTO t_produits VALUES("6","AJAX  750G","0","0","1100","1300");
INSERT INTO t_produits VALUES("7","ALCOOL   95","0","0","250","500");
INSERT INTO t_produits VALUES("8","ALLUMETTE","0","0","170","250");
INSERT INTO t_produits VALUES("9","ALMA","0","0","1875","2200");
INSERT INTO t_produits VALUES("10","AMPOULE     B22","0","0","110","250");
INSERT INTO t_produits VALUES("11","AMPOULE    A  VIS","0","0","200","500");
INSERT INTO t_produits VALUES("12","AMPOULE    ECO","0","0","260","500");
INSERT INTO t_produits VALUES("13","AMSTEL 65CL","0","0","542","600");
INSERT INTO t_produits VALUES("14","ANTI  ROUILLE","0","0","333","500");
INSERT INTO t_produits VALUES("15","ANTIMOUSTIQUE EN COMPRIME","0","0","75","100");
INSERT INTO t_produits VALUES("16","AROME  MAGGI   138 ML","0","0","666","700");
INSERT INTO t_produits VALUES("17","AROME  MAGGI  GM","0","0","850","1100");
INSERT INTO t_produits VALUES("18","ATOMIC  CHINOIR","0","0","62","100");
INSERT INTO t_produits VALUES("19","ATOMIC  LIQUIDE","0","0","70","100");
INSERT INTO t_produits VALUES("20","AUTHENTIC  BOMBE","0","0","84","150");
INSERT INTO t_produits VALUES("21","BALLON    PETIT","0","0","150","300");
INSERT INTO t_produits VALUES("22","BANDE  COLANTE","0","0","10","25");
INSERT INTO t_produits VALUES("23","BARBOUCHE","0","0","350","400");
INSERT INTO t_produits VALUES("24","BEAUFORT LIGH 65CL","0","0","450","500");
INSERT INTO t_produits VALUES("25","BEAUFORT ORDINAIRE 65CL","0","0","400","450");
INSERT INTO t_produits VALUES("26","BEURRE    ARMANTI  450G","0","0","834","1000");
INSERT INTO t_produits VALUES("27","BEURRE    ARMANTI  900G","0","0","1334","1500");
INSERT INTO t_produits VALUES("28","BEURRE    DE  TABLE","0","0","75","100");
INSERT INTO t_produits VALUES("29","BEURRE  JADIDA  250G","0","0","594","700");
INSERT INTO t_produits VALUES("30","BEURRE  JADIDA  450G","0","0","833","1000");
INSERT INTO t_produits VALUES("31","BEURRE  JADIDA  900G","0","0","1550","1600");
INSERT INTO t_produits VALUES("32","BEURRE  ROSA  450G","0","0","900","1000");
INSERT INTO t_produits VALUES("33","BEURRE  ROSA  900G","0","0","1400","1500");
INSERT INTO t_produits VALUES("34","BIBERON","0","0","791","1000");
INSERT INTO t_produits VALUES("35","BIC CRISTAL","0","0","70","100");
INSERT INTO t_produits VALUES("36","BISCUIT     DIGESTIVE  PLUS","0","0","87","100");
INSERT INTO t_produits VALUES("37","BISCUIT     LBM","0","0","350","500");
INSERT INTO t_produits VALUES("38","BISCUIT     NICE    100F","0","0","70","100");
INSERT INTO t_produits VALUES("39","BISCUIT     NICE    25F","0","0","20","25");
INSERT INTO t_produits VALUES("40","BISCUIT    BIFA","0","0","350","500");
INSERT INTO t_produits VALUES("41","BISCUIT    BISS CLASS","0","0","355","500");
INSERT INTO t_produits VALUES("42","BISCUIT    COOKIES    BITE","0","0","375","500");
INSERT INTO t_produits VALUES("43","BISCUIT    DE    100F","0","0","87","100");
INSERT INTO t_produits VALUES("44","BISCUIT    HAM","0","0","166","200");
INSERT INTO t_produits VALUES("45","BISCUIT    MORE","0","0","84","100");
INSERT INTO t_produits VALUES("46","BISCUIT    MURCH 100 F","0","0","84","100");
INSERT INTO t_produits VALUES("47","BISCUIT    MURCH 50 F","0","0","42","50");
INSERT INTO t_produits VALUES("48","BISCUIT   CREAM","0","0","84","100");
INSERT INTO t_produits VALUES("49","BISCUIT   LUCIE","0","0","150","200");
INSERT INTO t_produits VALUES("50","BISCUIT  ANITA","0","0","84","100");
INSERT INTO t_produits VALUES("51","BISCUIT  BINTO","0","0","350","500");
INSERT INTO t_produits VALUES("52","BISCUIT  BISCOLATA","0","0","105","125");
INSERT INTO t_produits VALUES("53","BISCUIT  BUTTER COOKIES","0","0","1834","2300");
INSERT INTO t_produits VALUES("54","BISCUIT  DELICIOUS","0","0","875","1000");
INSERT INTO t_produits VALUES("55","BISCUIT  FOURRE  HELENA","0","0","800","1000");
INSERT INTO t_produits VALUES("56","BISCUIT  GATA","0","0","89","100");
INSERT INTO t_produits VALUES("57","BISCUIT  MEGA CHOCK","0","0","708","1000");
INSERT INTO t_produits VALUES("58","BISCUIT  MILK  CHOC","0","0","87","100");
INSERT INTO t_produits VALUES("59","BISCUIT  NICE DE 500","0","0","350","500");
INSERT INTO t_produits VALUES("60","BISCUIT  PANIA","0","0","83","100");
INSERT INTO t_produits VALUES("61","BISCUIT  PARLE  G   100F","0","0","87","100");
INSERT INTO t_produits VALUES("62","BISCUIT  PARLE  G   25F","0","0","19","25");
INSERT INTO t_produits VALUES("63","BISCUIT  PARLE  G   50F","0","0","40","50");
INSERT INTO t_produits VALUES("64","BISCUIT  PICNIC","0","0","87","100");
INSERT INTO t_produits VALUES("65","BISCUIT  SANDWICH","0","0","500","600");
INSERT INTO t_produits VALUES("66","BISCUIT  SPRITS","0","0","900","1000");
INSERT INTO t_produits VALUES("67","BISCUIT  TANGO","0","0","96","125");
INSERT INTO t_produits VALUES("68","BISCUIT  TASTE","0","0","70","100");
INSERT INTO t_produits VALUES("69","BISCUIT  TIGATO","0","0","350","500");
INSERT INTO t_produits VALUES("70","BISCUIT  TROP   TOP","0","0","687","800");
INSERT INTO t_produits VALUES("71","BISCUIT  WAFFY","0","0","222","300");
INSERT INTO t_produits VALUES("72","BISCUIT  WEEK","0","0","166","200");
INSERT INTO t_produits VALUES("73","BISCUIT  WHEAT","0","0","166","200");
INSERT INTO t_produits VALUES("74","BLEDILAIT  400G","0","0","2583","3000");
INSERT INTO t_produits VALUES("75","BLEDILAIT  CROISSANCE","0","0","2000","2300");
INSERT INTO t_produits VALUES("76","BLEDILAIT 900G","0","0","5333","5500");
INSERT INTO t_produits VALUES("77","BLEU  A  LINGE","0","0","70","100");
INSERT INTO t_produits VALUES("78","BLEU  DIAMOND  MAQUERELLE  GM","0","0","666","800");
INSERT INTO t_produits VALUES("79","BLOW UP CHEWINGUM","0","0","18","25");
INSERT INTO t_produits VALUES("80","BOBB   INALER ","0","0","250","300");
INSERT INTO t_produits VALUES("81","BOITE  ACADEMY","0","0","350","500");
INSERT INTO t_produits VALUES("82","BONBON    CAFE","0","0","13","25");
INSERT INTO t_produits VALUES("83","BONBON    GINGER","0","0","21","25");
INSERT INTO t_produits VALUES("84","BONBON    MAXI  GINGER","0","0","9","25");
INSERT INTO t_produits VALUES("85","BONBON   KOLA","0","0","21","25");
INSERT INTO t_produits VALUES("86","BONBON   MILKY POP","0","0","20","25");
INSERT INTO t_produits VALUES("87","BONBON  ARCOR","0","0","85","100");
INSERT INTO t_produits VALUES("88","BONBON  BUTIK","0","0","20","25");
INSERT INTO t_produits VALUES("89","BONBON  CUP CARAMEL","0","0","75","100");
INSERT INTO t_produits VALUES("90","BONBON  CUP COFITOS","0","0","75","100");
INSERT INTO t_produits VALUES("91","BONBON  CUP FRAISE","0","0","75","100");
INSERT INTO t_produits VALUES("92","BONBON  DE   25F","0","0","22","25");
INSERT INTO t_produits VALUES("93","BONBON  FREH  ACTION","0","0","75","100");
INSERT INTO t_produits VALUES("94","BONBON  ICE  VERT","0","0","250","300");
INSERT INTO t_produits VALUES("95","BONBON  ICE ROUGE","0","0","250","300");
INSERT INTO t_produits VALUES("96","BONBON ICE  BLEU","0","0","250","300");
INSERT INTO t_produits VALUES("97","BONBON TOMTOM","0","0","14","25");
INSERT INTO t_produits VALUES("98","BONBON YOUPI","0","0","22","25");
INSERT INTO t_produits VALUES("99","BOOSTER","0","0","433","500");
INSERT INTO t_produits VALUES("100","BOUGIE","0","0","64","100");
INSERT INTO t_produits VALUES("101","BRIDEL  LAIT   400G","0","0","1950","2200");
INSERT INTO t_produits VALUES("102","BRIDEL DEMI ECREME","0","0","1000","1200");
INSERT INTO t_produits VALUES("103","BRIQUET","0","0","70","100");
INSERT INTO t_produits VALUES("104","BROSSE   A  CIRER","0","0","166","250");
INSERT INTO t_produits VALUES("105","BROSSE   A  DENT    V  I  P","0","0","150","200");
INSERT INTO t_produits VALUES("106","BROSSE  A  DENT   DE  200F","0","0","62","200");
INSERT INTO t_produits VALUES("107","BROSSE  A  LINGE  GRAND","0","0","300","500");
INSERT INTO t_produits VALUES("108","BROSSE  A  LINGE  PM","0","0","166","200");
INSERT INTO t_produits VALUES("109","BROSSE  A DENT  ORAL  B   DE  600F","0","0","469","600");
INSERT INTO t_produits VALUES("110","BROSSE  ADENT  COBOR","0","0","113","300");
INSERT INTO t_produits VALUES("111","BROSSE  ADENT  ORA B  500","0","0","400","500");
INSERT INTO t_produits VALUES("112","BROSSE  ANTI CARRIE","0","0","216","350");
INSERT INTO t_produits VALUES("113","BROSSE  DOUBLE  ACTION ","0","0","283","400");
INSERT INTO t_produits VALUES("114","BROSSE A DENT COLGATE","0","0","250","400");
INSERT INTO t_produits VALUES("115","BROSSE A DENT ORAL B","0","0","392","500");
INSERT INTO t_produits VALUES("116","BROSSE A DENT ORAL B DE 300F","0","0","250","300");
INSERT INTO t_produits VALUES("117","CADENAS  PALOCK","0","0","233","400");
INSERT INTO t_produits VALUES("118","CAFE   DELICE   250G","0","0","980","1200");
INSERT INTO t_produits VALUES("119","CAFE  FORCE  2      250G","0","0","980","1200");
INSERT INTO t_produits VALUES("120","CAFE  FORCE  2      500G","0","0","1917","2200");
INSERT INTO t_produits VALUES("121","CAFE  VITAL  250G","0","0","822","1000");
INSERT INTO t_produits VALUES("122","CAFE PLIBERT  1KG","0","0","5000","5500");
INSERT INTO t_produits VALUES("123","CAFE PLIBERT  250G","0","0","1350","1500");
INSERT INTO t_produits VALUES("124","CAFE PLIBERT  500G","0","0","2600","3000");
INSERT INTO t_produits VALUES("125","CAFE TINO 3 EN 1","0","0","80","100");
INSERT INTO t_produits VALUES("126","CAFE VITAL   500G","0","0","1624","2000");
INSERT INTO t_produits VALUES("127","CAFENEX  SACHET","0","0","10","50");
INSERT INTO t_produits VALUES("128","CAHIER   100PAGES","0","0","170","250");
INSERT INTO t_produits VALUES("129","CAHIER  100  PAGES  T P","0","0","430","600");
INSERT INTO t_produits VALUES("130","CAHIER  120 PAGES","0","0","220","300");
INSERT INTO t_produits VALUES("131","CAHIER  144  PAGES","0","0","230","350");
INSERT INTO t_produits VALUES("132","CAHIER  200  PAGES   TP","0","0","700","900");
INSERT INTO t_produits VALUES("133","CAHIER  200 PAGES","0","0","320","450");
INSERT INTO t_produits VALUES("134","CAHIER  288  PAGES","0","0","500","650");
INSERT INTO t_produits VALUES("135","CAHIER  300  PAGES","0","0","540","700");
INSERT INTO t_produits VALUES("136","CAHIER  32 PAGES","0","0","90","100");
INSERT INTO t_produits VALUES("137","CAHIER  50 PAGES","0","0","104","150");
INSERT INTO t_produits VALUES("138","CAHIER  ANGLAIS  20  LEAVES","0","0","72","100");
INSERT INTO t_produits VALUES("139","CAHIER  ANGLAIS  40  LEAVES","0","0","127","200");
INSERT INTO t_produits VALUES("140","CAHIER  ANGLAIS  80 LEAVES","0","0","200","400");
INSERT INTO t_produits VALUES("141","CAHIER  DE  DESSIN","0","0","65","100");
INSERT INTO t_produits VALUES("142","CAHIER ANGLAIS  60 LEAVES","0","0","200","300");
INSERT INTO t_produits VALUES("143","CALCULATRICE","0","0","800","1000");
INSERT INTO t_produits VALUES("144","CAMLAIT","0","0","215","250");
INSERT INTO t_produits VALUES("145","CAROLIGHT CREAM","0","0","1300","1600");
INSERT INTO t_produits VALUES("146","CARTE     MTN  1000 F","0","0","950","1000");
INSERT INTO t_produits VALUES("147","CARTE     MTN  10000 F","0","0","9500","10000");
INSERT INTO t_produits VALUES("148","CARTE     MTN  2500 F","0","0","2375","2500");
INSERT INTO t_produits VALUES("149","CARTE     MTN  5000 F","0","0","4750","5000");
INSERT INTO t_produits VALUES("150","CARTE    ORANGE  1000 F","0","0","950","1000");
INSERT INTO t_produits VALUES("151","CARTE    ORANGE  10000 F","0","0","9500","10000");
INSERT INTO t_produits VALUES("152","CARTE    ORANGE  2000 F","0","0","1800","2000");
INSERT INTO t_produits VALUES("153","CARTE    ORANGE  3000 F","0","0","2750","3000");
INSERT INTO t_produits VALUES("154","CARTE    ORANGE  5000 F","0","0","4750","5000");
INSERT INTO t_produits VALUES("155","CASSOULLET    GM","0","0","1916","2000");
INSERT INTO t_produits VALUES("156","CASSOULLET  PM","0","0","1125","1300");
INSERT INTO t_produits VALUES("157","CASTEL   33CL","0","0","267","350");
INSERT INTO t_produits VALUES("158","CASTEL 65CL","0","0","500","550");
INSERT INTO t_produits VALUES("159","CASTLE MILK STOUT","0","0","542","600");
INSERT INTO t_produits VALUES("160","CERELAC BLE  400G","0","0","2355","2600");
INSERT INTO t_produits VALUES("161","CERELAC SACHET 50G","0","0","200","250");
INSERT INTO t_produits VALUES("162","CERELAC TROIS  FRUIT  400G","0","0","2633","2900");
INSERT INTO t_produits VALUES("163","CHANPIGON  400G","0","0","916","1100");
INSERT INTO t_produits VALUES("164","CHAUSSURE  BARBOUCHE","0","0","650","1000");
INSERT INTO t_produits VALUES("165","CHEMISE  CARTONNEE","0","0","35","100");
INSERT INTO t_produits VALUES("166","CHI  CHI","0","0","150","200");
INSERT INTO t_produits VALUES("167","CHIGUIM  CHOCOCAM","0","0","25","50");
INSERT INTO t_produits VALUES("168","CHIGUM  EUROPE","0","0","40","50");
INSERT INTO t_produits VALUES("169","CHINGUM XXL","0","0","22","50");
INSERT INTO t_produits VALUES("170","CHOCO  BROLI","0","0","1200","1400");
INSERT INTO t_produits VALUES("171","CHOCO CROC","0","0","140","150");
INSERT INTO t_produits VALUES("172","CHOCOLAT    CARRE","0","0","17","25");
INSERT INTO t_produits VALUES("173","CHOCOLAT    DE  50F","0","0","35","50");
INSERT INTO t_produits VALUES("174","CHOCOLAT   LAMONT","0","0","95","125");
INSERT INTO t_produits VALUES("175","CHOCOLAT   MAXI","0","0","83","100");
INSERT INTO t_produits VALUES("176","CHOCOLAT   PLUTO","0","0","91","100");
INSERT INTO t_produits VALUES("177","CHOCOLAT  AU   LAIT  100G","0","0","544","600");
INSERT INTO t_produits VALUES("178","CHOCOLAT  CIKILOP","0","0","104","125");
INSERT INTO t_produits VALUES("179","CHOCOLAT  DE  100F","0","0","83","100");
INSERT INTO t_produits VALUES("180","CHOCOLAT  JACKY","0","0","83","100");
INSERT INTO t_produits VALUES("181","CHOCOLAT LALA 400G","0","0","1250","1500");
INSERT INTO t_produits VALUES("182","CHOCOLAT MAMBO","0","0","110","150");
INSERT INTO t_produits VALUES("183","CIGARETTE    BUSINESS","0","0","700","1000");
INSERT INTO t_produits VALUES("184","CIGARETTE    MALBORO","0","0","800","1000");
INSERT INTO t_produits VALUES("185","CIGARETTE    MALBORO  LIGHT","0","0","750","1000");
INSERT INTO t_produits VALUES("186","CIGARETTE  BENSON","0","0","40","50");
INSERT INTO t_produits VALUES("187","CIGARETTE  L B","0","0","21","25");
INSERT INTO t_produits VALUES("188","CIGARETTE MALBORO","0","0","800","1000");
INSERT INTO t_produits VALUES("189","CIRAGE  KIWI","0","0","375","500");
INSERT INTO t_produits VALUES("190","CIRAGE  LIQUIDE","0","0","416","700");
INSERT INTO t_produits VALUES("191","CISEAU","0","0","100","200");
INSERT INTO t_produits VALUES("192","CONDON","0","0","58","100");
INSERT INTO t_produits VALUES("193","CORNICHON","0","0","958","1200");
INSERT INTO t_produits VALUES("194","COTON      SITA","0","0","262","400");
INSERT INTO t_produits VALUES("195","COTON  TIGE  BOITE","0","0","166","250");
INSERT INTO t_produits VALUES("196","COTON  TIGE  SACHET","0","0","65","100");
INSERT INTO t_produits VALUES("197","COUCHE  ORIDEL","0","0","4500","5000");
INSERT INTO t_produits VALUES("198","COUCHE PAMPERS DE  37000","0","0","3300","3700");
INSERT INTO t_produits VALUES("199","COUCHE PAMPERS DE 10500","0","0","9500","10500");
INSERT INTO t_produits VALUES("200","COUCHE PAMPERS DE 1500","0","0","1200","1500");
INSERT INTO t_produits VALUES("201","COUCHE PAMPERS DE 5000","0","0","4770","5000");
INSERT INTO t_produits VALUES("202","COUCHES PAMPERS DE 500 ","0","0","4768","5000");
INSERT INTO t_produits VALUES("203","CRAIE","0","0","13","25");
INSERT INTO t_produits VALUES("204","CRAYON    ORDINAIRE","0","0","12","25");
INSERT INTO t_produits VALUES("205","CRAYON  CONTE","0","0","24","50");
INSERT INTO t_produits VALUES("206","CRAYON  COULEUR  GM","0","0","291","400");
INSERT INTO t_produits VALUES("207","CRAYON  COULEUR  PM","0","0","116","250");
INSERT INTO t_produits VALUES("208","CREAM  DOROT","0","0","500","600");
INSERT INTO t_produits VALUES("209","CREAM PURSKIN","0","0","1300","1600");
INSERT INTO t_produits VALUES("210","CRESYL  1L","0","0","300","500");
INSERT INTO t_produits VALUES("211","CUBE  HONIG","0","0","9","10");
INSERT INTO t_produits VALUES("212","CUBE  PRIMA","0","0","20","25");
INSERT INTO t_produits VALUES("213","CUIRE  DENT","0","0","66","100");
INSERT INTO t_produits VALUES("214","DEODERANT  VICKY","0","0","500","800");
INSERT INTO t_produits VALUES("215","DEODORANT   DE  1000F","0","0","625","1000");
INSERT INTO t_produits VALUES("216","DEODORANT  BECKON","0","0","500","1000");
INSERT INTO t_produits VALUES("217","DESODO","0","0","175","250");
INSERT INTO t_produits VALUES("218","DJINO  COCKTAIL","0","0","350","400");
INSERT INTO t_produits VALUES("219","DJINO  PET  50 CL","0","0","450","500");
INSERT INTO t_produits VALUES("220","DOUILLE","0","0","166","300");
INSERT INTO t_produits VALUES("221","EAU   SACHET","0","0","33","50");
INSERT INTO t_produits VALUES("222","EAU AQUABELLE","0","0","175","250");
INSERT INTO t_produits VALUES("223","EFFRALGAN","0","0","56","100");
INSERT INTO t_produits VALUES("224","ENVELOPPE   A4","0","0","36","100");
INSERT INTO t_produits VALUES("225","ENVELOPPE   A5","0","0","25","50");
INSERT INTO t_produits VALUES("226","ENVELOPPE   A6","0","0","11","25");
INSERT INTO t_produits VALUES("227","EPONGE  METALIQUE","0","0","59","75");
INSERT INTO t_produits VALUES("228","EXPORT     33CL","0","0","266","350");
INSERT INTO t_produits VALUES("229","FIL  A  COUDRE","0","0","29","100");
INSERT INTO t_produits VALUES("230","FIL  A  TRESSER","0","0","34","50");
INSERT INTO t_produits VALUES("231","FILTRE  A CAFE  N4","0","0","900","1200");
INSERT INTO t_produits VALUES("232","FOSTER  CLARKS","0","0","154","200");
INSERT INTO t_produits VALUES("233","FRANCE LAIT","0","0","2733","3000");
INSERT INTO t_produits VALUES("234","FRESCO","0","0","259","350");
INSERT INTO t_produits VALUES("235","FROMAGE  V    Q       R","0","0","90","125");
INSERT INTO t_produits VALUES("236","FRUITAS 1L","0","0","650","800");
INSERT INTO t_produits VALUES("237","GARNITURE  TOP  DRY","0","0","450","600");
INSERT INTO t_produits VALUES("238","GARNITURE  ULTRA  WING","0","0","450","600");
INSERT INTO t_produits VALUES("239","GEL  DE  CHEVEUX","0","0","350","500");
INSERT INTO t_produits VALUES("240","GILETTE DE 1100","0","0","880","1100");
INSERT INTO t_produits VALUES("241","GILETTE DE 750","0","0","581","750");
INSERT INTO t_produits VALUES("242","GILETTE GEL A RASER","0","0","2100","2500");
INSERT INTO t_produits VALUES("243","GILLETTE   DEODORANT","0","0","2760","3500");
INSERT INTO t_produits VALUES("244","GILLETTE  700","0","0","545","700");
INSERT INTO t_produits VALUES("245","GILLETTE  DE  750","0","0","650","750");
INSERT INTO t_produits VALUES("246","GILLETTE  GEL  A   RASER","0","0","2200","2500");
INSERT INTO t_produits VALUES("247","GILLETTE  MOUSSE A  RASER","0","0","1700","2000");
INSERT INTO t_produits VALUES("248","GILLETTE 1100","0","0","900","1100");
INSERT INTO t_produits VALUES("249","GLYCERINE   GM","0","0","250","500");
INSERT INTO t_produits VALUES("250","GLYCERINE   PM","0","0","166","200");
INSERT INTO t_produits VALUES("251","GOMME","0","0","50","100");
INSERT INTO t_produits VALUES("252","GUIGOZ   CLASSIC","0","0","1814","2000");
INSERT INTO t_produits VALUES("253","GUIGOZ   FRUIT","0","0","2458","2600");
INSERT INTO t_produits VALUES("254","GUINESS PM","0","0","496","550");
INSERT INTO t_produits VALUES("255","GUINNESS    HARP  P","0","0","489","550");
INSERT INTO t_produits VALUES("256","GUINNESS    SMOOHT","0","0","536","600");
INSERT INTO t_produits VALUES("257","GUINNESS   GM","0","0","831","900");
INSERT INTO t_produits VALUES("258","GUINNESS   GOLD  PHARD","0","0","532","600");
INSERT INTO t_produits VALUES("259","GUINNESS   ICE  BLACK","0","0","454","500");
INSERT INTO t_produits VALUES("260","GUINNESS   MALTA","0","0","456","500");
INSERT INTO t_produits VALUES("261","GUINNESS   PM","0","0","496","550");
INSERT INTO t_produits VALUES("262","GUINNESS   SATZEMBRAU","0","0","495","550");
INSERT INTO t_produits VALUES("263","GUINNESS GM","0","0","831","900");
INSERT INTO t_produits VALUES("264","GUINNESS GOLD HARP","0","0","532","600");
INSERT INTO t_produits VALUES("265","GUINNESS ICE ROUGE","0","0","410","450");
INSERT INTO t_produits VALUES("266","GUINNESS MALTA","0","0","456","500");
INSERT INTO t_produits VALUES("267","HEINEKEN 33CL","0","0","563","800");
INSERT INTO t_produits VALUES("268","HEINEKEN 50CL","0","0","625","1000");
INSERT INTO t_produits VALUES("269","HEINEKEN 65CL","0","0","1000","1200");
INSERT INTO t_produits VALUES("270","HIENEKEN  33CL","0","0","565","800");
INSERT INTO t_produits VALUES("271","HIENEKEN  50CL","0","0","625","800");
INSERT INTO t_produits VALUES("272","HIENEKEN  BOUTEILLE  65CL","0","0","1000","1200");
INSERT INTO t_produits VALUES("273","HOLLYWOOD CHIGUM","0","0","75","100");
INSERT INTO t_produits VALUES("274","HUILE   DE   CHEVEUX","0","0","325","500");
INSERT INTO t_produits VALUES("275","HUILE  AZUR","0","0","1120","1250");
INSERT INTO t_produits VALUES("276","HUILE  JADIDA","0","0","1650","2000");
INSERT INTO t_produits VALUES("277","HUILE  MAYOR      1/4L","0","0","373","450");
INSERT INTO t_produits VALUES("278","HUILE  MAYOR  1L","0","0","1066","1250");
INSERT INTO t_produits VALUES("279","HUILE  MAYOR  33CL","0","0","343","400");
INSERT INTO t_produits VALUES("280","HUILE  OILIO  1L","0","0","1700","1800");
INSERT INTO t_produits VALUES("281","HUILE DOLIVE PUGET 50CL","0","0","3858","4200");
INSERT INTO t_produits VALUES("282","HUILE DOLIVE SALVADORI 25CL  ","0","0","1400","1600");
INSERT INTO t_produits VALUES("283","HUILE MAYOR 5O CL","0","0","560","600");
INSERT INTO t_produits VALUES("284","INSECTICIDE   MOONTIGER   400ML","0","0","1083","1350");
INSERT INTO t_produits VALUES("285","INSECTICIDE   TIMOR  PM","0","0","916","1300");
INSERT INTO t_produits VALUES("286","INSECTICIDE  BAYGON  300ML","0","0","1334","1600");
INSERT INTO t_produits VALUES("287","INSECTICIDE  BAYGON  400ML","0","0","2084","2500");
INSERT INTO t_produits VALUES("288","INSECTICIDE  MOONTIGER  200ML","0","0","700","900");
INSERT INTO t_produits VALUES("289","INSECTICIDE  MOONTIGER  750ML","0","0","1975","2500");
INSERT INTO t_produits VALUES("290","INSECTICIDE  NOFLY  200ML","0","0","708","900");
INSERT INTO t_produits VALUES("291","INSECTICIDE  NOFLY  400ML","0","0","1083","1350");
INSERT INTO t_produits VALUES("292","INSECTICIDE  NOFLY  750ML","0","0","1975","2500");
INSERT INTO t_produits VALUES("293","INSECTICIDE  ORO  300ML","0","0","933","1200");
INSERT INTO t_produits VALUES("294","INSECTICIDE  ORO  400G","0","0","1333","1500");
INSERT INTO t_produits VALUES("295","INSECTICIDE  ORO  500ML","0","0","1458","2000");
INSERT INTO t_produits VALUES("296","INSECTICIDE  RAID  300ML","0","0","916","1300");
INSERT INTO t_produits VALUES("297","INSECTICIDE BAYGON   600ML","0","0","3000","3500");
INSERT INTO t_produits VALUES("298","INSECTICIDE ORO  200ML","0","0","650","900");
INSERT INTO t_produits VALUES("299","INSECTICIDE ORO 750ML","0","0","2000","2500");
INSERT INTO t_produits VALUES("300","ISENBECK","0","0","542","600");
INSERT INTO t_produits VALUES("301","JAMBON","0","0","1650","2000");
INSERT INTO t_produits VALUES("302","JAVEL   250   ML","0","0","145","250");
INSERT INTO t_produits VALUES("303","JAVEL   2L","0","0","750","1000");
INSERT INTO t_produits VALUES("304","JAVEL  1L","0","0","733","1000");
INSERT INTO t_produits VALUES("305","JAVEL  4L","0","0","2375","2600");
INSERT INTO t_produits VALUES("306","JAVEL  SACHET","0","0","78","100");
INSERT INTO t_produits VALUES("307","JEUX   DE   CARTE","0","0","109","200");
INSERT INTO t_produits VALUES("308","JOUET  PETITE   VOITURE","0","0","600","1000");
INSERT INTO t_produits VALUES("309","JOVINO","0","0","80","100");
INSERT INTO t_produits VALUES("310","JUS   DUDU  MILK  500ML","0","0","495","500");
INSERT INTO t_produits VALUES("311","JUS   NATUREL","0","0","340","500");
INSERT INTO t_produits VALUES("312","JUS   REAL  FRUIT","0","0","875","1000");
INSERT INTO t_produits VALUES("313","JUS  CITRON","0","0","417","500");
INSERT INTO t_produits VALUES("314","JUS  GINGINMBRE","0","0","340","500");
INSERT INTO t_produits VALUES("315","JUS  KDD","0","0","917","1100");
INSERT INTO t_produits VALUES("316","JUS  KEN","0","0","942","1100");
INSERT INTO t_produits VALUES("317","JUS  NUTRIMILK  250ML","0","0","188","250");
INSERT INTO t_produits VALUES("318","JUS 33CL","0","0","172","200");
INSERT INTO t_produits VALUES("319","JUS BELLICH","0","0","300","400");
INSERT INTO t_produits VALUES("320","KADJI   65CL","0","0","450","500");
INSERT INTO t_produits VALUES("321","KETCHUP","0","0","1125","1300");
INSERT INTO t_produits VALUES("322","KINDE  BUENO","0","0","433","500");
INSERT INTO t_produits VALUES("323","KINDE  JOY","0","0","333","400");
INSERT INTO t_produits VALUES("324","LAIT   TINO  350G","0","0","1375","1500");
INSERT INTO t_produits VALUES("325","LAIT  BERGERE  SACHET","0","0","105","150");
INSERT INTO t_produits VALUES("326","LAIT  CONCENTRE    BROLI  1KG","0","0","1000","1200");
INSERT INTO t_produits VALUES("327","LAIT  CONCENTRE   GINO  1KG","0","0","812","1200");
INSERT INTO t_produits VALUES("328","LAIT  CONCENTRE  JAGO  1KG","0","0","1020","1250");
INSERT INTO t_produits VALUES("329","LAIT  CONCENTRE  PAVANI  1KG","0","0","1187","1300");
INSERT INTO t_produits VALUES("330","LAIT  DE   TOILETTE  SI","0","0","416","700");
INSERT INTO t_produits VALUES("331","LAIT  DE  TOILETTE   BIO  CLAIRE  350ML","0","0","1250","1500");
INSERT INTO t_produits VALUES("332","LAIT  DE  TOILETTE   CARO LIGHT  300ML","0","0","1300","1600");
INSERT INTO t_produits VALUES("333","LAIT  DE  TOILETTE   CAROTINA","0","0","366","500");
INSERT INTO t_produits VALUES("334","LAIT  DE  TOILETTE   GLYCEDERM","0","0","750","1000");
INSERT INTO t_produits VALUES("335","LAIT  DE  TOILETTE   GOLDEN   CLEAR  250ML","0","0","900","1200");
INSERT INTO t_produits VALUES("336","LAIT  DE  TOILETTE   IMMEDIAT  CLAIRE   210ML","0","0","700","900");
INSERT INTO t_produits VALUES("337","LAIT  DE  TOILETTE   MAXI  LIGHT","0","0","500","700");
INSERT INTO t_produits VALUES("338","LAIT  DE  TOILETTE   MIXA","0","0","2000","2300");
INSERT INTO t_produits VALUES("339","LAIT  DE  TOILETTE   NIVEA  HAPPY TIME  400ML","0","0","1500","2000");
INSERT INTO t_produits VALUES("340","LAIT  DE  TOILETTE   PRIMO","0","0","800","1000");
INSERT INTO t_produits VALUES("341","LAIT  DE  TOILETTE   RAPID  CLAIR  300ML","0","0","900","1200");
INSERT INTO t_produits VALUES("342","LAIT  DE  TOILETTE   SILVER  LINE","0","0","416","700");
INSERT INTO t_produits VALUES("343","LAIT  DE  TOILETTE  BOBY  LAMO  250ML","0","0","500","700");
INSERT INTO t_produits VALUES("344","LAIT  FREE   GIGT  PASSION","0","0","750","1000");
INSERT INTO t_produits VALUES("345","LAIT  INCOLAC    SACHET","0","0","80","100");
INSERT INTO t_produits VALUES("346","LAIT  PEARL  SACHET  20G","0","0","80","100");
INSERT INTO t_produits VALUES("347","LAIT  TINO    20G","0","0","83","100");
INSERT INTO t_produits VALUES("348","LAIT PURSKIN","0","0","1300","1600");
INSERT INTO t_produits VALUES("349","LAME     GILLETTE","0","0","25","50");
INSERT INTO t_produits VALUES("350","LAME TIGER","0","0","15","25");
INSERT INTO t_produits VALUES("351","LAMPE  TIGER","0","0","21","25");
INSERT INTO t_produits VALUES("352","LAMPE LANTERN","0","0","1500","2000");
INSERT INTO t_produits VALUES("353","LAVE  VITRE","0","0","1333","1700");
INSERT INTO t_produits VALUES("354","LEVURE   CHIMIQUE","0","0","60","100");
INSERT INTO t_produits VALUES("355","LINGETTE  A  ALEOVERA","0","0","900","1300");
INSERT INTO t_produits VALUES("356","LINGETTE  CREME","0","0","700","1000");
INSERT INTO t_produits VALUES("357","LINGETTE  ORIDEL","0","0","1100","1400");
INSERT INTO t_produits VALUES("358","LIPTON  THE  SACHET  PM","0","0","35","50");
INSERT INTO t_produits VALUES("359","LIPTON  THE  VERT  JAUNE","0","0","500","625");
INSERT INTO t_produits VALUES("360","LIPTON THE  CITRON","0","0","1625","1650");
INSERT INTO t_produits VALUES("361","LIQUIDE    VAISSELLE  ECLAT","0","0","900","1500");
INSERT INTO t_produits VALUES("362","LIQUIDE    VAISSELLE  L P","0","0","1415","1700");
INSERT INTO t_produits VALUES("363","LIQUIDE    VAISSELLE  MADAR","0","0","1041","1300");
INSERT INTO t_produits VALUES("364","LIQUIDE  M R  PROPRE  PM","0","0","1197","1300");
INSERT INTO t_produits VALUES("365","LIQUIDE  MR  PROPRE  125 L","0","0","1425","1700");
INSERT INTO t_produits VALUES("366","LOTION    GM","0","0","400","500");
INSERT INTO t_produits VALUES("367","MACARONI   PANZANI   250G","0","0","225","250");
INSERT INTO t_produits VALUES("368","MACARONI  KARELIA  500G","0","0","450","500");
INSERT INTO t_produits VALUES("369","MACARONI  NDOLO  250G","0","0","201","250");
INSERT INTO t_produits VALUES("370","MACARONI  NDOLO  500G","0","0","475","500");
INSERT INTO t_produits VALUES("371","MACARONI  SELVA  500G","0","0","475","500");
INSERT INTO t_produits VALUES("372","MACARONI GINO 500G","0","0","400","500");
INSERT INTO t_produits VALUES("373","MACOFFEE","0","0","90","100");
INSERT INTO t_produits VALUES("374","MADAR SACHET 30GR","0","0","38","50");
INSERT INTO t_produits VALUES("375","MADAR SACHET DE 25","0","0","20","25");
INSERT INTO t_produits VALUES("376","MAGGI   CREVETTE","0","0","26","35");
INSERT INTO t_produits VALUES("377","MAGGI   TOMATE","0","0","26","35");
INSERT INTO t_produits VALUES("378","MAGGI  ETOILE","0","0","9","10");
INSERT INTO t_produits VALUES("379","MAIS  DOUX  PM","0","0","800","850");
INSERT INTO t_produits VALUES("380","MALT  UP  DARK","0","0","258","300");
INSERT INTO t_produits VALUES("381","MALTA ENERGY GOODI","0","0","417","500");
INSERT INTO t_produits VALUES("382","MALTA IMPORTE","0","0","396","450");
INSERT INTO t_produits VALUES("383","MATINAL   SACHET","0","0","60","75");
INSERT INTO t_produits VALUES("384","MATINAL  200G","0","0","983","1400");
INSERT INTO t_produits VALUES("385","MATINAL  400G","0","0","1625","1800");
INSERT INTO t_produits VALUES("386","MAYONNAISE  AMERICAN  250G","0","0","800","1000");
INSERT INTO t_produits VALUES("387","MAYONNAISE  AMERICAN  5  KG","0","0","8400","9000");
INSERT INTO t_produits VALUES("388","MAYONNAISE  AMERICAN  500G","0","0","1375","1600");
INSERT INTO t_produits VALUES("389","MAYONNAISE  ARMANTI  250G","0","0","850","1000");
INSERT INTO t_produits VALUES("390","MAYONNAISE  ARMANTI  500G","0","0","983","1300");
INSERT INTO t_produits VALUES("391","MAYONNAISE  CALVE  250G","0","0","875","1000");
INSERT INTO t_produits VALUES("392","MAYONNAISE  CALVE  500G","0","0","1600","1800");
INSERT INTO t_produits VALUES("393","MAYONNAISE  DELICIO  1KG","0","0","1750","2000");
INSERT INTO t_produits VALUES("394","MAYONNAISE  DELICIO  500G","0","0","958","1300");
INSERT INTO t_produits VALUES("395","MAYONNAISE  JADIDA   250G","0","0","741","1000");
INSERT INTO t_produits VALUES("396","MAYONNAISE AMERICAN  1KG","0","0","2100","2300");
INSERT INTO t_produits VALUES("397","MECHE  DE   500  F","0","0","350","500");
INSERT INTO t_produits VALUES("398","MENTHOLATA   125ML","0","0","666","1000");
INSERT INTO t_produits VALUES("399","MENTHOLATUM","0","0","83","100");
INSERT INTO t_produits VALUES("400","MISTER  CHOC","0","0","1625","2000");
INSERT INTO t_produits VALUES("401","MIXAGRIP","0","0","25","50");
INSERT INTO t_produits VALUES("402","MOONTIGER  SPIRALES","0","0","26","50");
INSERT INTO t_produits VALUES("403","MOUCHOIR  DAUMA","0","0","58","100");
INSERT INTO t_produits VALUES("404","MOUCHOIR  FAY","0","0","722","850");
INSERT INTO t_produits VALUES("405","MOUCHOIR  ORAN   KLENEX","0","0","60","100");
INSERT INTO t_produits VALUES("406","MOUCHOIR  ORAN  38   38","0","0","425","500");
INSERT INTO t_produits VALUES("407","MOUCHOIR  ORAN  TABLE  33...33","0","0","766","1000");
INSERT INTO t_produits VALUES("408","MOUCHOIR PARFUME","0","0","60","100");
INSERT INTO t_produits VALUES("409","MOUTARDE  1KG","0","0","1583","1800");
INSERT INTO t_produits VALUES("410","MOUTARDE  370G","0","0","750","850");
INSERT INTO t_produits VALUES("411","MOUTARDE  PM","0","0","700","800");
INSERT INTO t_produits VALUES("412","MUSEAU","0","0","175","250");
INSERT INTO t_produits VALUES("413","MUTZIG 65CL","0","0","500","600");
INSERT INTO t_produits VALUES("414","NAN    1   2     3","0","0","3375","36");
INSERT INTO t_produits VALUES("415","NESCAFE   200G","0","0","2966","3200");
INSERT INTO t_produits VALUES("416","NESCAFE  50G","0","0","1000","1100");
INSERT INTO t_produits VALUES("417","NESCAFE  GINGER","0","0","40","50");
INSERT INTO t_produits VALUES("418","NESCAFE CREAM 3 EN 1","0","0","87","100");
INSERT INTO t_produits VALUES("419","NESCAFE SACHET","0","0","42","50");
INSERT INTO t_produits VALUES("420","NESTLE  1KG","0","0","1993","2200");
INSERT INTO t_produits VALUES("421","NESTLE  397G","0","0","822","850");
INSERT INTO t_produits VALUES("422","NESTLE  78G","0","0","204","250");
INSERT INTO t_produits VALUES("423","NIDO   12G","0","0","84","100");
INSERT INTO t_produits VALUES("424","NIDO   365G","0","0","1900","2100");
INSERT INTO t_produits VALUES("425","NIDO   400G","0","0","2208","2400");
INSERT INTO t_produits VALUES("426","NIDO   900G","0","0","5000","5200");
INSERT INTO t_produits VALUES("427","NIDO   PROTECTION  400G","0","0","2495","2700");
INSERT INTO t_produits VALUES("428","NIDO  2500G","0","0","12700","13200");
INSERT INTO t_produits VALUES("429","NIDO  SACHET  26G","0","0","167","150");
INSERT INTO t_produits VALUES("430","NIVEA   ROLLOM","0","0","1000","1500");
INSERT INTO t_produits VALUES("431","NOURRICE","0","0","215","250");
INSERT INTO t_produits VALUES("432","NURCIE  CONFORT","0","0","3225","3300");
INSERT INTO t_produits VALUES("433","NURCIE  SIMPLE","0","0","2575","3000");
INSERT INTO t_produits VALUES("434","NUTRIMILK","0","0","416","500");
INSERT INTO t_produits VALUES("435","NYLON   NOIR  400F","0","0","300","400");
INSERT INTO t_produits VALUES("436","NYLON  BLANC","0","0","100","150");
INSERT INTO t_produits VALUES("437","NYLON  DE  100 F","0","0","70","100");
INSERT INTO t_produits VALUES("438","NYLON  JAUNE  NOIR  DE  1000F","0","0","750","1000");
INSERT INTO t_produits VALUES("439","NYLON  NOIR  250 F","0","0","190","250");
INSERT INTO t_produits VALUES("440","NYLON  POISSON","0","0","25","50");
INSERT INTO t_produits VALUES("441","OEUF","0","0","64","80");
INSERT INTO t_produits VALUES("442","OLIVE  VERTE","0","0","1125","1400");
INSERT INTO t_produits VALUES("443","ORAN    VOITURE","0","0","550","800");
INSERT INTO t_produits VALUES("444","ORANGINA  60CL","0","0","367","450");
INSERT INTO t_produits VALUES("445","OVALTINE     200G","0","0","1416","1600");
INSERT INTO t_produits VALUES("446","OVALTINE     400G","0","0","2400","2600");
INSERT INTO t_produits VALUES("447","OVALTINE  SACHET","0","0","85","125");
INSERT INTO t_produits VALUES("448","PANOPLIE   GM","0","0","325","500");
INSERT INTO t_produits VALUES("449","PAPIER  ALURE  10M","0","0","800","1000");
INSERT INTO t_produits VALUES("450","PAPIER  ALURE  30M","0","0","1250","2000");
INSERT INTO t_produits VALUES("451","PAPIER  HYGIENIQUE    ALBERTO","0","0","1500","2000");
INSERT INTO t_produits VALUES("452","PAPIER  HYGIENIQUE   LINTEO","0","0","213","250");
INSERT INTO t_produits VALUES("453","PAPIER  HYGIENIQUE  EMILY","0","0","157","200");
INSERT INTO t_produits VALUES("454","PAPIER  HYGIENIQUE  JAVIS","0","0","140","200");
INSERT INTO t_produits VALUES("455","PAPIER  HYGIENIQUE  SITA","0","0","229","275");
INSERT INTO t_produits VALUES("456","PARACETAMOL","0","0","50","100");
INSERT INTO t_produits VALUES("457","PARFUM     1 MILLION","0","0","475","1000");
INSERT INTO t_produits VALUES("458","PARFUM     NIVEA","0","0","1500","2000");
INSERT INTO t_produits VALUES("459","PARFUM     TE   100ML","0","0","1000","1300");
INSERT INTO t_produits VALUES("460","PARFUM    ADIDAS   150ML","0","0","1250","1500");
INSERT INTO t_produits VALUES("461","PARFUM    CIGARE","0","0","300","500");
INSERT INTO t_produits VALUES("462","PARFUM    DE  CHAMBRE  AIR","0","0","666","1000");
INSERT INTO t_produits VALUES("463","PARFUM    DUSHA","0","0","1000","1300");
INSERT INTO t_produits VALUES("464","PARFUM    LORD","0","0","250","500");
INSERT INTO t_produits VALUES("465","PARFUM    PUCELL  GM","0","0","1000","1500");
INSERT INTO t_produits VALUES("466","PARFUM    PURE  BLACK","0","0","1000","1500");
INSERT INTO t_produits VALUES("467","PARFUM    SCENARIO  100ML","0","0","1200","1500");
INSERT INTO t_produits VALUES("468","PARFUM    SMART  150ML","0","0","1250","1500");
INSERT INTO t_produits VALUES("469","PARFUM    USHWAIA  150ML","0","0","1250","1500");
INSERT INTO t_produits VALUES("470","PARFUM  SMARST  15ML","0","0","500","700");
INSERT INTO t_produits VALUES("471","PARFUM  SMARST  15ML","0","0","350","500");
INSERT INTO t_produits VALUES("472","PARFUM AXE REXONA 200ML","0","0","1250","1500");
INSERT INTO t_produits VALUES("473","PARFUM CAMMEE","0","0","1000","1500");
INSERT INTO t_produits VALUES("474","PARFUM DE 1000F","0","0","650","1000");
INSERT INTO t_produits VALUES("475","PARFUM JADORE","0","0","1250","1500");
INSERT INTO t_produits VALUES("476","PATE      A    B    C","0","0","2200","2500");
INSERT INTO t_produits VALUES("477","PATE  DENTRFRIC00FE  ORA  B  13","0","0","1000","1300");
INSERT INTO t_produits VALUES("478","PATE  DENTRIFRICE   ORA  B   DE 1000F","0","0","790","1000");
INSERT INTO t_produits VALUES("479","PATE  DENTRIFRICE   PRO  EXPERT","0","0","467","700");
INSERT INTO t_produits VALUES("480","PATE  DENTRIFRICE  COLGATE  100ML","0","0","816","1000");
INSERT INTO t_produits VALUES("481","PATE  DENTRIFRICE  COLGATE  125ML","0","0","875","1000");
INSERT INTO t_produits VALUES("482","PATE  DENTRIFRICE  COLGATE  25ML","0","0","241","300");
INSERT INTO t_produits VALUES("483","PATE  DENTRIFRICE  COLGATE  50ML","0","0","483","550");
INSERT INTO t_produits VALUES("484","PATE  DENTRIFRICE  COLGATE  75ML","0","0","625","800");
INSERT INTO t_produits VALUES("485","PATE  DENTRIFRICE  ORAL B  95G","0","0","1000","1300");
INSERT INTO t_produits VALUES("486","PATE  DENTRIFRICE  SIGNAL   125ML","0","0","875","1000");
INSERT INTO t_produits VALUES("487","PATE  DENTRIFRICE  SIGNAL   50ML","0","0","433","550");
INSERT INTO t_produits VALUES("488","PATE  JEAN FLOCH  1KG","0","0","2000","2200");
INSERT INTO t_produits VALUES("489","PATE  JEAN FLOCH  400G","0","0","675","900");
INSERT INTO t_produits VALUES("490","PATE DENTIFRICE SIGNAL 25ML","0","0","234","300");
INSERT INTO t_produits VALUES("491","PAX     2L","0","0","2416","2500");
INSERT INTO t_produits VALUES("492","PAX    4L","0","0","4200","4500");
INSERT INTO t_produits VALUES("493","PAX    IL","0","0","1208","1500");
INSERT INTO t_produits VALUES("494","PEAK    2500G","0","0","11900","12300");
INSERT INTO t_produits VALUES("495","PEAK    48","0","0","343","400");
INSERT INTO t_produits VALUES("496","PEARL  2500G","0","0","9500","10000");
INSERT INTO t_produits VALUES("497","PEPSI","0","0","271","350");
INSERT INTO t_produits VALUES("498","PET    S       P     1,5 L","0","0","566","750");
INSERT INTO t_produits VALUES("499","PET   U   C  B  50CL","0","0","133","200");
INSERT INTO t_produits VALUES("500","PET BRASSERIE 150CL","0","0","890","1000");
INSERT INTO t_produits VALUES("501","PET BRASSERIE 35CL","0","0","209","250");
INSERT INTO t_produits VALUES("502","PET BRASSERIE 5OCL","0","0","400","500");
INSERT INTO t_produits VALUES("503","PET SUPERMONT 35CL","0","0","195","250");
INSERT INTO t_produits VALUES("504","PET SUPERMONT 50CL","0","0","133","200");
INSERT INTO t_produits VALUES("505","PET SUPERMONT SODA","0","0","141","200");
INSERT INTO t_produits VALUES("506","PETIT  POIS      GM","0","0","766","1000");
INSERT INTO t_produits VALUES("507","PETIT  POIS  PM","0","0","583","700");
INSERT INTO t_produits VALUES("508","PHOSPHATINE","0","0","1333","1500");
INSERT INTO t_produits VALUES("509","PIL  DURACEL     C","0","0","1070","1500");
INSERT INTO t_produits VALUES("510","PIL  DURACEL     D","0","0","1630","2000");
INSERT INTO t_produits VALUES("511","PIL  DURACEL   DE  2","0","0","485","1000");
INSERT INTO t_produits VALUES("512","PIL  DURACEL   DE  4","0","0","875","1500");
INSERT INTO t_produits VALUES("513","PIL  HELESENS  GM  733","0","0","291","400");
INSERT INTO t_produits VALUES("514","PIL  HELESENS  R  616   M","0","0","250","300");
INSERT INTO t_produits VALUES("515","PILE  HOSTEN","0","0","80","150");
INSERT INTO t_produits VALUES("516","PILE DURACELL V","0","0","1000","1300");
INSERT INTO t_produits VALUES("517","PILE HELESSEN R3 PM","0","0","220","300");
INSERT INTO t_produits VALUES("518","PLASTIQUE  BEBE","0","0","25","50");
INSERT INTO t_produits VALUES("519","POMADE MOVAT","0","0","400","600");
INSERT INTO t_produits VALUES("520","POMPE","0","0","20","25");
INSERT INTO t_produits VALUES("521","POT  DARK  AND  LOVELY  GM","0","0","2400","2700");
INSERT INTO t_produits VALUES("522","POT  OZONE  PM","0","0","350","500");
INSERT INTO t_produits VALUES("523","POT  U  B     GM","0","0","1200","1500");
INSERT INTO t_produits VALUES("524","POUDRE  TONY MONTANA  PM","0","0","100","200");
INSERT INTO t_produits VALUES("525","PREMIO","0","0","2500","3000");
INSERT INTO t_produits VALUES("526","PRINGLES      40G","0","0","590","700");
INSERT INTO t_produits VALUES("527","PRINGLES  165G","0","0","1480","1700");
INSERT INTO t_produits VALUES("528","PRUDENCE  PLUS","0","0","58","100");
INSERT INTO t_produits VALUES("529","RAZOIR  BIC","0","0","90","125");
INSERT INTO t_produits VALUES("530","RAZOIR  GILLETTE   2HRDC","0","0","102","250");
INSERT INTO t_produits VALUES("531","RAZOIR  ZORRIK","0","0","62","100");
INSERT INTO t_produits VALUES("532","RAZOIR GILLETTE","0","0","180","200");
INSERT INTO t_produits VALUES("533","REAKTOR","0","0","362","500");
INSERT INTO t_produits VALUES("534","RED BULL","0","0","792","1000");
INSERT INTO t_produits VALUES("535","REGLE","0","0","83","150");
INSERT INTO t_produits VALUES("536","RIVER  250ML","0","0","210","250");
INSERT INTO t_produits VALUES("537","RIVER 500ML","0","0","385","500");
INSERT INTO t_produits VALUES("538","RIZ   PARFUME  BROLI   1KG","0","0","1000","1100");
INSERT INTO t_produits VALUES("539","RIZ   PARFUME  BROLI   5KG","0","0","3790","4000");
INSERT INTO t_produits VALUES("540","RIZ   PARFUME  GINO   1KG","0","0","470","500");
INSERT INTO t_produits VALUES("541","RIZ   PARFUME  GINO   500G","0","0","470","500");
INSERT INTO t_produits VALUES("542","RIZ   PARFUME  NELISA   5KG","0","0","4000","4500");
INSERT INTO t_produits VALUES("543","RIZ   PARFUME  PEROQUET   5KG","0","0","3800","4500");
INSERT INTO t_produits VALUES("544","RIZ  ORDINAIRE","0","0","360","400");
INSERT INTO t_produits VALUES("545","RIZ  PARFUME ARMANTI   5K","0","0","3500","4000");
INSERT INTO t_produits VALUES("546","ROBB","0","0","225","300");
INSERT INTO t_produits VALUES("547","ROUGE  A  LEVRE","0","0","208","400");
INSERT INTO t_produits VALUES("548","SAC  P0UBELLE  50L","0","0","1541","2000");
INSERT INTO t_produits VALUES("549","SAC  POUBELLE  30L","0","0","1375","1700");
INSERT INTO t_produits VALUES("550","SAC POUBELLE  50L","0","0","1500","1700");
INSERT INTO t_produits VALUES("551","SANOPEL","0","0","475","700");
INSERT INTO t_produits VALUES("552","SARDINE","0","0","350","450");
INSERT INTO t_produits VALUES("553","SARDINE    PIMENTE","0","0","340","450");
INSERT INTO t_produits VALUES("554","SARDINE  MAQUERELLE","0","0","300","400");
INSERT INTO t_produits VALUES("555","SAUCISSE  ARMATI","0","0","966","1200");
INSERT INTO t_produits VALUES("556","SAUCISSON","0","0","1634","2200");
INSERT INTO t_produits VALUES("557","SAVON    AZUR  200G","0","0","131","175");
INSERT INTO t_produits VALUES("558","SAVON    DOVE  ","0","0","689","800");
INSERT INTO t_produits VALUES("559","SAVON    PURAYA","0","0","208","250");
INSERT INTO t_produits VALUES("560","SAVON   72 HEURE","0","0","333","500");
INSERT INTO t_produits VALUES("561","SAVON   ACTIMED","0","0","200","250");
INSERT INTO t_produits VALUES("562","SAVON   AMIRA","0","0","750","900");
INSERT INTO t_produits VALUES("563","SAVON   ARIEL    1KG","0","0","1980","2300");
INSERT INTO t_produits VALUES("564","SAVON   ARIEL    500G","0","0","1100","1300");
INSERT INTO t_produits VALUES("565","SAVON   ARIEL  SACHET    20G","0","0","54","75");
INSERT INTO t_produits VALUES("566","SAVON   AZUR    400G","0","0","273","300");
INSERT INTO t_produits VALUES("567","SAVON   BEL  CLAIR","0","0","400","500");
INSERT INTO t_produits VALUES("568","SAVON   BLU  SACHET    20G","0","0","53","100");
INSERT INTO t_produits VALUES("569","SAVON   CARIBU","0","0","550","700");
INSERT INTO t_produits VALUES("570","SAVON   CAROLIGHT","0","0","500","700");
INSERT INTO t_produits VALUES("571","SAVON   CCC    400G","0","0","283","325");
INSERT INTO t_produits VALUES("572","SAVON   CHAT","0","0","650","800");
INSERT INTO t_produits VALUES("573","SAVON   DOROT","0","0","416","600");
INSERT INTO t_produits VALUES("574","SAVON   DOROT","0","0","416","600");
INSERT INTO t_produits VALUES("575","SAVON   FRESHA  SACHET    20G","0","0","38","50");
INSERT INTO t_produits VALUES("576","SAVON   JULIET  PM","0","0","116","250");
INSERT INTO t_produits VALUES("577","SAVON   LA  PERLE","0","0","416","600");
INSERT INTO t_produits VALUES("578","SAVON   LIFEBUOY","0","0","650","700");
INSERT INTO t_produits VALUES("579","SAVON   MADAR   1KG","0","0","1200","1500");
INSERT INTO t_produits VALUES("580","SAVON   MADAR   500GG","0","0","575","750");
INSERT INTO t_produits VALUES("581","SAVON   MEKAKO","0","0","750","900");
INSERT INTO t_produits VALUES("582","SAVON   OMO  SACHET    20G","0","0","91","100");
INSERT INTO t_produits VALUES("583","SAVON   OMO  SACHET   1KG","0","0","1800","2200");
INSERT INTO t_produits VALUES("584","SAVON   PURSKIN","0","0","800","1000");
INSERT INTO t_produits VALUES("585","SAVON   SABA    1KG","0","0","1062","1300");
INSERT INTO t_produits VALUES("586","SAVON   SABA   500G","0","0","541","750");
INSERT INTO t_produits VALUES("587","SAVON   SABA  SACHET    20G","0","0","37","50");
INSERT INTO t_produits VALUES("588","SAVON   SANET  400G","0","0","250","300");
INSERT INTO t_produits VALUES("589","SAVON   SANTEX  GM","0","0","416","500");
INSERT INTO t_produits VALUES("590","SAVON   SANTEX  PM","0","0","131","250");
INSERT INTO t_produits VALUES("591","SAVON   SOVE    30G","0","0","37","50");
INSERT INTO t_produits VALUES("592","SAVON   TETMOSOL","0","0","383","500");
INSERT INTO t_produits VALUES("593","SAVON   ZAKURO","0","0","208","250");
INSERT INTO t_produits VALUES("594","SAVON  BLU  SACHET   1KG","0","0","1700","2000");
INSERT INTO t_produits VALUES("595","SAVON  BLU  SACHET   500G","0","0","1000","1200");
INSERT INTO t_produits VALUES("596","SAVON  DETTOL","0","0","333","500");
INSERT INTO t_produits VALUES("597","SAVON  GERMOL   GM","0","0","333","500");
INSERT INTO t_produits VALUES("598","SAVON  GERMOL   PM","0","0","208","300");
INSERT INTO t_produits VALUES("599","SAVON  PHARMAPUR  GM","0","0","733","800");
INSERT INTO t_produits VALUES("600","SAVON  PHARMAPUR  PM","0","0","400","450");
INSERT INTO t_produits VALUES("601","SAVON  SIVODERM  PM","0","0","350","500");
INSERT INTO t_produits VALUES("602","SAVON MON SAVON 100G AU LAIT","0","0","500","600");
INSERT INTO t_produits VALUES("603","SAVON MON SAVON 200G AU LAIT","0","0","655","800");
INSERT INTO t_produits VALUES("604","SAVON OMO SACHET  500G","0","0","1100","1300");
INSERT INTO t_produits VALUES("605","SAVON PALMOLIVE","0","0","634","800");
INSERT INTO t_produits VALUES("606","SAVON PURE SKIN","0","0","350","500");
INSERT INTO t_produits VALUES("607","SCHWEPES TONIC","0","0","259","300");
INSERT INTO t_produits VALUES("608","SCOTCH   GM","0","0","500","700");
INSERT INTO t_produits VALUES("609","SCOTCH   PM","0","0","33","100");
INSERT INTO t_produits VALUES("610","SEAU CHOCOLATE","0","0","16000","17000");
INSERT INTO t_produits VALUES("611","SEAU DE BEURRE 10KG","0","0","14200","15000");
INSERT INTO t_produits VALUES("612","SEL  DE  CUISINE","0","0","35","50");
INSERT INTO t_produits VALUES("613","SEL  DE  CUISINE  EN  SACHET","0","0","200","300");
INSERT INTO t_produits VALUES("614","SEMME   150 CL","0","0","266","300");
INSERT INTO t_produits VALUES("615","SERRE  CHEVEUX","0","0","16","100");
INSERT INTO t_produits VALUES("616","SERVIETTE     HYGIENIX","0","0","483","600");
INSERT INTO t_produits VALUES("617","SERVIETTE   ALWAYS","0","0","500","600");
INSERT INTO t_produits VALUES("618","SERVIETTE   AMIE","0","0","483","600");
INSERT INTO t_produits VALUES("619","SERVIETTE   AMYTIME","0","0","541","600");
INSERT INTO t_produits VALUES("620","SERVIETTE   FAYTEX","0","0","424","600");
INSERT INTO t_produits VALUES("621","SERVIETTE   MYRA","0","0","458","500");
INSERT INTO t_produits VALUES("622","SHANPOING  ACTION  +","0","0","350","500");
INSERT INTO t_produits VALUES("623","SINIORA   POULET","0","0","1650","2000");
INSERT INTO t_produits VALUES("624","SIROP   BRASSERIE","0","0","633","700");
INSERT INTO t_produits VALUES("625","SIROP   PM","0","0","591","800");
INSERT INTO t_produits VALUES("626","SMAPI","0","0","83","100");
INSERT INTO t_produits VALUES("627","SODA   WATER     BRASSERIE","0","0","216","300");
INSERT INTO t_produits VALUES("628","SOUPLINE  1L","0","0","2000","2300");
INSERT INTO t_produits VALUES("629","SP PAMPL   65CL","0","0","304","400");
INSERT INTO t_produits VALUES("630","SPAGHETTI   250","0","0","232","250");
INSERT INTO t_produits VALUES("631","SPAGHETTI   500G","0","0","390","500");
INSERT INTO t_produits VALUES("632","SPAGHETTI  BROLI  250G","0","0","275","250");
INSERT INTO t_produits VALUES("633","SPAGHETTI  BROLI  500G","0","0","400","500");
INSERT INTO t_produits VALUES("634","SPAGHETTI  GINO  500G","0","0","386","450");
INSERT INTO t_produits VALUES("635","SPAGHETTI  GINO PASTA  FUSILI  500G","0","0","500","600");
INSERT INTO t_produits VALUES("636","SPAGHETTI  TRESOR   PASTA  500","0","0","332","400");
INSERT INTO t_produits VALUES("637","SPAGHETTI GINO 2 50G","0","0","207","250");
INSERT INTO t_produits VALUES("638","SPAGHETTINDOLO     500G","0","0","345","450");
INSERT INTO t_produits VALUES("639","SPRITE   BOITE","0","0","382","500");
INSERT INTO t_produits VALUES("640","STARTER","0","0","75","150");
INSERT INTO t_produits VALUES("641","SUBARU","0","0","200","500");
INSERT INTO t_produits VALUES("642","SUCRE   EN  POUDRE  1KG","0","0","700","800");
INSERT INTO t_produits VALUES("643","SUCRE   VANILLE","0","0","60","100");
INSERT INTO t_produits VALUES("644","SUCRE  EN   MORCEAU","0","0","680","800");
INSERT INTO t_produits VALUES("645","SUPER  GLUE","0","0","50","100");
INSERT INTO t_produits VALUES("646","SUPER  GLUE   ALTCO","0","0","108","150");
INSERT INTO t_produits VALUES("647","SUPERMONT    10L","0","0","950","1200");
INSERT INTO t_produits VALUES("648","SUPERMONT    5L","0","0","600","750");
INSERT INTO t_produits VALUES("649","SUPERMONT 150CL","0","0","258","300");
INSERT INTO t_produits VALUES("650","SUPERMONT 50CL","0","0","133","200");
INSERT INTO t_produits VALUES("651","TAILLE    CRAYON","0","0","37","50");
INSERT INTO t_produits VALUES("652","TAMPICO   250ML","0","0","416","500");
INSERT INTO t_produits VALUES("653","TAMPICO  SACHET","0","0","80","100");
INSERT INTO t_produits VALUES("654","TAMPON","0","0","20","50");
INSERT INTO t_produits VALUES("655","TANGUI   CITRON  50 CL","0","0","275","300");
INSERT INTO t_produits VALUES("656","TANGUI 150CL","0","0","316","333");
INSERT INTO t_produits VALUES("657","TANGUI 50CL","0","0","178","200");
INSERT INTO t_produits VALUES("658","TARTINA       POT","0","0","250","300");
INSERT INTO t_produits VALUES("659","TARTINA  450G","0","0","1000","1200");
INSERT INTO t_produits VALUES("660","TARTINA  800G","0","0","1583","1800");
INSERT INTO t_produits VALUES("661","THE  CHINOIR","0","0","500","800");
INSERT INTO t_produits VALUES("662","THE  CITRON  400G","0","0","2200","2500");
INSERT INTO t_produits VALUES("663","THE  SLIMING","0","0","1000","1500");
INSERT INTO t_produits VALUES("664","THE  TOLE  TEA","0","0","550","700");
INSERT INTO t_produits VALUES("665","TIC  TAC","0","0","88","150");
INSERT INTO t_produits VALUES("666","TIRE  BOUCHON GM","0","0","1300","2000");
INSERT INTO t_produits VALUES("667","TOMATE   NDOLO","0","0","48","100");
INSERT INTO t_produits VALUES("668","TOMATE   TRESOR","0","0","112","125");
INSERT INTO t_produits VALUES("669","TOMATE  CALYPSO","0","0","93","125");
INSERT INTO t_produits VALUES("670","TOMATE  CIAO","0","0","500","700");
INSERT INTO t_produits VALUES("671","TOMATE  ELENA","0","0","90","125");
INSERT INTO t_produits VALUES("672","TOMATE  GINO","0","0","77","100");
INSERT INTO t_produits VALUES("673","TOP        33CL","0","0","172","200");
INSERT INTO t_produits VALUES("674","TOP   65CL","0","0","338","400");
INSERT INTO t_produits VALUES("675","TOP   TONIC","0","0","218","250");
INSERT INTO t_produits VALUES("676","TOP  MILK    3  EN  1","0","0","69","100");
INSERT INTO t_produits VALUES("677","TOP  MILK  NATURE","0","0","83","100");
INSERT INTO t_produits VALUES("678","TOP  MILK  VANILLE","0","0","42","50");
INSERT INTO t_produits VALUES("679","TORCHE  PLASTIQUE","0","0","375","500");
INSERT INTO t_produits VALUES("680","TUBE  NEON   120","0","0","260","800");
INSERT INTO t_produits VALUES("681","TUBE  NEON   60","0","0","272","800");
INSERT INTO t_produits VALUES("682","TUBORG  BOITE","0","0","583","800");
INSERT INTO t_produits VALUES("683","VASELINE  50G","0","0","191","300");
INSERT INTO t_produits VALUES("684","VERNIS","0","0","144","250");
INSERT INTO t_produits VALUES("685","VERNIS  BRILLANT","0","0","144","250");
INSERT INTO t_produits VALUES("686","VIN     BARON  DE  LA  VALLE","0","0","833","1000");
INSERT INTO t_produits VALUES("687","VIN     BORDELAIS","0","0","1134","1500");
INSERT INTO t_produits VALUES("688","VIN     BOURDILEY","0","0","2333","3000");
INSERT INTO t_produits VALUES("689","VIN     CUVEE  D\'AMAZAN  BLANC","0","0","1666","2000");
INSERT INTO t_produits VALUES("690","VIN     CUVEE  SAINT  JEAN","0","0","1083","1500");
INSERT INTO t_produits VALUES("691","VIN     DRY  RED  FAMILLE  CASTEL","0","0","2016","2500");
INSERT INTO t_produits VALUES("692","VIN     DUC   DE  FERMANDO","0","0","1050","1500");
INSERT INTO t_produits VALUES("693","VIN     DUC   DE  FERMANDO ROUGE","0","0","1050","1500");
INSERT INTO t_produits VALUES("694","VIN     DUC  DE  BARSAC  BLANC","0","0","1800","2000");
INSERT INTO t_produits VALUES("695","VIN     DUC  DE  BARSAC  ROUGE","0","0","1335","1500");
INSERT INTO t_produits VALUES("696","VIN     FLEUR  DE  MONTAGNE","0","0","1000","1200");
INSERT INTO t_produits VALUES("697","VIN     GANDIA","0","0","1416","1700");
INSERT INTO t_produits VALUES("698","VIN     PENASOL","0","0","1125","1500");
INSERT INTO t_produits VALUES("699","VIN     PERLADO","0","0","1041","1500");
INSERT INTO t_produits VALUES("700","VIN     VILLA  BLANCHE","0","0","2333","2500");
INSERT INTO t_produits VALUES("701","VIN    CAVE  ROYALE","0","0","281","350");
INSERT INTO t_produits VALUES("702","VIN    CAVIC","0","0","1095","1500");
INSERT INTO t_produits VALUES("703","VIN    DOMAINE  DU  FOSSE","0","0","1083","1500");
INSERT INTO t_produits VALUES("704","VIN    J  P    CHENET","0","0","2300","3000");
INSERT INTO t_produits VALUES("705","VIN    LOUIS  DE  JACQUE","0","0","1084","1500");
INSERT INTO t_produits VALUES("706","VIN    SAVEUR  DES  MONTAGNES  GM","0","0","891","1000");
INSERT INTO t_produits VALUES("707","VIN    TALACATA","0","0","958","1200");
INSERT INTO t_produits VALUES("708","VIN   BRISE  DE  FRANCE","0","0","1980","2500");
INSERT INTO t_produits VALUES("709","VIN   CAMILO","0","0","1166","1500");
INSERT INTO t_produits VALUES("710","VIN   CARRE  DELVINO","0","0","1041","1200");
INSERT INTO t_produits VALUES("711","VIN   CPTE DE CHAMBERIE","0","0","2000","2500");
INSERT INTO t_produits VALUES("712","VIN   ISABEL  DE FRANCE","0","0","1166","1500");
INSERT INTO t_produits VALUES("713","VIN   MAQUIS  DE  FLANDES","0","0","1166","1500");
INSERT INTO t_produits VALUES("714","VIN   MAQUIS  DE  FLANDES","0","0","1166","1500");
INSERT INTO t_produits VALUES("715","VIN   MEDUIM  SWEET FAMILLE CASTEL","0","0","2291","3000");
INSERT INTO t_produits VALUES("716","VIN   MUSCAT DELUNET  ROSE","0","0","3500","4000");
INSERT INTO t_produits VALUES("717","VIN   SERVIOLA","0","0","1083","1500");
INSERT INTO t_produits VALUES("718","VIN   TIO  DE  LA  BOTA","0","0","1166","1500");
INSERT INTO t_produits VALUES("719","VIN   VIGNERON","0","0","1250","1500");
INSERT INTO t_produits VALUES("720","VIN  BARON   DE  MADRID","0","0","792","1000");
INSERT INTO t_produits VALUES("721","VIN  CASA  CORNOER  SAUVIGNON  BLANC","0","0","2750","3500");
INSERT INTO t_produits VALUES("722","VIN  CHATEAU  DU BOIS","0","0","3000","3500");
INSERT INTO t_produits VALUES("723","VIN  CHATEAU  MONSSANT","0","0","3000","3500");
INSERT INTO t_produits VALUES("724","VIN  CHATEAU DE LA  GORCE","0","0","2333","3000");
INSERT INTO t_produits VALUES("725","VIN  CRUSARE   BLANC","0","0","1125","1300");
INSERT INTO t_produits VALUES("726","VIN  FINE  CALVADOS","0","0","3000","4000");
INSERT INTO t_produits VALUES("727","VIN  FLEUX  DAR","0","0","2500","3000");
INSERT INTO t_produits VALUES("728","VIN  FRANFROIDE","0","0","3334","4000");
INSERT INTO t_produits VALUES("729","VIN  LISTEL","0","0","3000","4000");
INSERT INTO t_produits VALUES("730","VIN  MUSCAT  DELUNET  BLANC","0","0","3500","4000");
INSERT INTO t_produits VALUES("731","VIN  NOBLE  CRU","0","0","2500","3000");
INSERT INTO t_produits VALUES("732","VIN  PRESSUE","0","0","2500","3000");
INSERT INTO t_produits VALUES("733","VIN  TOUR DE MOULIN","0","0","1667","2000");
INSERT INTO t_produits VALUES("734","VIN  VEGAS  BLANC","0","0","1125","1300");
INSERT INTO t_produits VALUES("735","VIN BARON DARSAC","0","0","1166","1500");
INSERT INTO t_produits VALUES("736","VIN CABERNET DANJOU","0","0","3000","3500");
INSERT INTO t_produits VALUES("737","VIN CUVEE DAMAZAN BLANC","0","0","1666","2000");
INSERT INTO t_produits VALUES("738","VIN CUVEE DAMAZAN ROUGE","0","0","1250","1500");
INSERT INTO t_produits VALUES("739","VIN DENT PINS BTIEL","0","0","2500","3000");
INSERT INTO t_produits VALUES("740","VIN DUC DE FERMANDO BLANC","0","0","1600","2000");
INSERT INTO t_produits VALUES("741","VIN VIEUX  VANRIER","0","0","2500","3000");
INSERT INTO t_produits VALUES("742","VINAIGRE    1L","0","0","175","450");
INSERT INTO t_produits VALUES("743","VINAIGRE    50 CL","0","0","145","250");
INSERT INTO t_produits VALUES("744","VINE  CAMPO","0","0","2666","3000");
INSERT INTO t_produits VALUES("745","VITATOP","0","0","40","50");
INSERT INTO t_produits VALUES("746","VOLKA","0","0","667","800");
INSERT INTO t_produits VALUES("747","WHISKY     GOLD  BOND","0","0","95","150");
INSERT INTO t_produits VALUES("748","WHISKY    8PM","0","0","3500","4500");
INSERT INTO t_produits VALUES("749","WHISKY    BAILLEY    GM","0","0","7920","9000");
INSERT INTO t_produits VALUES("750","WHISKY    BAILLEY    PM","0","0","2815","3500");
INSERT INTO t_produits VALUES("751","WHISKY    BLACK   LABEL","0","0","14300","15000");
INSERT INTO t_produits VALUES("752","WHISKY    CHIVAS","0","0","14000","15000");
INSERT INTO t_produits VALUES("753","WHISKY    FILGHTER","0","0","58","100");
INSERT INTO t_produits VALUES("754","WHISKY    J  B   GM","0","0","7250","8500");
INSERT INTO t_produits VALUES("755","WHISKY    J  B   PM","0","0","2450","3000");
INSERT INTO t_produits VALUES("756","WHISKY    JACK  DANIEL","0","0","7000","9000");
INSERT INTO t_produits VALUES("757","WHISKY    PASSEPORT","0","0","7500","9000");
INSERT INTO t_produits VALUES("758","WHISKY    RED  LABEL     PM","0","0","2400","3000");
INSERT INTO t_produits VALUES("759","WHISKY    RED  LABEL  75CL","0","0","7245","8000");
INSERT INTO t_produits VALUES("760","WHISKY    RHUM  SAINT  JAEMS  1L","0","0","8500","9500");
INSERT INTO t_produits VALUES("761","WHISKY    SIR  EDWARD","0","0","6500","7000");
INSERT INTO t_produits VALUES("762","WHISKY    SMINOFT    PM","0","0","2035","2500");
INSERT INTO t_produits VALUES("763","WHISKY   LABEL  5","0","0","8000","9000");
INSERT INTO t_produits VALUES("764","WHISKY  AMARULA","0","0","7000","8000");
INSERT INTO t_produits VALUES("765","WHISKY  BARONAYS","0","0","5667","6000");
INSERT INTO t_produits VALUES("766","WHISKY  DETECTIVE","0","0","1250","1500");
INSERT INTO t_produits VALUES("767","WHISKY  DIPOMATE","0","0","2666","4000");
INSERT INTO t_produits VALUES("768","WHISKY  GILBEYS  BLEND","0","0","3300","4000");
INSERT INTO t_produits VALUES("769","WHISKY  GILBEYS  GIN","0","0","3300","4000");
INSERT INTO t_produits VALUES("770","WHISKY  GILBEYS  VODKA","0","0","3300","4000");
INSERT INTO t_produits VALUES("771","WHISKY  GORDONS  GM","0","0","5000","7000");
INSERT INTO t_produits VALUES("772","WHISKY  GORDONS  PM","0","0","2000","2500");
INSERT INTO t_produits VALUES("773","WHISKY  GRANTS   75CL","0","0","6500","7500");
INSERT INTO t_produits VALUES("774","WHISKY  MUSCAT DE SAMOS","0","0","3500","4500");
INSERT INTO t_produits VALUES("775","WHISKY  MUSCAT DELUNET  ROSE","0","0","3500","4500");
INSERT INTO t_produits VALUES("776","WHISKY GOLD RADICO","0","0","7000","8000");
INSERT INTO t_produits VALUES("777","WHISKY GOLD RADICO","0","0","4000","4500");
INSERT INTO t_produits VALUES("778","WHISKY LION DOR","0","0","71","100");
INSERT INTO t_produits VALUES("779","WINDHOEK","0","0","642","750");
INSERT INTO t_produits VALUES("780","XXL    30CL","0","0","258","300");
INSERT INTO t_produits VALUES("781","YAOURT  DOLAIT  NATURE  GM","0","0","335","400");
INSERT INTO t_produits VALUES("782","YAOURT  ROYAL  CROWN  SACHET","0","0","215","250");



DROP TABLE IF EXISTS t_produits_factures;

CREATE TABLE `t_produits_factures` (
  `idt_produits_factures` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `quantite_achat` int(11) NOT NULL,
  `prix_total_produits` int(11) NOT NULL,
  `date_fabrication` date NOT NULL,
  `date_peremption` date NOT NULL,
  PRIMARY KEY (`idt_produits_factures`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_recapitulatif;

CREATE TABLE `t_recapitulatif` (
  `idt_recapitulatif` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `ration` int(11) NOT NULL,
  `dette_fournisseur` int(11) NOT NULL,
  `depenses_diverses` int(11) NOT NULL,
  `avaries` int(11) NOT NULL,
  `credit_client` int(11) NOT NULL,
  `fonds` int(11) NOT NULL,
  `capsules` int(11) NOT NULL,
  `recettes_percues` int(11) NOT NULL,
  `date_inventaire` datetime NOT NULL,
  PRIMARY KEY (`idt_recapitulatif`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

INSERT INTO t_recapitulatif VALUES("35","6","0","0","0","0","0","0","0","0","2014-07-16 22:21:06");



DROP TABLE IF EXISTS t_types_users;

CREATE TABLE `t_types_users` (
  `idt_types_users` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type_user` varchar(255) NOT NULL,
  PRIMARY KEY (`idt_types_users`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO t_types_users VALUES("1","Super Administrateur");
INSERT INTO t_types_users VALUES("2","Administrateur");
INSERT INTO t_types_users VALUES("3","Inspecteur");
INSERT INTO t_types_users VALUES("4","Inventoriste");
INSERT INTO t_types_users VALUES("5","Caissier");
INSERT INTO t_types_users VALUES("6","Visiteur");



DROP TABLE IF EXISTS t_users;

CREATE TABLE `t_users` (
  `idt_users` int(11) NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(255) NOT NULL,
  `prenom_user` varchar(255) NOT NULL,
  `adresse_user` varchar(255) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_type_user` int(11) NOT NULL,
  `datetime_last_connected` datetime NOT NULL,
  `nombre_connexion` int(11) NOT NULL,
  PRIMARY KEY (`idt_users`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO t_users VALUES("2","MOFFO","Cyrille","Villeurbanne","cyrille.moffo@gmail.com","cyrille","36d2756d696f6582673acca1a3f96a09","1","2014-07-16 10:39:02","31");
INSERT INTO t_users VALUES("3","FOFOU","Herve","Douala","herve.fofou@gmail.com","herve","eefde70a4a3c5afdde3f2deac5a4954a","2","2014-05-09 22:47:51","5");
INSERT INTO t_users VALUES("4","FOFOU","Gildas","Yaounde","gildas.fofou@gmail.com","gildas","b01ec15f3b619ab40b208eb3e05e700d","3","2014-02-23 01:06:43","1");
INSERT INTO t_users VALUES("5","DZOUA","Collins","Yaounde","collins.ndzoua@gmail.com","collins","7ce38bf6811a96afd3411188577b08ee","4","0000-00-00 00:00:00","0");
INSERT INTO t_users VALUES("6","FOFOU","Diane","Douala","diane.fofou@gmail.com","diane","91515711adb2a1f6c1f2ff6446741955","5","0000-00-00 00:00:00","0");
INSERT INTO t_users VALUES("7","MANTOH","Carole","Douala","carole.mantoh@gmail.com","carole","114d9e46d97258c6062dfa19ea0dbc9b","5","0000-00-00 00:00:00","0");
INSERT INTO t_users VALUES("8","BOVARY","Bovary","Douala","bovary@gmail.com","bovary","21b5309e087f79220b6ea0383f033485","2","2014-03-08 16:34:57","2");



