<style type="text/css">
    #container {
      height: 400px; 
    }

    .highcharts-figure, .highcharts-data-table table {
      min-width: 310px; 
      max-width: 800px;
      margin: 1em auto;
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
<script src="{{ asset('Highcharts-8.2.2/code/highcharts-3d.js') }}"></script>
<script src="{{ asset('Highcharts-8.2.2/code/modules/exporting.js') }}"></script>
<script src="{{ asset('Highcharts-8.2.2/code/modules/export-data.js') }}"></script>
<script src="{{ asset('Highcharts-8.2.2/code/modules/accessibility.js') }}"></script>

<figure class="highcharts-figure">
    <div id="pizzaGate"></div>
</figure>

<script type="text/javascript">
    Highcharts.chart({
        chart: {
            renderTo: `pizzaGate`,
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Participacao na Rece...'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            type: 'pie',
            name: 'Participacao',
            data: series(),
        }]
    });

    function series(){
        var serie = [];
        <?php
            foreach ($consultores as $k => $consultor) {
        ?>
            serie.push(['{{ $consultor->no_usuario }}',dataRL('{{ $consultor->no_usuario }}')]);
        <?php
            }
        ?>
        return serie;
    }

    function dataRL(nombre){
        var data = 0;
        <?php
            foreach ($datos as $d => $dato) {
        ?>
            if(nombre == `{{ $dato->no_usuario }}`){
                data += {{ number_format($dato->receita_liquida, 2, '.', '') }}
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