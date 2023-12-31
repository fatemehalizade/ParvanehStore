<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_info extends Model
{
    use HasFactory;
    protected $table="product_infos";
    protected $fillable=["name","weight","health_licence_number","category_id","barnd_id","producer_id",
    "package_type_id","product_id","image","tags","description"];
    public function Product(){
        return $this->belongsTo(Product_info::class);
    }
    public function Category(){
        return $this->belongsTo(Category::class);
    }
    public function Brand(){
        return $this->belongsTo(Brand::class);
    }
    public function PackageType(){
        return $this->belongsTo(Package_type::class);
    }
    public function Producer(){
        return $this->belongsTo(Producer::class);
    }
}
