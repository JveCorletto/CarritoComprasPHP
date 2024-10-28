<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprobantesCompras extends Model
{
    protected $table = 'ComprobantesCompras';
    protected $primaryKey = 'IdComprobante';
    public $timestamps = false;

    protected $fillable = [
        'OrdenCompra',
        'TokenPago',
        'FechaTransaccion',
        'LinkComprobante',
    ];
}