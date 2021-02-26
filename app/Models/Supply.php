<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $table = 'supplies';
    protected $fillable = ['name','description','quantity','price_u','date'];
    public $timestamps = false;

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    #Relacion muchos a muchos (Tabla pivote).
    public function active()
    {
        return $this->belongsToMany(Active::class,'active_supplie')
        ->withPivot('supply_id','active_id');
    }
}
