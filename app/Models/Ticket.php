<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $fillable = ['subject','estimation','description','image','created_at','modified_at','employed_id','status_id','type_id','priority_id','technical_id'];
    // public $timestamps = false;

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function priorities()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function type()
    {
        return $this->belongsTo(Type_ticket::class);
    }

    public function agent() { //technical
        return $this->belongsTo(Person::class, 'technical_id');
    }

    public function client() {
        return $this->belongsTo(Person::class, 'employed_id');
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
