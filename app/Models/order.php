<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = ['customer_id', 'name', 'email', 'phone', 'address', 'status'];
    use HasFactory;
}
