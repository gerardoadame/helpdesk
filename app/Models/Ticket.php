<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $fillable = ['subject','time','description','image','created_at','modified_at','employed_id','status_id','type_id','priority_id','technical_id','score_usr','score_tech'];
    // public $timestamps = false;

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function priorities()
    {
        return $this->belongsTo(Priority::class);
    }

    public function types()
    {
        return $this->belongsTo(Type_ticket::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function reply()
    {
        return $this->hasMany(Reply::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}
