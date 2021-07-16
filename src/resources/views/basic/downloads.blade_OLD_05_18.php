@extends('partials.layout')

@section('content')

<!-- BEGIN: CONTENT/FEATURES/FEATURES-1 -->
<div class="c-content-box c-size-md c-bg-white">
    <div class="container">
        <div class="row">
        	<div class="section-context">
		<h2 class="c-font-uppercase c-font-bold c-font-40 c-margin-b-20 c-margin-t-30">Reporting 2013-2018</h2>

		<p><strong><a href="ftp://ftp.isprambiente.it" target="_blank" class="c-font-26 color-red">Materiale IV Report (accesso limitato a Regioni e Province Autonome)</a></strong></p>

		<p><strong>DOCUMENTI UFFICIALI EUROPEI</strong></p>                
		<p class="c-font-8"><a href="http://cdr.eionet.europa.eu/help/habitats_art17" target="_blank">http://cdr.eionet.europa.eu/help/habitats_art17</a></p>
                    <ul class="c-content-list-1 c-theme c-separator-dot">
                    <!-- <li><a href="http://www.sinanet.isprambiente.it/it/Reporting_Dir_Habitat/rapporto/rapporto-..." target="_blank">Volume del 3° Rapporto Nazionale Direttiva Habitat – Specie e habitat di interesse comunitario in Italia: distribuzione, stato di conservazione e trend. ISPRA, Serie Rapporti, 194/2014</a></li> -->
			<li><a href="{!! asset('public/documents/documenti ufficiali europei/Reporting guidelines.pdf') !!}" target="_blank">Reporting guidelines (pdf)</a></li>
			<li><a href="{!! asset('public/documents/documenti ufficiali europei/Report format.pdf') !!}" target="_blank">Reporting format (pdf)</a></li>
			<li><a href="{!! asset('public/documents/documenti ufficiali europei/checklists_draft.xls') !!}" target="_blank">Checklist per specie ed habitat (xls)</a></li>
			<li><a href="{!! asset('public/documents/documenti ufficiali europei/List of Pressures_Threats.xls') !!}" target="_blank">List of pressures and threats (xls)</a></li>
			<li><a href="{!! asset('public/documents/documenti ufficiali europei/list_of_conservation_measures.xls') !!}" target="_blank">List of conservation measures (xls)</a></li>
			
                    </ul>
                <h2 class="c-font-uppercase c-font-bold c-font-40 c-margin-b-20 c-margin-t-30">MANUALI DI MONITORAGGIO - SPECIE E HABITAT TERRESTRI</h2>
                    <ul class="c-content-list-1 c-theme c-separator-dot">
                    <li><a href="http://www.isprambiente.gov.it/public_files/direttiva-habitat/Manuale-140-2016.pdf" target="_blank">Manuali per il monitoraggio di specie e habitat di interesse comunitario (Direttiva 92/43/CEE) in Italia: specie vegetali. ISPRA, Serie Manuali e linee guida, 140/2016.</a></li>

                    <li><a href="http://www.isprambiente.gov.it/public_files/direttiva-habitat/Manuale-141-2016.pdf" target="_blank">Manuali per il monitoraggio di specie e habitat di interesse comunitario (Direttiva 92/43/CEE) in Italia: specie animali. ISPRA, Serie Manuali e linee guida, 141/2016.</a></li>

                    <li><a href="http://www.isprambiente.gov.it/public_files/direttiva-habitat/Manuale-142-2016.pdf" target="_blank">Manuali per il monitoraggio di specie e habitat di interesse comunitario (Direttiva 92/43/CEE) in Italia: habitat. ISPRA, Serie Manuali e linee guida, 142/2016.</a></li>
                    </ul>
		<p><strong>SCHEDE DI RILEVAMENTO DI CAMPO</strong></p>
                    <ul class="c-content-list-1 c-theme c-separator-dot">
			<li><a href="{!! asset('public/documents/schede di rilevamento di campo/Scheda Briofite.docx') !!}" target="_blank">Scheda briofite (doc)</a></li>
			<li><a href="{!! asset('public/documents/schede di rilevamento di campo/Scheda Licheni.docx') !!}" target="_blank">Scheda licheni (doc)</a></li>
			<li><a href="{!! asset('public/documents/schede di rilevamento di campo/SCHEDE di CAMPO_sp_veg_ISTRUZIONI.pdf') !!}" target="_blank">Indicazione per la compilazione piante vascolari (pdf)</a></li>
			<li><a href="{!! asset('public/documents/schede di rilevamento di campo/Scheda Piante Vascolari.docx') !!}" target="_blank">Scheda piante vascolari (doc)</a></li>
			<li>Scheda habitat (<a href="{!! asset('public/documents/schede di rilevamento di campo/Scheda HABITAT.docx') !!}" target="_blank">docx</a> , <a href="{!! asset('public/documents/schede di rilevamento di campo/Scheda HABITAT.xlsx') !!}" target="_blank">xlsx</a>)</li>
                    </ul>
		<p><strong>APPROFONDIMENTI (SPECIE)</strong></p>
		<ul class="c-content-list-1 c-theme c-separator-dot">
			<li><a href="https://natureconservation.pensoft.net/issue/996/" target="_blank">Guidelines for the Monitoring of the Saproxylic Beetles protected in Europe</a></li>
			<li><a href="https://natureconservation.pensoft.net/issue/995/" target="_blank">Monitoring of saproxylic beetles and other insects protected in the European Union</a></li>
		</ul>
                <p><strong>APPROFONDIMENTI (HABITAT)</strong></p>
                    <ul class="c-content-list-1 c-theme c-separator-dot">
                    <!-- <li><a href="https://circabc.europa.eu/faces/jsp/extension/wai/navigation/container.jsp?FormPrincipal:_idcl=navigationLibrary&amp;FormPrincipal_SUBMIT=1&amp;org.apache.myfaces.trinidad.faces.STATE=DUMMY&amp;id=be211e15-6285-4e56-801c-bc00710fccb2" target="_blank">Documenti e presentazioni delle discussioni in corso degli Expert Group nei meeting ottobre-novembre 2016</a></li> -->
                    <li><a href="{!! asset('public/documents/HABITAT 2330 approfondimenti.pdf') !!}" target="_blank">Caso studio: Conservazione e valorizzazione dell’habitat “2330 Dune dell’entroterra con prati aperti a Corynephorus e Agrostis” nella Pianura Padana</a></li>
                    <li><a href="{!! asset('public/documents/Habitat_Approf.zip') !!}" target="_blank">Risultati dei test di campo effettuati per la redazione delle schede per il monitoraggio degli Habitat</a></li>
                    </ul>
                
<h2 class="c-font-uppercase c-font-bold c-font-40 c-margin-b-20 c-margin-t-30">SCHEDE DI MONITORAGGIO - SPECIE E HABITAT MARINI</h2>

<ul class="c-content-list-1 c-theme c-separator-dot">
			<li>Direttiva Habitat - Specie</li>
			<li>Direttiva Habitat - Habitat</li>
			<li>Direttiva Uccelli - Avifauna</li>
				</ul>

<h2 class="c-font-uppercase c-font-bold c-font-40 c-margin-b-20 c-margin-t-30">Reporting 2007-2012</h2>
		<ul class="c-content-list-1 c-theme c-separator-dot">
			<li><a href="http://www.sinanet.isprambiente.it/it/Reporting_Dir_Habitat/rapporto/rapporto-..." target="_blank">Volume del 3° Rapporto Nazionale Direttiva Habitat – Specie e habitat di interesse comunitario in Italia: distribuzione, stato di conservazione e trend. ISPRA, Serie Rapporti, 194/2014</a></li>
		</ul>
		<p><strong>APPROFONDIMENTI (HABITAT)</strong></p>
		<ul class="c-content-list-1 c-theme c-separator-dot">
			<li><a href="{!! asset('public/documents/La rilevanza delle regioni e PA nella conservazione degli habitat.pdf') !!}" target="_blank">Studio: Indice di rilevanza di una Regione sulla conservazione di un habitat a livello biogeografico</a></li>
			
		</ul>
            </div>  
        </div> 
    </div>
</div>
<!-- END: CONTENT/FEATURES/FEATURES-1 -->

@endsection
