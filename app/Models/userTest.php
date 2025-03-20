<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userTest extends Model
{
    protected $table = "userTest";
    protected $primaryKey = "id";
    protected $fillable = ["name", "email", "password", "role"];
    public $timestamps = false;
    protected $attributes = [
        "name" => "",
        "email" => "",
        "password" => "",
        "role" => "user"
    ];
}
