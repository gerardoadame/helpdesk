<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';
    protected $fillable = ['content','image','ticket_id','created_at','updated_at'];
    // public $timestamps = false;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
