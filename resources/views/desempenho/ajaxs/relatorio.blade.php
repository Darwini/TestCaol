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
                @php
                    $total_rl = 0;
                    $total_bs = 0;
                    $total_c = 0;
                    $total_l = 0;
                @endphp
                @forelse($datos as $dato)
                    @if($dato->no_usuario == $consultor->no_usuario)
                        <tr>
                            <td>
                                {{ $dato->month_name }} de {{ $dato->year }}
                            </td>
                            <td>
                                R$ {{ number_format($dato->receita_liquida, 2, ',', '.') ?? 0,00 }}
                            </td>
                            <td>
                                R$ {{ number_format($dato->brut_salario, 2, ',', '.') ?? 0,00 }}
                            </td>
                            <td>
                                R$ {{ number_format($dato->comissao, 2, ',', '.') ?? 0,00 }}
                            </td>
                            <td>
                                R$ {{ number_format($dato->lucro, 2, ',', '.') ?? 0,00 }}
                            </td>
                            @php
                                $total_rl += $dato->receita_liquida;
                                $total_bs += $dato->brut_salario;
                                $total_c += $dato->comissao;
                                $total_l += $dato->lucro;
                            @endphp
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
                <td>SALDO</td>
                <td>R$ {{number_format($total_rl, 2, ',', '.') }}</td>
                <td>R$ {{number_format($total_bs, 2, ',', '.') }}</td>
                <td>R$ {{number_format($total_c, 2, ',', '.') }}</td>
                <td>R$ {{number_format($total_l, 2, ',', '.') }}</td>
            </tfoot>
        </table>
    </div>
    <hr>
@endforeach
