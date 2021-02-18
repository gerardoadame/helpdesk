<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $fillable = ['payment'];
    public $timestamps = false;

    public function software()
    {
        return $this->hasMany(Software::class);
    }

    public function active()
    {
        return $this->hasMany(Active::class);
    }

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
