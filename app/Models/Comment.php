<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['image','user_id','ticket_id','created_at','updated_at'];
    // public $timestamps = false;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
