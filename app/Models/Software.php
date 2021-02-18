<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $table = 'software';
    protected $fillable = ['quantity','description',];
    public $timestamps = false;

    public function providers()
    {
        return $this->belongsTo(Provider::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
