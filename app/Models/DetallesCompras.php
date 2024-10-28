<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesCompras extends Model
{
    use HasFactory;

    protected $table = 'DetallesCompras';
    protected $primaryKey = 'IdDetalleCompra';
    public $timestamps = false;

    protected $fillable = [
        'IdCompra',
        'IdProducto',
        'Cantidad',
        'PrecioUnitario',
        'SubTotal',
    ];

    public function compra()
    {
        return $this->belongsTo(Compras::class, 'IdCompra');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'IdProducto', 'IdProducto');
    }
}