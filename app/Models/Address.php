<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','address','default_address','city_province','note'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
