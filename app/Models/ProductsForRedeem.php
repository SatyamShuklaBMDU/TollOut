<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsForRedeem extends Model
{
    use HasFactory;
    protected $table = 'products_for_redeems';
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'status',
        ];
}
