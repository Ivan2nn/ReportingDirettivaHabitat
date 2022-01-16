function CsvGenerator(dataArray, fileName, separator, addQuotes) {
    this.dataArray = dataArray;
    this.fileName = fileName;
    this.separator = separator || ',';
    this.addQuotes = !!addQuotes;

    if (this.addQuotes) {
        this.separator = '"' + this.separator + '"';
    }

    this.getDownloadLink = function () {
        var separator = this.separator;
        var addQuotes = this.addQuotes;

        var headers = "Codice Specie, Nome Species, Regioni Biogeografiche, Regno, Phylum, Classe, Ordine, Famiglia, Genere, Stato di Conservazione ALP, Stato di Conservazione CON, Stato di Conservazione MED, Stato di Conservazione MMED, Trend ALP, Trend CON, Trend MED, Trend MMED, Annexes, Specifiche LRI, Specifiche IUCN, Priorita, Endemica, Modifica";

        if (Array.isArray(this.dataArray)) {
            var rows = this.dataArray.map(function (row) { 
                var columns = [];
                columns.push(row.species_code);
                columns.push(row.species_name);
                columns.push(row.bioregions.join('-'));
                columns.push(row.kingdom);
                columns.push(row.phylum);
                columns.push(row.class);
                columns.push(row.order);
                columns.push(row.family);
                columns.push(row.genus);
                columns.push(row.species_conservation_alp);
                columns.push(row.species_conservation_con);
                columns.push(row.species_conservation_med);
                columns.push(row.species_conservation_mmed);
                columns.push(row.species_trend_alp);
                columns.push(row.species_trend_con);
                columns.push(row.species_trend_med);
                columns.push(row.species_trend_mmed);
                columns.push(row.annexes.join('-'));
                columns.push(row.lri_specs);
                columns.push(row.iucn_specs);
                columns.push(row.priority);
                columns.push(row.endemic);
                columns.push(row.modified);

                var columnsData = columns.join(',');
                return columnsData;
            });

            var data = rows.join('\n');

        } else {
            var columns = [];
            columns.push(this.dataArray.species_code);
            columns.push(this.dataArray.species_name);
            columns.push(this.dataArray.bioregions.join('-'));
            columns.push(this.dataArray.kingdom);
            columns.push(this.dataArray.phylum);
            columns.push(this.dataArray.class);
            columns.push(this.dataArray.order);
            columns.push(this.dataArray.family);
            columns.push(this.dataArray.genus);
            columns.push(this.dataArray.species_conservation_alp);
            columns.push(this.dataArray.species_conservation_con);
            columns.push(this.dataArray.species_conservation_med);
            columns.push(this.dataArray.species_conservation_mmed);
            columns.push(this.dataArray.species_trend_alp);
            columns.push(this.dataArray.species_trend_con);
            columns.push(this.dataArray.species_trend_med);
            columns.push(this.dataArray.species_trend_mmed);
            columns.push(this.dataArray.annexes.join('-'));
            columns.push(this.dataArray.lri_specs);
            columns.push(this.dataArray.iucn_specs);
            columns.push(this.dataArray.priority);
            columns.push(this.dataArray.endemic);
            columns.push(this.dataArray.modified);

            var data = columns.join(',');
        }


        


       /* this.dataArray.species_code + 'this.dataArray.annexes.join('-') + ',' + this;

        var rows = this.dataArray.map(function (row) {
            var rowData = row.join(separator);

            if (rowData.length && addQuotes) {
                return '"' + rowData + '"';
            }

            return rowData
        });*/
        var data = headers + "\n" + data;
        //console.log(headers + "\n" + columnsData);

        var type = 'data:text/csv;charset=utf-8,%EF%BB%BF';
        //var data = rows.join('\n');

        if (typeof btoa === 'function') {
            type += ';base64';
            data = btoa(data);
        } else {
            data = encodeURIComponent(data);
        }

        return this.downloadLink = this.downloadLink || type + ',' + data;
    };

    this.getLinkElement = function (linkText) {
        var downloadLink = this.getDownloadLink();
        return this.linkElement = this.linkElement || $('<a>' + (linkText || '') + '</a>', {
            href: downloadLink,
            download: this.fileName
        });
    };

    // call with removeAfterDownload = true if you want the link to be removed after downloading
    this.download = function (removeAfterDownload) {
        this.getLinkElement().css('display', 'none').appendTo('body');
        this.getLinkElement()[0].click();
        if (removeAfterDownload) {
            this.getLinkElement().remove();
        }
    };
}