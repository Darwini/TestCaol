<style type="text/css">
    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px; 
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-data-table table {
    	font-family: Verdana, sans-serif;
    	border-collapse: collapse;
    	border: 1px solid #EBEBEB;
    	margin: 10px auto;
    	text-align: center;
    	width: 100%;
    	max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
    	font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>

<script src="{{ asset('Highcharts-8.2.2/code/highcharts.js') }}"></script>
<script src="{{ asset('Highcharts-8.2.2/code/modules/exporting.js') }}"></script>
<script src="{{ asset('Highcharts-8.2.2/code/modules/export-data.js') }}"></script>
<script src="{{ asset('Highcharts-8.2.2/code/modules/accessibility.js') }}"></script>

{{-- <script src="{{ asset('Highcharts-8.2.2/code/modules/series-label.js') }}"></script> --}}

<figure class="highcharts-figure">
    <div id="graphic"></div>
</figure>

<script type="text/javascript">
    Highcharts.chart({
        chart: {
            renderTo: `graphic`,
            type: 'column'
        },
        title: {
            text: 'Performance Commercial'
        },
        subtitle: {
            text: subtitle(),
        },
        xAxis: {
            categories: meses(),
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '(R$)'
            },
            max:40000,
        },
        credits: {
            enabled: false
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} R$</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: series(),
    });

    function meses(){
        var meses = [];
        <?php
            foreach ($months as $k => $month) {
        ?>
            meses.push('{{$month->month_name}}');
        <?php       
            }
        ?>
        return meses;
    }

    function series(){
        var series = [];
        <?php
            foreach ($consultores as $k => $consultor) {
        ?>
            series.push(
                {
                    'name': '{{ $consultor->no_usuario }}',
                    'data' : dataRL('{{ $consultor->no_usuario }}'),
                }
            );
        <?php
            }
        ?>
        return series;
    }

    function dataRL(nombre){
        var data = [];
        <?php
            foreach ($datos as $d => $dato) {
        ?>
            if(nombre == `{{ $dato->no_usuario }}`){
                data.push(
                    {{ number_format($dato->receita_liquida, 2, '.', '') }}
                );
            }
        <?php       
            }
        ?>
        return data;
    }

    function subtitle(){
       return `Since {{ $years[0]->year }}`;
    }
</script>