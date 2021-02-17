<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $fillable = ['name','last_name','age','address','phone','employment'];
    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
