<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDetail extends Model
{

    protected $fillable =  ['order_id', 'product_id', 'quantity', 'price', 'variant_id'];
    use HasFactory;
}
