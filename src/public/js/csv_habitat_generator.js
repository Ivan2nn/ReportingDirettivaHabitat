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

        var headers = "Codice Habitat, Nome Habitat, Macrocategoria, Regioni Biogeografiche, Stato di Conservazione ALP, Stato di Conservazione CON, Stato di Conservazione MED, Stato di Conservazione MMED, Trend ALP, Trend CON, Trend MED, Trend MMED";

        if (Array.isArray(this.dataArray)) {
            var rows = this.dataArray.map(function (row) { 
                var columns = [];
                columns.push(row.habitat_code);
                columns.push(row.habitat_name);
                columns.push(row.macrocategory);
                columns.push(row.bioregions.join('-'));
                columns.push(row.habitat_conservation_alp);
                columns.push(row.habitat_conservation_con);
                columns.push(row.habitat_conservation_med);
                columns.push(row.habitat_conservation_mmed);
                columns.push(row.habitat_trend_alp);
                columns.push(row.habitat_trend_con);
                columns.push(row.habitat_trend_med);
                columns.push(row.habitat_trend_mmed);

                var columnsData = columns.join(',');
                return columnsData;
            });

            var data = rows.join('\n');

        } else {
            var columns = [];
            columns.push(this.dataArray.habitat_code);
            columns.push(this.dataArray.habitat_name);
            columns.push(this.dataArray.macrocategory);
            columns.push(this.dataArray.bioregions.join('-'));
            columns.push(this.dataArray.habitat_conservation_alp);
            columns.push(this.dataArray.habitat_conservation_con);
            columns.push(this.dataArray.habitat_conservation_med);
            columns.push(this.dataArray.habitat_conservation_mmed);
            columns.push(this.dataArray.habitat_trend_alp);
            columns.push(this.dataArray.habitat_trend_con);
            columns.push(this.dataArray.habitat_trend_med);
            columns.push(this.dataArray.habitat_trend_mmed);

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

        var type = 'data:text/csv;charset=utf-8';
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