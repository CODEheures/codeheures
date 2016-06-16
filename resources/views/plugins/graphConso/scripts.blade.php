<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="{{ asset('js/xcharts.min.js') }}"></script>
<script type="text/javascript">
    var fr_FR = {
        "decimal": ".",
        "thousands": " ",
        "grouping": [3],
        "currency": ["€", ""],
        "dateTime": "%a %b %e %X %Y",
        "date": "%d/%m/%Y",
        "time": "%H:%M:%S",
        "periods": ["AM", "PM"],
        "days": ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        "shortDays": ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        "months": ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre"],
        "shortMonths": ["Jan", "Fev", "Mar", "Avr", "Mai", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    };

    var locale = d3.locale(fr_FR);

    //creation tooltip
    var divGraphConso = document.querySelector('.graph-conso');
    if(divGraphConso != null) {
        var tt = document.createElement('div');
        tt.className = 'tooltip-graph-conso';
        divGraphConso.appendChild(tt);

        //data du graph
        <?php echo 'var data='. $data; ?>;

        var opts = {
            "paddingLeft": 20,
            "paddingTop":20,
            "paddingRight": 40,
            "dataFormatX": function (x) { return locale.timeFormat('%Y-%m-%d').parse(x); },
            "tickFormatX": function (x) { return locale.timeFormat('%d-%m-%Y')(x); },
            "mouseover": function (d, i) {
                var pos = $(this).position();
                $(tt).text(locale.timeFormat('%d/%m')(d.x) + ': ' + d.y + 'h ' + d.com)
                        .css({
                            top: pos.top,
                            left: pos.left,
                        })
                        .show();
            },
            "mouseout": function (x) {
                $(tt).hide();
            }
        };

        var myChart = new xChart('line-dotted', data, '#graphConso1', opts);
    }

</script>