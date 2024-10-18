<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorias extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'Categorias';
    protected $primaryKey = 'IdCategoria';

    protected $fillable = [
        'Categoria'
    ];

    public function productos()
    {
        return $this->hasMany(Productos::class, 'IdCategoria', 'IdCategoria');
    }
}