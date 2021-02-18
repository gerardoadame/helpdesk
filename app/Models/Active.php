<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
    use HasFactory;

    protected $table = 'actives';
    protected $fillable = ['equipment','model','features','warranty','serie','stock'];
    public $timestamps = false;

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
