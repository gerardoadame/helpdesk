<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';
    protected $fillable = ['company','contact','phone','celphone','address'];
    public $timestamps = false;

    public function software()
    {
        return $this->hasMany(Software::class);
    }
    
    public function supply()
    {
        return $this->hasMany(Supply::class);
    }
}
