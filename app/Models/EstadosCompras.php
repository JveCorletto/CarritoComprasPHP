<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosCompras extends Model
{
    use HasFactory;

    protected $table = 'EstadosCompras';
    protected $primaryKey = 'IdEstadoCompra';
    public $timestamps = false;

    protected $fillable = [
        'EstadoCompra',
    ];
}