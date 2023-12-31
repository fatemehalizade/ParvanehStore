<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table="orders";
    protected $fillable=["product_id","product_count","status","off","price"];
    public function Factor(){
        return $this->belongsToMany(Factor::class,"factor_order");
    }
    public function Product(){
        return $this->belongsTo(Product::class);
    }
}
