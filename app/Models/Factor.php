<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    use HasFactory;
    protected $table="factors";
    protected $fillable=["factor_code","status","user_id"];
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Order(){
        return $this->belongsToMany(Order::class,"factor_order");
    }
    public function Payment(){
        return $this->hasOne(Payment::class);
    }
}
