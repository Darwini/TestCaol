<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    protected $table = 'cao_fatura';

    protected $fillable = [
        'co_fatura',
        'co_cliente',
        'co_sistema',
        'co_os',
        'num_nf',
        'total',
        'valor',
        'data_emissao',
        'corpo_nf',
        'comissao_nf',
        'total_imp_inc',
    ];

    protected $primary = 'co_fatura';
}
