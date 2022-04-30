<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $table = 'permissao_sistema';

    protected $fillable = [
        'co_usuario',
        'co_tipo_usuario',
        'co_sistema',
        'in_ativo',
        'co_usuario_atualizacao',
        'dt_atualizacao',
    ];

    protected $primary = 'co_usuario';

    public function usuarios(){
        return $this->hasMany(Usuario::class, 'co_usuario', 'co_usuario');
    }

    public function usuario(){
        return $this->hasOne(Usuario::class, 'co_usuario', 'co_usuario');
    }
}
