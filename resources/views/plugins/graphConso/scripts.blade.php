<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/light.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/export.js"></script>
<script type="text/javascript">
//    <?php //echo 'var $data2='. $data; ?>//;
    var $data = [
        {
            "category": "2014-03-01",
            "Temps passé": 8,
            "Temps de référence": "10",
            "type": "modif"
        },
        {
            "category": "2014-03-02",
            "Temps passé": 16,
            "Temps de référence": 21,
            "type": "modif image"
        },
        {
            "category": "2014-03-03",
            "Temps passé": 2,
            "Temps de référence": 3,
            "type": "site"
        },
        {
            "category": "2014-03-04",
            "Temps passé": 7,
            "Temps de référence": 7,
            "type": "demande A"
        },
        {
            "category": "2014-03-05",
            "Temps passé": 5,
            "Temps de référence": 9,
            "type": "demande B"
        },
        {
            "category": "2014-03-06",
            "Temps passé": 9,
            "Temps de référence": 15,
            "type": "demande C"
        },
        {
            "category": "2014-03-07",
            "Temps passé": 4,
            "Temps de référence": 9,
            "type": "modif"
        },
        {
            "category": "2014-03-08",
            "Temps passé": 15,
            "Temps de référence": "15",
            "type": "mofication binaire"
        },
        {
            "category": "2014-03-09",
            "Temps passé": 12,
            "Temps de référence": "12",
            "type": "pourquoi"
        },
        {
            "category": "2014-03-10",
            "Temps passé": 17,
            "Temps de référence": 22,
            "type": "parceque"
        },
        {
            "category": "2014-03-11",
            "Temps passé": 18,
            "Temps de référence": "18",
            "type": "une autre modif"
        },
        {
            "category": "2014-03-12",
            "Temps passé": 21,
            "Temps de référence": "21",
            "type": "lorem ipsum"
        },
        {
            "category": "2014-03-13",
            "Temps passé": 24,
            "Temps de référence": "24",
            "type": "dolor site amet"
        },
        {
            "category": "2014-03-14",
            "Temps passé": 23,
            "Temps de référence": "23",
            "type": "momomomodif"
        },
        {
            "category": "2014-03-15",
            "Temps passé": 24,
            "Temps de référence": "28",
            "type": "ication"
        }
    ];
    AmCharts.makeChart("graphConso1",
            {
                "type": "serial",
                "categoryField": "category",
                "dataDateFormat": "YYYY-MM-DD",
                "startDuration": 1,
                "theme": "light",
                "export": {
                    "enabled": true
                },
                "categoryAxis": {
                    "gridPosition": "start",
                    "parseDates": true,
                    "title": "Date"
                },
                "chartCursor": {
                    "enabled": true
                },
                "chartScrollbar": {
                    "enabled": true
                },
                "trendLines": [],
                "graphs": [
                    {
                        "balloonText": "[[title]] [[value]]",
                        "clustered": false,
                        "fillAlphas": 1,
                        "id": "AmGraph-1",
                        "labelAnchor": "end",
                        "labelOffset": 5,
                        "labelPosition": "bottom",
                        "labelRotation": 270,
                        "labelText": "",
                        "title": "Temps passé",
                        "type": "column",
                        "valueField": "Temps passé"
                    },
                    {
                        "balloonText": "[[type]] : [[title]] [[value]]",
                        "id": "AmGraph-2",
                        "lineColor": "#4986A3",
                        "lineThickness": 3,
                        "title": "Référence",
                        "type": "column",
                        "valueField": "Temps de référence"
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "id": "ValueAxis-1",
                        "title": "Heures"
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "legend": {
                    "enabled": true
                },
                "titles": [
                    {
                        "id": "Title-1",
                        "size": 15,
                        "text": "Consommations"
                    }
                ],
                "dataProvider": $data
            }
    );
</script>