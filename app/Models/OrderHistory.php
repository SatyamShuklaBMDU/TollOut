<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'order_histories';
    protected $fillable = [
        'customer_id',
        'product_id',
        'name',
        'email',
        'phone_no',
        'allternate_no',
        'address',
        'pincode',
        'status'
    ];
    public function product(){
        return $this->belongsTo(ProductsForRedeem::class,'product_id','id');
    }


}
