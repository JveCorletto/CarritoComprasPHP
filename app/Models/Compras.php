<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    use HasFactory;

    protected $table = 'Compras';
    protected $primaryKey = 'IdCompra';
    public $timestamps = false;

    protected $fillable = [
        'IdEstadoCompra',
        'IdUsuario',
        'FechaCompra',
        'TotalCompra',
    ];

    public function estadoCompra()
    {
        return $this->belongsTo(EstadosCompras::class, 'IdEstadoCompra');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'IdUsuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetallesCompras::class, 'IdCompra');
    }
}