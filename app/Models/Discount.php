<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable=['name','code','value','start_date','end_date','quantity','used_count'];
    public function birthdays()
    {
        return $this->hasMany(Birthday::class);
    }

}
