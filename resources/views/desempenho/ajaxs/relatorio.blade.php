@foreach($consultores as $consultor)
    <div class="table-responsive">
        <div class="bg-light text-dark mx-auto h5" style="width: 85%;">
            {{ $consultor->no_usuario ?? 'Consultor' }}
        </div>
        <table class="table table-striped table-hover table-sm px-5 mx-auto" style="width: 85%;">
            <thead>
                <tr>
                    <th>Período</th>
                    <th>Receita Líquida</th>
                    <th>Custo Fixo</th>
                    <th>Comissão</th>
                    <th>Lucro</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datos as $dato)
                    @if($dato->no_usuario == $consultor->no_usuario)
                        <tr>
                            <td>
                                {{ $dato->month_name }} de {{ $dato->year }}
                            </td>
                            <td>
                                {{ $dato->receita_liquida }}
                            </td>
                            <td>
                                {{ $dato->brut_salario ?? 0,00 }}
                            </td>
                            <td>
                                {{ $dato->comissao ?? 0,00 }}
                            </td>
                            <td>
                                {{ $dato->lucro ?? 0,00 }}
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5">
                            <center>¡No data available!</center>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-light text-dark">
                {{-- @forelse($datos2 as $dato2) --}}
                    <td>SALDO</td>
                    <td>R$ 26.500,00</td>
                    <td>- R$ 4.000,00</td>
                    <td>- R$ 3.500,00</td>
                    <td>R$ 19.000,00</td>
                {{-- @empty --}}
                {{-- @endforelse --}}
            </tfoot>
        </table>
    </div>
@endforeach
