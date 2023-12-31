<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table="profiles";
    protected $fillable=["logo","name","email","mobile_number","phone_number","description"];
}
