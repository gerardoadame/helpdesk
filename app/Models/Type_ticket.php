<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_ticket extends Model
{
    use HasFactory;

    protected $table = 'type_tickets';
    protected $fillable = ['type'];
    public $timestamps = false;

}
