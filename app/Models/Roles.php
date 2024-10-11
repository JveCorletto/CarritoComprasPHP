<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'Roles';
    protected $primaryKey = 'IdRol';
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'IdEstado', 'IdEstado');
    }
}