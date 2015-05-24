CREATE DATABASE IF NOT EXISTS quincaillerie.db_dev;

USE quincaillerie.db_dev;

DROP TABLE IF EXISTS t_achats;

CREATE TABLE `t_achats` (
  `idt_achats` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `id_facture` int(11) NOT NULL,
  `quantite_achat` int(11) NOT NULL,
  `date_fabrication` date NOT NULL,
  `date_peremption` date NOT NULL,
  PRIMARY KEY (`idt_achats`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_factures_achats;

CREATE TABLE `t_factures_achats` (
  `idt_factures_achats` int(11) NOT NULL AUTO_INCREMENT,
  `numero_facture` varchar(255) NOT NULL,
  `nombre_produit` int(11) NOT NULL,
  `id_fournisseur` int(11) NOT NULL,
  `date_facture` date NOT NULL,
  `date_insertion_facture` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  `id_inventaire` int(11) NOT NULL,
  PRIMARY KEY (`idt_factures_achats`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_factures_ventes;

CREATE TABLE `t_factures_ventes` (
  `idt_factures_ventes` int(11) NOT NULL AUTO_INCREMENT,
  `numero_facture` varchar(255) NOT NULL,
  `date_facture` datetime NOT NULL,
  `commentaire` text NOT NULL,
  `id_inventaire` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nom_client` varchar(255) NOT NULL,
  PRIMARY KEY (`idt_factures_ventes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_fournisseurs;

CREATE TABLE `t_fournisseurs` (
  `idt_fournisseurs` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fournisseur` varchar(255) NOT NULL,
  `adresse_fournisseur` varchar(255) NOT NULL,
  `telephone_fournisseur` varchar(255) NOT NULL,
  `date_insertion` datetime NOT NULL,
  PRIMARY KEY (`idt_fournisseurs`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_inventaires;

CREATE TABLE `t_inventaires` (
  `idt_inventaires` int(11) NOT NULL AUTO_INCREMENT,
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
  `commentaire` text NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `ecartspath` varchar(255) NOT NULL,
  PRIMARY KEY (`idt_inventaires`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO t_inventaires VALUES("1","2","0","0","0","0","0","0","0","0","2015-05-24 12:46:41","zero","","");



DROP TABLE IF EXISTS t_journal;

CREATE TABLE `t_journal` (
  `idt_journal` int(11) NOT NULL AUTO_INCREMENT,
  `date_journal` datetime NOT NULL,
  `commentaire` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_inventaire` int(11) NOT NULL,
  PRIMARY KEY (`idt_journal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_operations;

CREATE TABLE `t_operations` (
  `idt_operations` int(11) NOT NULL AUTO_INCREMENT,
  `numero_operation` varchar(255) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite_vendue` int(11) NOT NULL,
  `id_journal` int(11) NOT NULL,
  PRIMARY KEY (`idt_operations`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_produits;

CREATE TABLE `t_produits` (
  `idt_produits` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(255) NOT NULL,
  `stock_initial` int(11) NOT NULL,
  `stock_physique` int(11) NOT NULL,
  `prix_achat` float NOT NULL,
  `prix_vente` float NOT NULL,
  PRIMARY KEY (`idt_produits`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;

INSERT INTO t_produits VALUES("1","SEAU SAFARI 1OL","0","0","700","1000");
INSERT INTO t_produits VALUES("2","SEAU SAFARI 6L","0","0","550","700");
INSERT INTO t_produits VALUES("3","SEAU SAFARI 20L","0","0","1250","1800");
INSERT INTO t_produits VALUES("4","SEAU KRIBI 24L","0","0","1900","2300");
INSERT INTO t_produits VALUES("5","SEAU BAMBOO 16L","0","0","1200","1500");
INSERT INTO t_produits VALUES("6","SEAU MACON","0","0","650","1000");
INSERT INTO t_produits VALUES("7","SEAU INDUSTRUE","0","0","1500","2000");
INSERT INTO t_produits VALUES("8","SEAU MARIMA 33L","0","0","1400","2000");
INSERT INTO t_produits VALUES("9","SEAU MARIMA 20L","0","0","900","1500");
INSERT INTO t_produits VALUES("10","RONDELLE PLAQUE","0","0","600","1000");
INSERT INTO t_produits VALUES("11","DECCA METRE 30M","0","0","1000","1500");
INSERT INTO t_produits VALUES("12","TUBE 6O","0","0","240","500");
INSERT INTO t_produits VALUES("13","DECCA METRE 50M","0","0","1500","2000");
INSERT INTO t_produits VALUES("14","SERRURE MEUBLE RADIS","0","0","125","300");
INSERT INTO t_produits VALUES("15","VIS DE RAPELLE","0","0","40","100");
INSERT INTO t_produits VALUES("16","PAUMELLE 160","0","0","417","700");
INSERT INTO t_produits VALUES("17","SCIE A BOIS PM","0","0","900","1300");
INSERT INTO t_produits VALUES("18","SCIE A BOIS GM","0","0","1100","1500");
INSERT INTO t_produits VALUES("19","AMPOULE TEXLAM","0","0","110","200");
INSERT INTO t_produits VALUES("20","SEAU BOSSURE","0","0","2000","2500");
INSERT INTO t_produits VALUES("21","SEAU BONSETTE","0","0","4000","4500");
INSERT INTO t_produits VALUES("22","PELLE RONDE","0","0","1300","1700");
INSERT INTO t_produits VALUES("23","PARPIER VERT 80","0","0","300","500");
INSERT INTO t_produits VALUES("24","PARPIER VERT 100","0","0","300","500");
INSERT INTO t_produits VALUES("25","DIJONTEUR","0","0","5000","7000");
INSERT INTO t_produits VALUES("26","PORTE CADENAS","0","0","417","800");
INSERT INTO t_produits VALUES("27","PORTE CADENAS 6’’","0","0","140","300");
INSERT INTO t_produits VALUES("28","TUYAU D’AROSAGE DE 20","0","0","7000","9000");
INSERT INTO t_produits VALUES("29","SERPIERE","0","0","600","800");
INSERT INTO t_produits VALUES("30","PROGRAMATEUR","0","0","1500","2000");
INSERT INTO t_produits VALUES("31","CHEVILLE DE 12","0","0","1100","1500");
INSERT INTO t_produits VALUES("32","VIS 4 /25","0","0","300","500");
INSERT INTO t_produits VALUES("33","VIS 4/30","0","0","400","700");
INSERT INTO t_produits VALUES("34","TOURNEVIS TESTEUR","0","0","110","250");
INSERT INTO t_produits VALUES("35","AMPOULE JEU DE LUMIERE","0","0","3000","4000");
INSERT INTO t_produits VALUES("36","VERNIS NATION","0","0","2335","3000");
INSERT INTO t_produits VALUES("37","TOP BOND GM","0","0","1400","2000");
INSERT INTO t_produits VALUES("38","TOP BOND PM","0","0","800","1200");
INSERT INTO t_produits VALUES("39","CHEVILLE DE 10","0","0","650","1000");
INSERT INTO t_produits VALUES("40","DOUILLE LAMP VOLDE","0","0","200","500");
INSERT INTO t_produits VALUES("41","ADAPTATEUR AVEC INTRERUPTEUR","0","0","250","500");
INSERT INTO t_produits VALUES("42","CHAUSSURE SECURITE","0","0","8000","10000");
INSERT INTO t_produits VALUES("43","LAME DE SCIE FAUX","0","0","90","300");
INSERT INTO t_produits VALUES("44","ANTI ROUILLE GM","0","0","1900","2500");
INSERT INTO t_produits VALUES("45","PARPIER ABRASIF","0","0","170","250");
INSERT INTO t_produits VALUES("46","MULTIMETRE","0","0","4000","5000");
INSERT INTO t_produits VALUES("47","TUBE NEON ECO BLEU 60","0","0","750","1500");
INSERT INTO t_produits VALUES("48","TUBE NEON BLEU 120","0","0","900","1500");
INSERT INTO t_produits VALUES("49","GRILLAGE MOUSTIQUE","0","0","4500","5000");
INSERT INTO t_produits VALUES("50","SEAU TEXAS 20L","0","0","1050","1500");
INSERT INTO t_produits VALUES("51","SEAU JAMAICA 16L","0","0","900","1500");
INSERT INTO t_produits VALUES("52","SEAU JAMAICA 15L","0","0","800","1300");
INSERT INTO t_produits VALUES("53","SEAU PIENTURE LUX SMALTO 20L","0","0","14000","15500");
INSERT INTO t_produits VALUES("54","DEBOU CHEUR","0","0","1700","2200");
INSERT INTO t_produits VALUES("55","CISEAU PM","0","0","45","150");
INSERT INTO t_produits VALUES("56","VERNIS COPAL","0","0","4000","4500");
INSERT INTO t_produits VALUES("57","CASTILLE","0","0","2700","3000");
INSERT INTO t_produits VALUES("58","TINTURE SEIGNERIE","0","0","2700","3000");
INSERT INTO t_produits VALUES("59","CASQUE","0","0","2000","2300");
INSERT INTO t_produits VALUES("60","ARDOISIE GM","0","0","1500","2000");
INSERT INTO t_produits VALUES("61","ARDOISIE PM","0","0","1000","1500");
INSERT INTO t_produits VALUES("62","AMPOULE PHILIPS","0","0","250","400");
INSERT INTO t_produits VALUES("63","ACIDE CHLORODRIQUE","0","0","1000","1500");
INSERT INTO t_produits VALUES("64","TUYAU PVC 100","0","0","2600","3000");
INSERT INTO t_produits VALUES("65","TUYAU 32","0","0","900","1200");
INSERT INTO t_produits VALUES("66","TUYAU 40","0","0","1150","1500");
INSERT INTO t_produits VALUES("67","TUYAU 125","0","0","4600","5000");
INSERT INTO t_produits VALUES("68","TUYAU 63","0","0","1400","1800");
INSERT INTO t_produits VALUES("69","TUYAU PRESSION 21/25","0","0","950","1500");
INSERT INTO t_produits VALUES("70","TUYAU PRESSION 32","0","0","1600","2000");
INSERT INTO t_produits VALUES("71","BALANCE","0","0","5500","6500");
INSERT INTO t_produits VALUES("72","PINCE A SOUDER GM","0","0","3300","4000");
INSERT INTO t_produits VALUES("73","PINCE A SOUDER PM","0","0","1100","1600");
INSERT INTO t_produits VALUES("74","TORCHE DE TETE","0","0","400","700");
INSERT INTO t_produits VALUES("75","FICHE RADIO","0","0","300","500");
INSERT INTO t_produits VALUES("76","VIS FICHER","0","0","250","500");
INSERT INTO t_produits VALUES("77","BOUCHON PVC 100","0","0","345","800");
INSERT INTO t_produits VALUES("78","COUDE PVC 63 1/4","0","0","231","700");
INSERT INTO t_produits VALUES("79","MARTEAU EN FER","0","0","1500","2000");
INSERT INTO t_produits VALUES("80","CHEVILLE DE 8","0","0","800","1000");
INSERT INTO t_produits VALUES("81","SEAU NOIR MACON","0","0","700","1000");
INSERT INTO t_produits VALUES("82","RALLONGE 4T INGELEC","0","0","1200","2000");
INSERT INTO t_produits VALUES("83","COLLE DURABOND 1KG","0","0","2000","2200");
INSERT INTO t_produits VALUES("84","LUNETTE SOUDEUR","0","0","500","1000");
INSERT INTO t_produits VALUES("85","CADENAS SONNERIE","0","0","3000","3500");
INSERT INTO t_produits VALUES("86","BARRET DE COUPURE","0","0","1500","2000");
INSERT INTO t_produits VALUES("87","PRISE AVEC TER","0","0","250","500");
INSERT INTO t_produits VALUES("88","INTERRUPTEUR EN CASTRE","0","0","250","500");
INSERT INTO t_produits VALUES("89","D P N","0","0","420","800");
INSERT INTO t_produits VALUES("90","CHAUD","0","0","4300","5000");
INSERT INTO t_produits VALUES("91","TOURNEVIS UNIVERSEL","0","0","1500","2500");
INSERT INTO t_produits VALUES("92","POINCON","0","0","1000","1500");
INSERT INTO t_produits VALUES("93","BURIN","0","0","1000","1500");
INSERT INTO t_produits VALUES("94","BALAI COCO","0","0","800","1000");
INSERT INTO t_produits VALUES("95","BALAI PLATIQUE","0","0","750","1000");
INSERT INTO t_produits VALUES("96","POINTE 70 80 90 100","0","0","2900","3500");
INSERT INTO t_produits VALUES("97","CLE PLAT 8","0","0","250","500");
INSERT INTO t_produits VALUES("98","CLE PLAT 10 12 13","0","0","300","700");
INSERT INTO t_produits VALUES("99","CLE PLAT 17","0","0","500","800");
INSERT INTO t_produits VALUES("100","CLE PLAT 19","0","0","600","1000");
INSERT INTO t_produits VALUES("101","CLE PLAT 22","0","0","600","1000");
INSERT INTO t_produits VALUES("102","CLE PLAT 24","0","0","800","1200");
INSERT INTO t_produits VALUES("103","CLE PLAT 14","0","0","300","600");
INSERT INTO t_produits VALUES("104","CLE A PIPE 8","0","0","300","500");
INSERT INTO t_produits VALUES("105","CLE A PIPE 12","0","0","450","900");
INSERT INTO t_produits VALUES("106","CLE A PIPE 14","0","0","650","1000");
INSERT INTO t_produits VALUES("107","CLE A PIPE 17","0","0","800","1300");
INSERT INTO t_produits VALUES("108","CLE A PIPE 19","0","0","900","1500");
INSERT INTO t_produits VALUES("109","CLE A LAINE GM","0","0","700","1000");
INSERT INTO t_produits VALUES("110","CLE A LAINE PM","0","0","500","800");
INSERT INTO t_produits VALUES("111","PINCE ORIGNAL 6","0","0","700","1000");
INSERT INTO t_produits VALUES("112","COUTEAU ELECTRICIEN","0","0","60","200");
INSERT INTO t_produits VALUES("113","SILICONE","0","0","1250","1500");
INSERT INTO t_produits VALUES("114","CACHE NEZ ORIGINAL","0","0","400","600");
INSERT INTO t_produits VALUES("115","CACHE NEZ","0","0","20","100");
INSERT INTO t_produits VALUES("116","COLLE 99 PM","0","0","450","700");
INSERT INTO t_produits VALUES("117","DETENDEUR BLEU","0","0","600","1000");
INSERT INTO t_produits VALUES("118","RATEAU PM","0","0","650","1000");
INSERT INTO t_produits VALUES("119","COMPTEUR PM","0","0","2500","3000");
INSERT INTO t_produits VALUES("120","CADENAS VACHETE 55MM","0","0","650","900");
INSERT INTO t_produits VALUES("121","CADENAS VACHETTE 65MM","0","0","750","1000");
INSERT INTO t_produits VALUES("122","CADENAS COTE 20MM","0","0","100","200");
INSERT INTO t_produits VALUES("123","CADENAS NOIR 20 MM","0","0","125","250");
INSERT INTO t_produits VALUES("124","CADENAS BLESS 60MM","0","0","600","1000");
INSERT INTO t_produits VALUES("125","CADENAS BLESS 50MM","0","0","500","800");
INSERT INTO t_produits VALUES("126","CADENAS BLESS 80MM","0","0","800","1200");
INSERT INTO t_produits VALUES("127","MAMCHE PELLE","0","0","150","300");
INSERT INTO t_produits VALUES("128","MAMCHE DE BALAI","0","0","100","200");
INSERT INTO t_produits VALUES("129","TORCHE RECHARGEABLE","0","0","800","1200");
INSERT INTO t_produits VALUES("130","DISQUE A COUPER ORIGINAL","0","0","1000","1300");
INSERT INTO t_produits VALUES("131","ANTIROUILLE SMLTO 1KG","0","0","2300","2800");
INSERT INTO t_produits VALUES("132","ETAIN 500G","0","0","5000","6000");
INSERT INTO t_produits VALUES("133","ETAIN 250G","0","0","3000","4000");
INSERT INTO t_produits VALUES("134","ETAIN 100G","0","0","1500","2000");
INSERT INTO t_produits VALUES("135","POWER MAIL","0","0","900","1300");
INSERT INTO t_produits VALUES("136","BANDE ADHESIF","0","0","450","800");
INSERT INTO t_produits VALUES("137","REGLETE MAZDA 120","0","0","1900","2500");
INSERT INTO t_produits VALUES("138","DISQUE A PONCER","0","0","280","500");
INSERT INTO t_produits VALUES("139","MACHETTE 202","0","0","1200","1500");
INSERT INTO t_produits VALUES("140","POINCON","0","0","700","1200");
INSERT INTO t_produits VALUES("141","GRIFFE 6 8","0","0","700","1000");
INSERT INTO t_produits VALUES("142","GRIFFE 8 10","0","0","900","1200");
INSERT INTO t_produits VALUES("143","CABLE TV","0","0","4700","5000");
INSERT INTO t_produits VALUES("144","AMPOULE E14","0","0","140","300");
INSERT INTO t_produits VALUES("145","MARTEAU ARRACHE CLOU","0","0","1200","1500");
INSERT INTO t_produits VALUES("146","DOUILLE DELTA","0","0","100","200");
INSERT INTO t_produits VALUES("147","ESSUIE PIED WELCOME","0","0","1000","1500");
INSERT INTO t_produits VALUES("148","BROSSE A LINGE","0","0","167","250");
INSERT INTO t_produits VALUES("149","SCOTCH ELECTRICIEN","0","0","100","200");
INSERT INTO t_produits VALUES("150","VIS ACCROCHE N° 3","0","0","350","500");
INSERT INTO t_produits VALUES("151","VIS ACCROCHE N°4","0","0","450","700");
INSERT INTO t_produits VALUES("152","VIS ACCROCHE N°6","0","0","650","1000");
INSERT INTO t_produits VALUES("153","COMPTEUR ELECTIRQUE GM","0","0","4000","5000");
INSERT INTO t_produits VALUES("154","SCRUPPER BLEU 6","0","0","750","1200");
INSERT INTO t_produits VALUES("155","SCRUPPER BLEU 4","0","0","600","1000");
INSERT INTO t_produits VALUES("156","SCRUPPER TEETH 160","0","0","650","1000");
INSERT INTO t_produits VALUES("157","SCRUPPER TEETH","0","0","600","1000");
INSERT INTO t_produits VALUES("158","CAMPING GAZ","0","0","550","900");
INSERT INTO t_produits VALUES("159","BANDE DE SECURITE","0","0","1000","1500");
INSERT INTO t_produits VALUES("160","BRASURE","0","0","500","700");
INSERT INTO t_produits VALUES("161","PEINTURE NAIONAL A HUILE 4KG","0","0","8000","9000");
INSERT INTO t_produits VALUES("162","DILUANT 1L","0","0","800","1000");
INSERT INTO t_produits VALUES("163","NATIONAL A EAU 2OL","0","0","16000","17000");
INSERT INTO t_produits VALUES("164","NAIONAL A HUILE 20L","0","0","37500","38500");
INSERT INTO t_produits VALUES("165","TRUELLE 22","0","0","650","1000");
INSERT INTO t_produits VALUES("166","TRUELLE 18","0","0","550","800");
INSERT INTO t_produits VALUES("167","FICHE MULTIPLE 3T","0","0","75","200");



DROP TABLE IF EXISTS t_produits_achats;

CREATE TABLE `t_produits_achats` (
  `idt_produits_achats` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `quantite_achat` int(11) NOT NULL,
  `date_fabrication` date NOT NULL,
  `date_peremption` date NOT NULL,
  PRIMARY KEY (`idt_produits_achats`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_produits_operations;

CREATE TABLE `t_produits_operations` (
  `idt_produits_operations` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `quantite_vendue` int(11) NOT NULL,
  `numero_operation` varchar(255) NOT NULL,
  PRIMARY KEY (`idt_produits_operations`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_produits_ventes;

CREATE TABLE `t_produits_ventes` (
  `idt_produits_ventes` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `quantite_vendue` int(11) NOT NULL,
  PRIMARY KEY (`idt_produits_ventes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS t_types_users;

CREATE TABLE `t_types_users` (
  `idt_types_users` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type_user` varchar(255) NOT NULL,
  PRIMARY KEY (`idt_types_users`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO t_types_users VALUES("1","Super Administrateur");
INSERT INTO t_types_users VALUES("2","Administrateur");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO t_users VALUES("1","MOFFO","Cyrille","Villeurbanne","cyrille.moffo@gmail.com","cyrille","b5ff2b85e2cdacf74f299159ae750a9f","1","2015-05-24 12:17:52","2");
INSERT INTO t_users VALUES("2","FOFOU","Herve","Douala","hervejulio2004@gmail.com","herve","b5ff2b85e2cdacf74f299159ae750a9f","2","2015-05-18 09:40:36","1");



DROP TABLE IF EXISTS t_ventes;

CREATE TABLE `t_ventes` (
  `idt_ventes` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) NOT NULL,
  `id_facture_vente` int(11) NOT NULL,
  `quantite_vendue` int(11) NOT NULL,
  PRIMARY KEY (`idt_ventes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




