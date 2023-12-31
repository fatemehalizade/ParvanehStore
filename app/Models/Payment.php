<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table="payments";
    protected $fillable=["card_number","transaction_number","status","factor_id"];
    public function Factor(){
        return $this->belongsTo(Factor::class);
    }
}
