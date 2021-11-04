<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class Person extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'persons';
    public $timestamps = false;

    protected $fillable = [
    	'name',
    	'last_name',
    	'is_agent',
    	'birth',
    	'address',
    	'phone',
    	'employment',
    	'email',
        'area_id',
        'avatar',
    ];

    /**
     * Get base64 avatar
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        $avatarPath = $this->attributes['avatar'];
        $image = Storage::get(
            ($avatarPath && Storage::exists($avatarPath))
            ? $avatarPath
            : 'default/avatar.png');

        $type = pathinfo(storage_path($avatarPath), PATHINFO_EXTENSION);

        return 'data:image/' . $type . ';base64, ' . base64_encode($image);
    }

    public function user() {
        return $this->hasOne(User::class);
    }

    public function tickets_employed()
    {
        return $this->hasMany(Ticket::class,'employed_id','id');

    }

    public function area(){
        return $this->belongsTo(Area::class,"area_id");
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'employed_id','id');

    }

    public function tickets_technical()
    {
        return $this->hasMany(Ticket::class,'technical_id','id');
    }
}
