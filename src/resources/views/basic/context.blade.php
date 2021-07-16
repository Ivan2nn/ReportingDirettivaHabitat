<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="" />
<meta name="keywords" content=""/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ISPRA</title>

<!-- =========================
 FAV AND TOUCH ICONS  
============================== -->
<link rel="shortcut icon" href="images/icons/favicon.ico">
<link rel="apple-touch-icon" href="images/icons/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/icons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/icons/apple-touch-icon-114x114.png">

<!-- =========================
     STYLESHEETS      
============================== -->
<link rel="stylesheet" href="{!! asset('output/main.css') !!}">

<!-- WEBFONT -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,400italic|Montserrat:700,400|Homemade+Apple' rel='stylesheet' type='text/css'>

<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->

<!-- JQUERY -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>


<body>
<!-- =========================
   PRE LOADER       
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>
<!-- =========================
   HOME SECTION       
============================== -->
<header id="home" class="header navbar-no-background">
	
	<!-- TOP BAR -->
	<div id="main-nav" class="navbar navbar-inverse bs-docs-nav" role="banner">
		<div class="container">
			<div class="navbar-header responsive-logo">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<div class="navbar-brand">
				<img src="images/logo.png" alt="Zerif">
				</div>
			</div>
			<nav class="navbar-collapse collapse" role="navigation" id="bs-navbar-collapse">
			<ul class="nav navbar-nav navbar-right responsive-nav main-nav-list">
				<li><a href="{{ route('home') }}">Home</a></li>
				<li><a href="#">Contesto di Riferimento</a></li>
				<li><a href="#works">Specie</a></li>
				<li><a href="#aboutus">Habitat</a></li>
				<li><a href="{{ route('downloads') }}">Download</a></li>
				<li><a href="#pricingtable">Link</a></li>
			</ul>
			</nav>
		</div>
	</div>
	<!-- / END TOP BAR -->
	
	
	
</header> <!-- / END HOME SECTION  -->

<!-- =========================
   FOCUS SECTION      
============================== -->

<section class="focus" id="focus">
<div class="container">
	
	<!-- 4 FOCUS BOXES -->
	<div class="row">
		
		<!-- FIRST FOCUS BOXES -->
		<div class="col-lg-9 col-sm-12">
			<article class="context-style">
			<h2>Contesto di riferimento</h2>
			<p>La <a href="http://bd.eionet.europa.eu/activities/Reporting/Article_17" target="_blank">Direttiva Habitat (92/43/CEE)</a>, insieme alla <a href="http://bd.eionet.europa.eu/activities/Reporting/Article_12" target="_blank">Direttiva Uccelli (2009/147/CE)</a>, rappresenta il principale pilastro della politica comunitaria per la conservazione della natura e comporta l’obbligo per gli Stati Membri di redigere, ogni 6 anni, un Rapporto nazionale sullo stato di conservazione delle specie e degli habitat di interesse comunitario (allegati I, II, IV e V della Direttiva) e sulle misure di conservazione intraprese, chiamato anche ‘Rapporto ex Art. 17’.
			</p>
			<p>
			Con il recepimento della Direttiva da parte dell’Italia tramite il <a href="http://www.minambiente.it/sites/default/files/archivio/allegati/rete_natura_2000/Regolamento_D.P.R._8_settembre_1997_n._357.PDF" target="_blank">Regolamento D.P.R. 8 settembre 1997 n.357</a>, il Ministero dell’Ambiente e della Tutela del Territorio e del Mare ha l’obbligo di redigere il <a href="http://cdr.eionet.europa.eu/it/eu/art17/envupyjhw" target="_blank">Rapporto nazionale</a> periodico a partire dai risultati del monitoraggio che le Regioni e le Province Autonome sono tenute a trasmettere secondo quanto previsto dall’articolo 13, comma 2, dello stesso Decreto.</p>

			<p>ISPRA è stato incaricato dal Ministero dell’Ambiente di coordinare la raccolta e l’analisi dei dati forniti dalle Amministrazioni locali.</p>

			<p>Le Regioni e le Province Autonome, nel corso del 2012, hanno elaborato 1.940 schede di valutazione per la fauna, 358 schede per la flora, 1.126 per gli habitat e 2.926 mappe di presenza di specie e habitat a livello regionale. I dati regionali, sia tabellari sia cartografici, sono stati quindi aggregati a livello biogeografico e nazionale, come richiesto dalla Direttiva, e sottoposti alle Società scientifiche coinvolte nel lavoro che hanno provveduto ad integrare le informazioni alla luce delle più aggiornate conoscenze disponibili in ambito scientifico, e a revisionare e validare tutti i dati raccolti.</p>

			<p>Il Ministero dell’Ambiente, di concerto con le Regioni e le Province autonome, ha condotto un’attenta verifica della congruenza tra i dati raccolti per il 3° Rapporto e le informazioni di distribuzione relative alla banca dati Natura 2000.</p>

			<p>Sono state complessivamente generate 572 schede di valutazione dello stato di conservazione e 634 mappe di distribuzione e range per le specie; per gli habitat sono state invece prodotte 262 schede e 262 mappe di distribuzione e range.</p>

			<p>
				<strong>Informazioni aggiuntive:</strong>
			</p>
				
			<p>
				Per facilitare l’aggregazione e il confronto fra i dati degli Stati Membri lo stato di conservazione è stato valutato con una metodica standardizzata. Lo stato di conservazione viene definito come:
				<ul>
				    <li>“favorevole”: habitat o specie in grado di prosperare senza alcun cambiamento della gestione e delle strategie attualmente in atto;</li>
				    <li>“sfavorevole-inadeguato”: habitat o specie che richiedono un cambiamento delle politiche di gestione, ma non a rischio di estinzione;</li>
				    <li>“sfavorevole-cattivo”: habitat o specie in serio pericolo di estinzione (almeno a livello locale);</li>
				    <li>sconosciuto”: quando le informazioni disponibili siano particolarmente carenti o inadeguate per permettere di esprimere un giudizio.</li>
				</ul>
			</p>

			<p>
				I parametri che concorrono a determinare lo stato complessivo sono:
				<ul>
				    <li>per le specie: range, popolazione, habitat per la specie e prospettive future.</li>
				    <li>per gli habitat: range, area coperta, struttura e funzioni specifiche e prospettive future.</li>
				</ul>

			</p>
			<p>
				<strong>
					NB: Tutte le schede di valutazione sono riferite alle singole regioni biogeografiche di presenza e non si limitano quindi ai territori della rete Natura 2000. Le mappe hanno invece scala nazionale.
				</strong>
			</p>
			</article>
		</div>
		
	<!-- OTHER FOCUSES -->
</div> <!-- / END CONTAINER -->
</section>  <!-- / END FOCUS SECTION -->




<!-- =========================
   FOOTER             
============================== -->

<footer>
<div class="container">
	
	<!-- COMPANY ADDRESS-->
	<div class="col-md-5 company-details">
		<div class="icon-top red-text">
		    <i class="icon-fontawesome-webfont-302"></i>
		</div>
		PO Box 16122 Collins Street West, Victoria 8007 Australia
	</div>
	
	<!-- COMPANY EMAIL-->
	<div class="col-md-2 company-details">
		<div class="icon-top green-text">
		<i class="icon-fontawesome-webfont-329"></i>
		</div>
		 contact@designlab.co
	</div>
	
	<!-- COMPANY PHONE NUMBER -->
	<div class="col-md-2 company-details">
		<div class="icon-top blue-text">
		<i class="icon-fontawesome-webfont-101"></i>
		</div>
		+613 0000 0000
	</div>
	
	<!-- SOCIAL ICON AND COPYRIGHT -->
	<div class="col-lg-3 col-sm-3 copyright">
		<ul class="social">
			<li><a href=""><i class="icon-facebook"></i></a></li>
			<li><a href=""><i class="icon-twitter-alt"></i></a></li>
			<li><a href=""><i class="icon-linkedin"></i></a></li>
			<li><a href=""><i class="icon-behance"></i></a></li>
			<li><a href=""><i class="icon-dribbble"></i></a></li>
		</ul>
		 ©2013 Zerif LLC
	</div>
</div> <!-- / END CONTAINER -->
</footer> <!-- / END FOOOTER  -->

<!-- SCRIPTS -->
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/vendor/wow.min.js"></script>
<script src="js/vendor/jquery.nav.js"></script>
<script src="js/vendor/jquery.knob.js"></script>
<script src="js/vendor/owl.carousel.min.js"></script>
<script src="js/vendor/smoothscroll.js"></script>
<script src="js/vendor/jquery.vegas.min.js"></script>
<script src="js/vendor/zerif.js"></script>

</body>
</html>