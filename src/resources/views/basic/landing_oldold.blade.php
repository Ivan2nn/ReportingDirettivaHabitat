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
<header id="home" class="header">
	
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
				<li><a href="#">Home</a></li>
				<li><a href="{{ route('context') }}">Contesto di Riferimento</a></li>
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Specie<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<a href="{{ route('species-basic-search') }}">Ricerca base</a>
						</li>
						<li>
							<a href="{{ route('species-advanced-search') }}">Ricerca avanzata</a>
						</li>
                        <li>
                            <a href="{{ route('api.cellcodes.index') }}">Ricerca cartografica</a>
                        </li>
					</ul>
				</li>
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Habitat<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('species-basic-search') }}">Ricerca base</a>
                        </li>
                        <li>
                            <a href="{{ route('species-advanced-search') }}">Ricerca avanzata</a>
                        </li>
                        <li>
                            <a href="{{ route('api.cellcodes.index') }}">Ricerca cartografica</a>
                        </li>
                    </ul>
                </li>
				<li><a href="{{ route('downloads') }}">Download</a></li>
				<li><a href="#pricingtable">Link</a></li>
			</ul>
			</nav>
		</div>
	</div>
	<!-- / END TOP BAR -->
	
	<!-- BIG HEADING WITH CALL TO ACTION BUTTONS AND SHORT MESSAGES -->
	<div class="container">
		
		<!-- HEADING -->
		<h1 class="intro">REPORTING DIRETTIVA HABITAT</h1>
		
		
	</div> <!-- / END BIG HEADING WITH CALL TO ACTION BUTTONS AND SHORT MESSAGES  -->
	
</header> <!-- / END HOME SECTION  -->

<!-- =========================
   FOCUS SECTION      
============================== -->

<section class="focus" id="focus">
<div class="container">
	
	<!-- SECTION HEADER -->
	<div class="section-header">
		
		
	</div>
	<!-- / END SECTION HEADER -->
	
	<!-- 4 FOCUS BOXES -->
	<div class="row">
		
		<!-- FIRST FOCUS BOXES -->
		<div class="col-lg-3 col-sm-3 focus-box red wow fadeInLeft animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
			<div class="service-icon">
				<i class="pixeden habitat-icon"></i> <!-- FOCUS ICON-->
			</div>
			<h5 class="red-border-bottom">Habitat</h5> <!-- FOCUS HEADING -->
		</div>
		<!-- / END FIRST FOCUS BOX. Other boxes has same format -->
		
		<div class="col-lg-3 col-sm-3 focus-box green wow fadeInLeft animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
			<div class="service-icon">
				<span class="pixeden species-icon"></span>
			</div>
			<h5 class="green-border-bottom">Specie</h5>
		</div>
		
		<div class="col-lg-3 col-sm-3 focus-box blue wow fadeInRight animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
			<div class="service-icon">
				<i class="pixeden download-icon"></i>
			</div>
			<h5 class="blue-border-bottom">Download</h5>
		</div>
		
		<div class="col-lg-3 col-sm-3 focus-box yellow wow fadeInRight animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
			<div class="service-icon">
				<i class="pixeden link-icon"></i>
			</div>
			<h5 class="yellow-border-bottom">Link</h5>
		</div>
	</div>
	<!-- / END 4 FOCUS BOXES -->
	
	<!-- OTHER FOCUSES -->
</div> <!-- / END CONTAINER -->
</section>  <!-- / END FOCUS SECTION -->



<!-- =========================
   ABOUT US SECTION   
============================== -->

<section class="about-us" id="aboutus">
<div class="container">
	
	<!-- / END SECTION HEADER -->
	
	<!-- 3 COLUMNS OF ABOUT US-->
	<div class="row">
		
		<!-- COLUMN 1 - BIG MESSAGE ABOUT THE COMPANY-->
		<div class="col-lg-6 col-md-6 column">
			<div class="big-intro wow fadeInLeft animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
				 III Rapporto Direttiva Habitat
			</div>
		</div>
		
		<!-- COLUMN 2 - BRIEF ABOUT THE COMPANY-->
		<div class="col-lg-6 col-md-6 column">
			<p class="wow fadeInUp animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
				 In questo sito sono disponibili dati raccolti ed elaborati dall'Italia per il 3° Rapporto Direttiva Habitat: il Rapporto raccoglie dati aggiornati su distribuzione, stato di conservazione, pressioni, minacce ed i trend relativi a tutte le specie animali e vegetali e agli habitat di interesse comunitario presenti in Italia. Una sintesi dei risultati è contenuta  nel volume " Specie e habitat di interesse comunitario in Italia: distribuzione, stato di conservazione e trend" (ISPRA Serie Rapporti 194/2014).
			</p>
		</div>
	</div> <!-- / END 2 COLUMNS OF ABOUT US-->

	<!-- CLIENTS -->
	<div class="our-clients">
		<h5><span class="section-footer-title">OUR HAPPY CLIENTS</span></h5>
	</div>
	<!-- CLIENT LIST -->
	<div class="client-list">
		<ul class="wow fadeInRight animated" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">
			<li><a href="#"><img src="images/clients/1.png" alt="Client 1"></a></li>
			<li><a href="#"><img src="images/clients/2.png" alt="Client 2"></a></li>
			<li><a href="#"><img src="images/clients/3.png" alt="Client 3"></a></li>
			<li><a href="#"><img src="images/clients/1.png" alt="Client 1"></a></li>
			<li><a href="#"><img src="images/clients/4.png" alt="Client 4"></a></li>
			<li><a href="#"><img src="images/clients/5.png" alt="Client 5"></a></li>
			<li><a href="#"><img src="images/clients/6.png" alt="Client 6"></a></li>
		</ul>
	</div> <!-- / END CLIENT LIST -->
</div> <!-- / END CONTAINER -->

</section> <!-- END ABOUT US SECTION -->

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