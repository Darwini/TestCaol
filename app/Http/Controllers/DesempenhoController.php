<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Permissao;
use App\Models\Usuario;
use App\Models\Fatura;
use DB;

class DesempenhoController extends Controller
{
    public $meses = [
        1 => [ 'name' => 'Enero', 'slug' => 'Jan' ],
        2 => [ 'name' => 'Febrero', 'slug' => 'Fev' ],
        3 => [ 'name' => 'Marzo', 'slug' => 'Mar' ],
        4 => [ 'name' => 'Abril', 'slug' => 'Abr' ],
        5 => [ 'name' => 'Mayo', 'slug' => 'Mai' ],
        6 => [ 'name' => 'Junio', 'slug' => 'Jun' ],
        7 => [ 'name' => 'Julio', 'slug' => 'Jul' ],
        8 => [ 'name' => 'Agosto', 'slug' => 'Ago' ],
        9 => [ 'name' => 'Septiembre', 'slug' => 'Set' ],
        10 => [ 'name' => 'Octubre', 'slug' => 'Out' ],
        11 => [ 'name' => 'Noviembre', 'slug' => 'Nov' ],
        12 => [ 'name' => 'Diciembre', 'slug' => 'Dez' ],
    ];

    public function index()
    {    
        $consultores = Usuario::
            Join('permissao_sistema', 'cao_usuario.co_usuario', 'permissao_sistema.co_usuario')
            ->where('permissao_sistema.co_sistema', 1)
            ->where('permissao_sistema.in_ativo', 'S')
            ->whereIn('permissao_sistema.co_tipo_usuario', [0, 1, 2])
            ->get();

        $data = [
            'meses' => $this->meses,
            'consultores' => $consultores,
        ];
        return view('desempenho.index', $data);
    }

    public function ajaxShowConsultores(Request $request)
    {
        if (!$request->ajax()){ return redirect()->back(); }
        $total_imp_inc = 'cao_fatura.total * (cao_fatura.total_imp_inc / 100)';
        // RECEITA LIQUIDA = VALOR - TOTAL_IMP_INC 
        $receta_liquida = 'SUM(cao_fatura.total - ('.$total_imp_inc.')) AS receita_liquida';
        // comisión = (VALOR – (VALOR * TOTAL_IMP_INC)) * COMISSAO_CN
        $comissao = 'SUM(cao_fatura.total - ('.$total_imp_inc.') * (cao_fatura.comissao_cn/100)) AS comissao';
        // Lucro = (VALOR-TOTAL_IMP_INC) – (Costo fijo + comisión).
        $lucro = 'SUM((cao_fatura.total - ('.$total_imp_inc.')) - (cao_salario.brut_salario + (cao_fatura.comissao_cn / 100))) AS lucro';
        // return response()->json($lucro);
        $datos = [
            'datos' => DB::table('cao_os')
                        ->leftJoin('cao_fatura', 'cao_os.co_os', 'cao_fatura.co_os')
                        ->leftJoin('cao_usuario', 'cao_os.co_usuario', 'cao_usuario.co_usuario')
                        ->leftJoin('cao_salario', 'cao_usuario.co_usuario', 'cao_salario.co_usuario')
                        ->select(
                                'cao_salario.brut_salario',
                                'cao_usuario.no_usuario',
                                DB::raw($receta_liquida),
                                DB::raw($comissao),
                                DB::raw($lucro),
                                DB::raw('MONTHNAME(cao_fatura.data_emissao) AS month_name'),
                                DB::raw('YEAR(cao_fatura.data_emissao) AS year'),
                        )
                        ->whereIn('cao_os.co_usuario', $request->consultores)
                        ->whereYear('cao_fatura.data_emissao', '>=', $request->anio_desde)
                        ->whereYear('cao_fatura.data_emissao', '<=', $request->anio_hasta)
                        ->whereMonth('cao_fatura.data_emissao', '>=', $request->mes_desde)
                        ->whereMonth('cao_fatura.data_emissao', '<=', $request->mes_hasta)
                        ->groupBy('cao_usuario.no_usuario', 'month_name', 'year', 'cao_salario.brut_salario')
                        ->get(),

            'consultores' => DB::table('cao_usuario')
                            ->select('no_usuario')
                            ->whereIn('co_usuario', $request->consultores)
                            ->get(),
        ];
        return response()->json([view('desempenho.ajaxs.relatorio', $datos)->render()], 200);
    }

    public function ajaxGraficos(Request $request)
    {
        if ($request->ajax()) {
            $total_imp_inc = 'cao_fatura.total * (cao_fatura.total_imp_inc / 100)';
            // RECEITA LIQUIDA = VALOR - TOTAL_IMP_INC 
            $receta_liquida = 'SUM(cao_fatura.total - ('.$total_imp_inc.')) AS receita_liquida';
            
            $data = [
                'months' => DB::table('cao_os')
                        ->leftJoin('cao_fatura', 'cao_os.co_os', 'cao_fatura.co_os')
                        ->select(
                            DB::raw('MONTHNAME(cao_fatura.data_emissao) AS month_name'),
                        )
                        ->whereIn('cao_os.co_usuario', $request->consultores)
                        ->whereYear('cao_fatura.data_emissao', '>=', $request->anio_desde)
                        ->whereYear('cao_fatura.data_emissao', '<=', $request->anio_hasta)
                        ->whereMonth('cao_fatura.data_emissao', '>=', $request->mes_desde)
                        ->whereMonth('cao_fatura.data_emissao', '<=', $request->mes_hasta)
                        ->groupBy('month_name')
                        ->get(),

                'years' => DB::table('cao_os')
                        ->leftJoin('cao_fatura', 'cao_os.co_os', 'cao_fatura.co_os')
                        ->select(
                            DB::raw('YEAR(cao_fatura.data_emissao) AS year'),
                        )
                        ->whereIn('cao_os.co_usuario', $request->consultores)
                        ->whereYear('cao_fatura.data_emissao', '>=', $request->anio_desde)
                        ->whereYear('cao_fatura.data_emissao', '<=', $request->anio_hasta)
                        ->groupBy('year')
                        ->get()->toArray(),

                'datos' => DB::table('cao_os')
                        ->leftJoin('cao_fatura', 'cao_os.co_os', 'cao_fatura.co_os')
                        ->leftJoin('cao_usuario', 'cao_os.co_usuario', 'cao_usuario.co_usuario')
                        ->select(
                            'cao_usuario.no_usuario',
                            DB::raw($receta_liquida),
                            DB::raw('MONTHNAME(cao_fatura.data_emissao) AS month_name'),
                        )
                        ->whereIn('cao_os.co_usuario', $request->consultores)
                        ->whereYear('cao_fatura.data_emissao', '>=', $request->anio_desde)
                        ->whereYear('cao_fatura.data_emissao', '<=', $request->anio_hasta)
                        ->whereMonth('cao_fatura.data_emissao', '>=', $request->mes_desde)
                        ->whereMonth('cao_fatura.data_emissao', '<=', $request->mes_hasta)
                        ->groupBy('cao_usuario.no_usuario', 'month_name')
                        ->get(),
                'consultores' => DB::table('cao_usuario')
                            ->select('no_usuario')
                            ->whereIn('co_usuario', $request->consultores)
                            ->get(),
            ];
            // return response()->json($data);
            return response()->json([view('desempenho.ajaxs.'.$request->grafico, $data)->render()], 200);
        }
    }
}
