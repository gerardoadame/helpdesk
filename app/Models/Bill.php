<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';
    protected $fillable = ['name','price','begin','end','location'];
    public $timestamps = false;

    public function service()
    {
        return $this->belongsToMany(Bill::class,'bill_service')
        ->withPivot('bill_id','service_id');
    }

    public function software()
    {
        return $this->belongsToMany(Software::class,'bill_software')
        ->withPivot('bill_id','software_id');
    }

    public function active()
    {
        return $this->belongsToMany(Active::class,'active_bill')
        ->withPivot('bill_id','active_id');
    }

    public function supply()
    {
        return $this->belongsToMany(Supply::class,'bill_supplie')
        ->withPivot('bill_id','supplie_id');
    }
}
