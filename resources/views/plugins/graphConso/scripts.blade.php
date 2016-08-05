<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/light.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/export.js"></script>
<script type="text/javascript">
    <?php
        if(isset($data)) {
            echo 'var $data='. $data .';';
        } else {
            echo 'var $data="";';
        }
    ?>
    AmCharts.makeChart("graphConso1",
            {
                "type": "serial",
                "categoryField": "category",
                "dataDateFormat": "YYYY-MM-DD",
                "mouseWheelZoomEnabled": true,
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