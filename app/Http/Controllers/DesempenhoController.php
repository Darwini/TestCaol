<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Cliente;
use App\Models\Permissao;
use App\Models\Usuario;

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
            // 'clientes' => $clientes,
            'consultores' => $consultores,
        ];
        return view('desempenho.index', $data);
    }

    public function ajaxShowConsultores(Request $request)
    {
        // return response()->json([view('ajax.consultores')->render()], 200);
        return response()->json($request->all(), 200);
    }
}
