<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table="discounts";
    protected $fillable=["percent","start","finish","product_id"];
    public function Product(){
        return $this->belongsTo(Product::class);
    }
}
