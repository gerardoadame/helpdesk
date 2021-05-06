<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Person extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'persons';
    public $timestamps = false;

    protected $fillable = [
    	'name',
    	'last_name',
    	'birth',
    	'address',
    	'phone',
    	'employment',
        'user_id',
        'area_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function tickets_employed()
    {
        return $this->hasMany(Ticket::class,'employed_id','id');

    }

    public function area(){
        return $this->belongsTo(Area::class,"area_id");
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'employed_id','id');

    }

    public function tickets_technical()
    {
        return $this->hasMany(Ticket::class,'technical_id','id');
    }
}
