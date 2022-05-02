@extends('layouts.test')

@section('cabecera')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" data-target="#consultores">Por consultor</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" data-target="#clientes">Por Cliente</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content my-2">
        <div id="consultores" class="container tab-pane active"><br>
            <div class="row form-group">
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <label class="">Período</label>
                </div>
                <div class="col-md-1">
                    @php($mes_actual = \Carbon\Carbon::now()->format('m'))
                    @php($anio = \Carbon\Carbon::now()->format('Y'))
                    <select class="form-select form-select-sm" name="mes_desde">
                        @foreach($meses as $number => $mes)
                            <option @if($number == $mes_actual - 1) selected="selected" @endif value="{{ $number }}">
                                {{ $mes['slug'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select class="form-select form-select-sm" name="anio_desde">
                        @for($i = 2000; $i <= $anio; $i++)
                            <option @if($i == $anio) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1" style="display: flex;align-items: center;justify-content: center;">A</div>
                <div class="col-md-1">
                    <select class="form-select form-select-sm" name="mes_hasta">
                        @foreach($meses as $number => $mes)
                            <option @if($number == $mes_actual) selected="selected" @endif value="{{ $number }}">{{ $mes['slug'] }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select class="form-select form-select-sm" name="anio_hasta">
                        @for($i = 2000; $i <= $anio; $i++)
                            <option @if($i == $anio) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4" style="position: relative;">
                    {{--
                    <button class="btn-group btn btn-sm btn-primary align-items-center" data-toggle="modal" data-bs-toggle="modal" data-target="#SeleccionarConsultores">
                        <i class="fa fa-plus"></i> &nbsp; Consultores
                    </button>
                    --}}

                    <!-- The Modal -->
                    <div class="modal fade mt-0 mb-3 d-block show" style="background: rgba(255, 255, 255, 1.0);position: inherit;" id="SeleccionarConsultores">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mt-0">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('consultarConsultores') }}" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Modal Header -->
                                    {{-- <div class="modal-header">
                                        <h4 class="modal-title">Listado de Consultores</h4> --}}
                                        {{-- <button type="button" class="btn btn-sm btn-outline-danger close" data-dismiss="modal">×</button> --}}
                                    {{-- </div> --}}
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Consultores
                                        <ul class="list-group border rounded p-2" style="overflow-y: auto;overflow-x: hidden;height: calc(25vh);">
                                            @forelse($consultores as $consultores)
                                                <label class="row listado">
                                                    <span class="col-10">
                                                        {{ $consultores->no_usuario ?? $consultores->co_usuario ?? 'Empty Data' }}
                                                    </span>
                                                    <span class="col-2">
                                                        <input type="checkbox" class="custom-checkbox" name="consultores_check[]" value="{{ $consultores->co_usuario ?? '' }}" data-texto="{{ $consultores->no_usuario ?? $consultores->co_usuario ?? 'Empty Data' }}">
                                                    </span>
                                                </label>
                                            @empty
                                            @endforelse
                                        </ul>
                                    </div>

                                    {{-- <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="ajax" data-target="#SeleccionarConsultores">
                                            Procesar
                                        </button>
                                    </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex justify-content-between flex-wrap" id="consultoreSeleccionados"></div>
                </div>

                <div class="col-md-4">
                    <div id="botones_opciones" class="d-flex flex-column align-items-center justify-content-center" style="gap: 16px;"></div>
                </div>
            </div>

            <hr>
            <div id="contenidos"></div>
        </div>

        <div id="clientes" class="container tab-pane fade"><br>
            <h3>Clientes</h3>
            <p>
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
        </div>
    </div>
@endsection

@section('contenido')
    
@endsection

@section('js')
    <script type="text/javascript">
        var token = '{{ csrf_token() }}';
        var url = '{{ url('/') }}';

        $(`[name="consultores_check[]"]`).on('change', (e) => {
            comprobarChecked();
        });

        function comprobarChecked(){
            const da = recorrer();
            let elementos = ``;
            for(i = 0; i < da.length; i++){
                elementos +=`<span data-consultores class="h6 px-3 bg-light mx-1" style="border-radius: 3rem;">${da[i]}</span>`;
            }
            $(`#consultoreSeleccionados`).html(elementos);
            lanzarOpciones();
        }

        function lanzarOpciones(){
            const dk = $(`[data-consultores]`).length;
            if (dk == 0) { $(`#botones_opciones`).empty(); }
            else{ renderizarOpciones(); }
        }

        function renderizarOpciones() {
            const botones = `<button class="w-50 mx-auto btn btn-block btn-outline-primary btn-sm" onclick="relatorio();">
                <i class="fa fa-file-text-o"></i> Relatório
            </button>
            <button class="w-50 mx-auto btn btn-block btn-outline-primary btn-sm" onclick="grafico();">
                <i class="fa fa-bar-chart"></i> Gráfico
            </button>
            <button class="w-50 mx-auto btn btn-block btn-outline-primary btn-sm" onclick="pizza();">
                <i class="fa fa-pie-chart"></i> Pizza
            </button>`;

            $(`#botones_opciones`).html(botones);
        }

        function chargeFilters(){
            $data = {
                'mes_desde' : $(`[name="mes_desde"]`).val(),
                'anio_desde' : $(`[name="anio_desde"]`).val(),
                'mes_hasta' : $(`[name="mes_hasta"]`).val(),
                'anio_hasta' : $(`[name="anio_hasta"]`).val(),
            }
            return $data;
        }

        function relatorio(){
            const data = chargeFilters();
            const datos = {
                '_token' : token,
                'mes_desde' : data.mes_desde,
                'anio_desde' : data.anio_desde,
                'mes_hasta' : data.mes_hasta,
                'anio_hasta' : data.anio_hasta,
                'consultores': recorrer('valores'),
            }
            const ruta = `${url}/ajaxConsultores`;
            lanzarAjax(datos, ruta);
        }


        function recorrer(resp){
            let c, valor, texto; let d = [];
            $(`[name="consultores_check[]"]`).each(function(){
                c = $(this).prop('checked');
                if(c === true){
                    if (resp=='valores') {
                        datos = $(this).val();
                    }else{
                        datos = $(this).attr('data-texto');
                    }
                    d.push(datos);
                }
            });
            return d;
        }

        function lanzarAjax(datos, ruta)
        {
            let ajax = $.ajax({
                url : `${ruta}`,
                method : 'POST',
                data : datos,
                dataType : `json`,
            });

            ajax.done((resp) => { montarDatos(resp); });
            ajax.fail((error) => { console.log(error); });
        }

        function montarDatos(resp){
            $(`#contenidos`).html(resp[0]);
        }

        function grafico(){
            const ruta = `${url}/graficos`;
            const data = chargeFilters();
            const datos = {
                '_token' : token,
                'grafico' : 'grafico',
                'mes_desde' : data.mes_desde,
                'anio_desde' : data.anio_desde,
                'mes_hasta' : data.mes_hasta,
                'anio_hasta' : data.anio_hasta,
                'consultores': recorrer('valores'),
            }
            lanzarAjax(datos, ruta);
        }

        function pizza(){
            const ruta = `${url}/graficos`;
            const data = chargeFilters();
            const datos = {
                '_token' : token,
                'grafico' : 'pizza',
                'mes_desde' : data.mes_desde,
                'anio_desde' : data.anio_desde,
                'mes_hasta' : data.mes_hasta,
                'anio_hasta' : data.anio_hasta,
                'consultores': recorrer('valores'),
            }
            lanzarAjax(datos, ruta);
        }
    </script>
@endsection