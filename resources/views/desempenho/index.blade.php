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
    <div class="tab-content">
        <div id="consultores" class="container tab-pane active"><br>
            <div class="row form-group">
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <label class="">Período</label>
                </div>
                <div class="col-md-1">
                    @php($mes_actual = \Carbon\Carbon::now()->format('m'))
                    @php($anio = \Carbon\Carbon::now()->format('Y'))
                    <select class="form-select form-select-sm">
                        @foreach($meses as $number => $mes)
                            <option @if($number == $mes_actual - 1) selected="selected" @endif value="{{ $mes['slug'] }}">
                                {{ $mes['slug'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select class="form-select form-select-sm">
                        @for($i = 2000; $i <= $anio; $i++)
                            <option @if($i == $anio) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1" style="display: flex;align-items: center;justify-content: center;">A</div>
                <div class="col-md-1">
                    <select class="form-select form-select-sm">
                        @foreach($meses as $number => $mes)
                            <option @if($number == $mes_actual) selected="selected" @endif value="{{ $mes['slug'] }}">{{ $mes['slug'] }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select class="form-select form-select-sm">
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
                                        <h4>Consultores</h4>
                                        <ul class="list-group border rounded p-2" style="overflow-y: auto;overflow-x: hidden;height: 48vh;">
                                            @forelse($consultores as $consultores)
                                                <label class="row listado">
                                                    <span class="col-10">
                                                        {{ $consultores->no_usuario ?? $consultores->co_usuario ?? 'Empty Data' }}
                                                    </span>
                                                    <span class="col-2">
                                                        <input type="checkbox" class="custom-checkbox" name="consultores_check[]" value="{{ $consultores->co_usuario ?? '' }}">
                                                    </span>
                                                </label>
                                            @empty
                                            @endforelse
                                        </ul>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="ajax" data-target="#SeleccionarConsultores">
                                            Procesar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="clientes" class="container tab-pane fade"><br>
            <h3>Menu 1</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
    </div>
@endsection

@section('contenido')

@endsection

@section('js')
    <script type="text/javascript">
        $(`[data-toggle="ajax"]`).on('click', function(e){
            lanzarAjax(this);
        });

        function lanzarAjax(esto){
            const modal = $(esto).attr('data-target');
            const form = $(`${modal} form`);
            const datos = form.serialize();
            // const datos = new FormData(form);
            const route = form.attr('action');
            let ajax = $.ajax({
                url : `${route}`,
                method : 'GET',
                data : datos,
                dataType : `json`,
                // contentType : false,
                // processData : false,
                // cache : false,
            });

            ajax.done((resp) => { montarDatos(resp); });
            ajax.fail((error) => { console.log(error); });
        }

        function montarDatos(resp){
            console.log(resp);
        }

        function inputs(form){
            let c, valor; let d = [];
            $(`${form} input`).each(function(e){
                c = $(this).prop('checked');
                if(c === true){
                    valor = $(this).val();
                    d.push(valor);
                }
            });
            return d;
        }
    </script>
@endsection