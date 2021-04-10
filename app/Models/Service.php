<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = ['concept','provider_id','payment_id'];
    public $timestamps = false;

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function bill()
    {
        return $this->belongsToMany(Bill::class,'bill_service')
        ->withPivot('service_id','bill_id');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
