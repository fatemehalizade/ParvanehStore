<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    use HasFactory;
    protected $table="producers";
    protected $fillable=["image","producer"];
    public function ProductInfo(){
        return $this->hasMany(Product_info::class);
    }
}
