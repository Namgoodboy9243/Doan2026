<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable = ['name', 'price', 'sale_price', 'image', 'category_id', 'status', 'description'];
    use HasFactory;
}
