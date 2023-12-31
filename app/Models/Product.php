<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="products";
    protected $fillable=["code","count","price"];
    public function Tag(){
        return $this->belongsToMany(Tag::class,"product_tag");
    }
    public function ProductInfo(){
        return $this->hasOne(Product_info::class);
    }
    public function Discount(){
        return $this->hasOne(Discount::class);
    }
    public function Gallery(){
        return $this->hasMany(Gallery::class);
    }
    public function Comment(){
        return $this->hasMany(Comment::class);
    }
    public function Score(){
        return $this->hasMany(Score::class);
    }
    public function Like(){
        return $this->hasMany(Like::class);
    }
    public function Order(){
        return $this->hasMany(Order::class);
    }
}
