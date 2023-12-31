<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table="comments";
    protected $fillable=["comment","user_id","product_id","status","comment_id"];
    public function Product(){
        return $this->belongsTo(Product::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
}
