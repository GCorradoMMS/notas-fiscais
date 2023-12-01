<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaFiscal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notas_fiscais';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    
    protected $fillable = [
        'usuario_id',
        'numero',
        'valor',
        'data_emissao',
        'cnpj_remetente',
        'nome_rementente',
        'cnpj_transportador',
        'nome_transportador',
    ];
}
