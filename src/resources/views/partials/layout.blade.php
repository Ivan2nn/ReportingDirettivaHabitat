<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="it">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Reporting Direttiva Habitat</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="species - habitat in Italy" />
        <meta content="" name="mimi eDesign" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all' rel='stylesheet' type='text/css'>
             
        <link href="{!! asset('output/final.css') !!}" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="{!! asset('favicon.ico') !!}" /> 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    </head>

    <body class="c-layout-header-fixed c-layout-header-mobile-fixed">
        <!-- BEGIN: LAYOUT/HEADERS/HEADER-1 -->
        <!-- BEGIN: HEADER -->
        <header class="c-layout-header c-layout-header-6" data-minimize-offset="80">
            <div class="c-topbar">
                <div class="container">
                    
                    <div class="c-brand">
                        <div class="row c-logo">
                            <div class="col-md-4 col-xs-6">
                                <a href="http://www.minambiente.it/">
                                    <img src="{!! asset('images/logo-MASE.png') !!}" alt="logo natura" class="img-responsive">
                                </a>
                            </div>

                            <div class="col-md-4 col-xs-6">
                                <a href="http://www.nnb.isprambiente.it">
                                    <img src="{!! asset('images/logoNaturaItaliaHomeNew.png') !!}" alt="logo natura" class="c-mobile-logo img-responsive">
                                </a>
                                <a href="http://www.isprambiente.gov.it/">
                                    <img src="{!! asset('images/logo-ISPRA_SNPA.png') !!}" alt="logo natura" class="c-desktop-logo img-responsive">
                                </a>
                            </div>
                            
                            <div class="col-md-4 col-xs-6">
                                <a href="http://www.nnb.isprambiente.it">
                                    <img src="{!! asset('images/logoNaturaItaliaHomeNew.png') !!}" alt="logo natura" class="c-desktop-logo img-responsive">
                                </a>
                                <a href="http://www.isprambiente.gov.it/">
                                    <img src="{!! asset('images/logo-ISPRA_SNPA.png') !!}" alt="logo natura" class="c-mobile-logo img-responsive">
                                </a>
                            </div>
                         </div>   

                        <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                            <span class="c-line"></span>
                            <span class="c-line"></span>
                            <span class="c-line"></span>
                        </button>
                  
                    </div>
                </div>
            </div>
            
            <div class="c-navbar">
                <div class="container">
                    <!-- BEGIN: BRAND -->
                    <div class="c-navbar-wrapper clearfix">
                        <!-- END: BRAND -->
                        <!-- BEGIN: QUICK SEARCH -->
                        <form class="c-quick-search" action="#">
                            <input name="query" placeholder="Type to search..." value="" class="form-control" autocomplete="off" type="text">
                            <span class="c-theme-link">×</span>
                        </form>
                        <!-- END: QUICK SEARCH -->
                        <!-- BEGIN: HOR NAV -->
                        <!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->
                        <!-- BEGIN: MEGA MENU -->
                        <!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
                        <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
                            <ul class="nav navbar-nav">
                                <li class="active-mimi-menu-link">
                                    <a href="{{ route('home') }}" class="c-link dropdown-toggle">Home</a>                
                                </li>
                                <li>
                                    <a href="{{ route('contesto-riferimento') }}" class="c-link dropdown-toggle">Contesto di Riferimento</a>                
                                </li>
                                <li class="c-menu-type-classic">
                                    <a href="javascript:;" class="c-link dropdown-toggle">Specie
                                        <span class="c-arrow c-toggler"></span>
                                    </a>
                                    <ul class="dropdown-menu c-menu-type-classic c-pull-left">
                                        <li>
                                            <a href="{{ route('species-basic-search') }}">Ricerca Base</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('species-advanced-search') }}">Ricerca Avanzata</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('species-cellcodes-search') }}">Ricerca Cartografica</a>
                                        </li>                                      
                                    </ul>
                                </li>
                                <li class="c-menu-type-classic">
                                    <a href="javascript:;" class="c-link dropdown-toggle">Habitat
                                        <span class="c-arrow c-toggler"></span>
                                    </a>
                                    <ul class="dropdown-menu c-menu-type-classic c-pull-left">
                                        <li>
                                            <a href="{{ route('habitat-basic-search') }}">Ricerca Base</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('habitat-advanced-search') }}">Ricerca Avanzata</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('habitat-cellcodes-search') }}">Ricerca Cartografica</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="c-menu-type-classic">
                                    <a href="javascript:;" class="c-link dropdown-toggle">III Report
                                    <span class="c-arrow c-toggler"></span></a>
                                    <ul class="dropdown-menu c-menu-type-classic c-pull-left">
                                        <li>
                                            <a href="#">Specie III Report</a>
                                        </li>
                                        <li style="padding-left: 20px;">
                                            <a href="{{ route('species-basic-search-III-report') }}">Ricerca Base</a>
                                        </li>
                                        <li style="padding-left: 20px;">
                                            <a href="{{ route('species-advanced-search-III-report') }}">Ricerca Avanzata</a>
                                        </li>
                                        <li style="padding-left: 20px;">
                                            <a href="{{ route('species-cellcodes-search-III-report') }} ">Ricerca Cartografica</a>
                                        </li>
                                        <li class="c-margin-t-20">
                                            <a href="#">Habitat III Report</a>
                                        </li>
                                        <li style="padding-left: 20px;">
                                            <a href="{{ route('habitat-basic-search-III-report') }}">Ricerca Base</a>
                                        </li>
                                        <li style="padding-left: 20px;">
                                            <a href="{{ route('habitat-advanced-search-III-report') }}">Ricerca Avanzata</a>
                                        </li>
                                         <li style="padding-left: 20px;">
                                            <a href="{{ route('habitat-cellcodes-search-III-report') }}">Ricerca Cartografica</a>
                                        </li>
                                    </ul>                
                                </li>
                                 <li>
                                    <a href="{{ route('piano-di-monitoraggio') }}" class="c-link">Piano di monitoraggio</a>                
                                </li>
                                <li>
                                    <a href="{{ route('downloads') }}" class="c-link">Download</a>                
                                </li>
                                <li>
                                    <a href="{{ route('links') }}" class="c-link">Link</a>                
                                </li>
                                    
                            </ul>
                        </nav>
                        <!-- END: MEGA MENU -->
                        <!-- END: LAYOUT/HEADERS/MEGA-MENU -->
                        <!-- END: HOR NAV -->
                    </div>
                    <!-- BEGIN: LAYOUT/HEADERS/QUICK-CART -->
                    <!-- BEGIN: CART MENU -->
                    
                    <!-- END: CART MENU -->
                    <!-- END: LAYOUT/HEADERS/QUICK-CART -->
                </div>
            </div>
        </header>
        <!-- END: HEADER -->
        <!-- END: LAYOUT/HEADERS/HEADER-1 -->
        
        
        <!-- BEGIN: PAGE CONTAINER -->
        <div class="c-layout-page">
            <!-- BEGIN: PAGE CONTENT -->
            <!-- BEGIN: LAYOUT/SLIDERS/REVO-SLIDER-4 -->
            @yield('content')
            
            <!-- END: CONTENT/TABS/TAB-1 -->
        </div>
        <!-- BEGIN: LAYOUT/FOOTERS/FOOTER-6 -->
        <a name="footer"></a>
        <footer class="c-layout-footer c-layout-footer-6 c-bg-grey-1">
            <div class="c-postfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <h4>Specie</h4>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('species-basic-search') }}" class="">Ricerca base</a>  
                                </li>
                                 <li>
                                    <a href="{{ route('species-advanced-search') }}" class="">Ricerca avanzata</a>  
                                </li>
                                <li>
                                    <a href="{{ route('species-cellcodes-search') }}" class="">Ricerca cartografica</a>  
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-3">
                            <h4>Habitat</h4>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('habitat-basic-search') }}" class="">Ricerca base</a>  
                                </li>
                                 <li>
                                    <a href="{{ route('habitat-advanced-search') }}" class="">Ricerca avanzata</a>  
                                </li>
                                <li>
                                    <a href="{{ route('habitat-cellcodes-search') }}" class="">Ricerca cartografica</a>  
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-3">
                            <h4>III Report</h4>
                            <ul class="list-unstyled">
                                <li>
                                    <p>Specie III Report</p>  
                                </li>
                                <li style="padding-left:20px;">
                                    <a href="{{ route('species-basic-search-III-report') }}">Ricerca base</a>  
                                </li>
                                <li style="padding-left:20px;">
                                    <a href="{{ route('species-advanced-search-III-report') }}" class="">Ricerca avanzata</a>  
                                </li>
                                <li style="padding-left:20px;">
                                    <a href="{{ route('species-cellcodes-search-III-report') }} " class="">Ricerca cartografica</a>  
                                </li>
                                <li class="c-margin-t-20">
                                    <p>Habitat III Report</p>  
                                </li>
                                <li style="padding-left:20px;">
                                    <a href="{{ route('habitat-basic-search-III-report') }}">Ricerca base</a>  
                                </li>
                                <li style="padding-left:20px;">
                                    <a href="{{ route('habitat-advanced-search-III-report') }}" class="">Ricerca avanzata</a>  
                                </li>
                                <li style="padding-left:20px;">
                                    <a href="{{ route('habitat-cellcodes-search-III-report') }}" class="">Ricerca cartografica</a>  
                                </li>

                            </ul>
                        </div>
                        <div class="col-sm-3">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('piano-di-monitoraggio') }}" class="">Piano di monitoraggio</a> 
                                </li>
                                <li>
                                    <a href="{{ route('downloads') }}" class="">Download</a>  
                                </li>
                                 <li>
                                    <a href="{{ route('links') }}" class="">Links</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END: LAYOUT/FOOTERS/FOOTER-6 -->
        <!-- BEGIN: LAYOUT/FOOTERS/GO2TOP -->
        <div class="c-layout-go2top">
            <i class="icon-arrow-up"></i>
        </div>
        <!-- END: LAYOUT/FOOTERS/GO2TOP -->
        <!-- BEGIN: LAYOUT/BASE/BOTTOM -->
        <!-- BEGIN: CORE PLUGINS -->
        <!--[if lt IE 9]>
  <script src="../assets/global/plugins/excanvas.min.js') !!}"></script> 
  <![endif]-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWmknJ23y9FJ6i3EUXhZHGUDB2QEbSPXE"></script> 
        <script src="{!! asset('output/final.js') !!}" type="text/javascript"></script>
	<script src="{!! asset('js/fixes.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('output/active_link.js') !!}" type="text/javascript"></script>
        
        <script>
            $(document).ready(function()
            {
                App.init(); // init core    
            });
        </script>
        <!-- END: THEME SCRIPTS -->
       @yield('added-scripts')
        <!-- END: LAYOUT/BASE/BOTTOM -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116299043-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-116299043-1');
	</script>
    </body>

</html>
