<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $fillable = ['subject','time','created_at','modified_at','description','client_image','feedback','technical_image','employed_id','status_id','type_id','priority_id','technical_id'];
    //public $timestamps = false;

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
}
