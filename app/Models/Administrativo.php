<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    use HasFactory;

    protected $table = 'administrativo';
    public $timestamps = false;
    protected $primaryKey = 'id_administrativo';

    protected $guarded = [];

    # relaciones

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
