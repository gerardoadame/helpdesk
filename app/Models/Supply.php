<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $table = 'supplies';
    protected $fillable = ['name','description','quantity','provider_id'];
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

    public function bill()
    {
        return $this->belongsToMany(Bill::class,'bill_supplie')
        ->withPivot('supplie_id','bill_id');
    }
}
