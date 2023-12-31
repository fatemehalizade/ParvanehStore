<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table="categories";
    protected $fillable=["name","level","nick_name","category_id"];
    public function ProductInfo(){
        return $this->hasMany(Product_info::class);
    }
}
