<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'last_name', 'address', 'password'];

    public function emails()
    {
        return $this->hasMany('App\Models\Email');
    }
}