<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
    use HasFactory;

    protected $table = 'actives';
    protected $fillable = ['equipment','model','features','warranty','serie','stock'];
    public $timestamps = false;

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    #relacion muchos a muchos (Tabla pivote)
    public function suppliy()
    {
        return $this->belongsToMany(Supply::class,'active_supplie')
        ->withPivot('active_id','supplie_id');
    }
}
