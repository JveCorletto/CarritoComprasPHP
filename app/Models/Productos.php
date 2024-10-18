<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use HasFactory;

    protected $table = 'Productos';
    protected $primaryKey = 'IdProducto';
    public $timestamps = false;

    protected $fillable = [
        'IdCategoria',
        'Producto',
        'Descripcion',
        'Imagen',
        'Precio',
        'Stock',
        'UsuarioCreacion',
        'FechaCreacion',
        'UsuarioModificacion',
        'FechaModificacion',
        'Estado'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'IdCategoria', 'IdCategoria');
    }
}