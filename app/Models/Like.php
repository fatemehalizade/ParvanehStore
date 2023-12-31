<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table="likes";
    protected $fillable=["count","product_id"];
    public function Product(){
        return $this->belongsTo(Product::class);
    }
    public function User(){
        return $this->belongsToMany(User::class,"like_user");
    }
    public function LikeUser(){
        return $this->hasMany(LikeUser::class);
    }
}
