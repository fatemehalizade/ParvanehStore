<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table="galleries";
    protected $fillable=["image","product_id"];
    public function Product(){
        return $this->belongsTo(Product::class);
    }
}
