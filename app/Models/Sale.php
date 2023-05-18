<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'start_date', 'end_date'];
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
