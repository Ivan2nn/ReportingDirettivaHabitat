<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{!! asset('vendor/font-awesome-4.6.3/css/font-awesome.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                <form methd="GET" action="/api/cellcodes/" v-ajax>
                {!! csrf_field() !!}
                <input type="text"
                    v-model="selectedCell"
                    id="cellCodeSelectionBox"
                >
                <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="submit">Cerca</button>
                </form>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <info-cell :list="species"></info-cell>
                </div>
                <div class="col-sm-8">
                    <div id="info-box" style="width: 100px; height: 80px; border: solid 1px black;"></div>
                    <div id="map" style="width: 640px; height: 650px;"></div>
                </div>
            </div>
        </div>

        <template id="info-cell-template">
            <h2>@{{ selectedCell->cellName }}</h2>
            <h2>Biogeographic Region: @{{ selectedCell->biogegraphic_regions[0]->name }}
            <table class="table table-inverse">
              <thead>
                <tr>
                  <th>Species in the cell</th>
                  <th>Scientific name</th>
                  <th>Other info</th>
                  <th>Other info</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="spec in list">
                  <th scope="row">1</th>
                  <td>@{{ spec.name }} </td>
                  <td>Other info</td>
                  <td>Other info</td>
                </tr>
              </tbody>
            </table>
        </template>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWmknJ23y9FJ6i3EUXhZHGUDB2QEbSPXE"
    async defer></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
        <script src="https://cdn.jsdelivr.net/vue.resource/0.9.3/vue-resource.min.js"></script>
        <script src="/js/cellToSpeciesMapping.js"></script>
        <script src="/js/mainCellToSpecies.js"></script>
    </body>
</html>
