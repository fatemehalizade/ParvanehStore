<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package_Type extends Model
{
    use HasFactory;
    protected $table="package_types";
    protected $fillable=["type"];
    public function ProductInfo(){
        return $this->hasMany(Product_info::class);
    }
}
