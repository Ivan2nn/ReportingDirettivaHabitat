<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Project ECO</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="{!! asset('css/vendor/bootstrap.css') !!}" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="{!! asset('css/vendor/font-awesome-4.6.3/css/font-awesome.css') !!}"" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="{!! asset('css/vendor/zontal-temp/style.css') !!}" rel="stylesheet" />
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <header>
        
    </header>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                

            </div>

            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">

                        <li class="dropdown">
                            
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media">
                                    <a class="media-left" href="#">
                                        <img src="assets/img/64-64.jpg" alt="" class="img-rounded" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Jhon Deo Alex </h4>
                                        <h5>Developer & Designer</h5>

                                    </div>
                                </div>
                                <hr />
                                <h5><strong>Personal Bio : </strong></h5>
                                Anim pariatur cliche reprehen derit.
                                <hr />
                                <a href="#" class="btn btn-info btn-sm">Full Profile</a>&nbsp; <a href="login.html" class="btn btn-danger btn-sm">Logout</a>

                            </div>
                        </li>


                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="{{ route('species-basic-search') }}">Ricerca per Specie</a></li>
                            <li><a href="{{ route('api.cellcodes.index') }}">Ricerca Cartografica</a></li>
                            <li><a href="{{ url('taxonomy-table') }}">Ricerca Specie Tassonomica</a></li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">3o Rapporto Direttiva Habitat</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        In questo sito sono disponibili i dati raccolti ed elaborati dall’Italia per il 3° Rapporto Direttiva Habitat e trasmessi alla Commissione Europea nel Dicembre 2013: il Rapporto raccoglie dati aggiornati su distribuzione, stato di conservazione, pressioni, minacce e i trend relativi a tutte le specie animali e vegetali e agli habitat di interesse comunitario presenti in Italia.
Una sintesi dei risultati è contenuta nel volume “Specie e habitat di interesse comunitario in Italia: distribuzione, stato di conservazione e trend” (ISPRA Serie Rapporti 194/2014).
Nella sezione ‘Download dati’ sono disponibili i dati di origine e la cartografia in diversi formati, alcune mappe di sintesi e le tabelle di riepilogo dove sono sintetizzati gli stati di conservazione (sia quello complessivo che dei parametri richiesti) e i relativi trend per ogni specie e habitat oggetto di rendicontazione.
Nella sezione ‘Demo cartografica’ sono state caricate solo tre distribuzioni a scopo puramente illustrativo del sistema, ancora in fase di sviluppo.
                  
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Contesto di Riferimento</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        la Direttiva Habitat (92/43/CEE), insieme alla Direttiva Uccelli (2009/147/CE), rappresenta il principale pilastro della politica comunitaria per la conservazione della natura e comporta l’obbligo per gli Stati Membri di redigere, ogni 6 anni, un Rapporto nazionale sullo stato di conservazione delle specie e degli habitat di interesse comunitario (allegati I, II, IV e V della Direttiva) e sulle misure di conservazione intraprese, chiamato anche ‘Rapporto ex Art. 17’.
Con il recepimento della Direttiva da parte dell’Italia tramite il Regolamento D.P.R. 8 settembre 1997 n.357, il Ministero dell’Ambiente e della Tutela del Territorio e del Mare ha l’obbligo di redigere il Rapporto nazionale periodico a partire dai risultati del monitoraggio che le Regioni e le Province Autonome sono tenute a trasmettere secondo quanto previsto dall’articolo 13, comma 2, dello stesso Decreto.
ISPRA è stato incaricato dal Ministero dell’Ambiente di coordinare la raccolta e l’analisi dei dati forniti dalle Amministrazioni locali.
Le Regioni e le Province Autonome, nel corso del 2012, hanno elaborato 1.940 schede di valutazione per la fauna, 358 schede per la flora, 1.126 per gli habitat e 2.926 mappe di presenza di specie e habitat a livello regionale. I dati regionali, sia tabellari sia cartografici, sono stati quindi aggregati a livello biogeografico e nazionale, come richiesto dalla Direttiva, e sottoposti alle Società scientifiche coinvolte nel lavoro che hanno provveduto ad integrare le informazioni alla luce delle più aggiornate conoscenze disponibili in ambito scientifico, e a revisionare e validare tutti i dati raccolti.
Il Ministero dell’Ambiente, di concerto con le Regioni e le Province autonome, ha condotto un’attenta verifica della congruenza tra i dati raccolti per il 3° Rapporto e le informazioni di distribuzione relative alla banca dati Natura 2000.
Sono state complessivamente generate 572 schede di valutazione dello stato di conservazione e 634 mappe di distribuzione e range per le specie; per gli habitat sono state invece prodotte 262 schede e 262 mappe di distribuzione e range.
                  
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; 2015 YourCompany | By : <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap</a>
                </div>

            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="{!! asset('js/vendor/plugins/jquery-2.1.1.js') }}"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="{!! asset('js/vendor/plugins/bootstrap.min.js') }}"></script>
</body>
</html>
