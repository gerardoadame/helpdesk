<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $fillable = ['status'];
    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
