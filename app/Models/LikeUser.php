<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeUser extends Model
{
    use HasFactory;
    protected $table="like_user";
    protected $fillable=["like_id","user_id"];
    public function Like(){
        return $this->belongsTo(Like::class);
    }
}
